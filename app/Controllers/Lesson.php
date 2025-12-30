<?php

namespace App\Controllers;

use App\Models\LessonModel;
use App\Models\ExerciseModel;
use App\Models\UserProgressModel;
use App\Models\CodeSubmissionModel;
use App\Models\CourseModel;
use App\Models\ModuleModel;

class Lesson extends BaseController
{
    public function view($courseId, $moduleId, $lessonId)
    {
        $lessonModel = new LessonModel();
        $lesson = $lessonModel->getLessonWithExercises($lessonId);
        
        if (!$lesson || $lesson['course_id'] != $courseId || $lesson['module_id'] != $moduleId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $courseModel = new CourseModel();
        $moduleModel = new ModuleModel();
        
        $course = $courseModel->find($courseId);
        $module = $moduleModel->find($moduleId);
        
        $userId = session()->get('user_id');
        $progressModel = new UserProgressModel();
        $bookmarkModel = new \App\Models\BookmarkModel();
        
        // Update last accessed time
        $progressModel->updateLastAccessed($userId, $lessonId, $courseId, $moduleId);
        
        // Check if lesson is completed
        $progress = $progressModel->where('user_id', $userId)
                                  ->where('lesson_id', $lessonId)
                                  ->first();
        
        // Check if bookmarked
        $isBookmarked = $bookmarkModel->isBookmarked($userId, $lessonId);
        
        // Get previous and next lessons
        $navigation = $this->getLessonNavigation($courseId, $moduleId, $lessonId);
        
        $data['course'] = $course;
        $data['module'] = $module;
        $data['lesson'] = $lesson;
        $data['progress'] = $progress;
        $data['is_completed'] = $progress && $progress['status'] === 'completed';
        $data['is_bookmarked'] = $isBookmarked;
        $data['navigation'] = $navigation;
        
        return $this->render('lessons/view', $data);
    }

    /**
     * Get previous and next lesson navigation
     */
    private function getLessonNavigation($courseId, $moduleId, $lessonId)
    {
        $lessonModel = new LessonModel();
        $moduleModel = new ModuleModel();
        
        // Get all modules for course
        $modules = $moduleModel->where('course_id', $courseId)
                              ->orderBy('sort_order', 'ASC')
                              ->findAll();
        
        $allLessons = [];
        foreach ($modules as $mod) {
            $lessons = $lessonModel->where('module_id', $mod['id'])
                                  ->where('status', 'published')
                                  ->orderBy('sort_order', 'ASC')
                                  ->findAll();
            
            foreach ($lessons as $les) {
                $allLessons[] = [
                    'id' => $les['id'],
                    'title' => $les['title'],
                    'module_id' => $les['module_id'],
                    'course_id' => $les['course_id'],
                ];
            }
        }
        
        $currentIndex = -1;
        foreach ($allLessons as $index => $les) {
            if ($les['id'] == $lessonId) {
                $currentIndex = $index;
                break;
            }
        }
        
        $navigation = [
            'previous' => null,
            'next' => null,
        ];
        
        if ($currentIndex > 0) {
            $prevLesson = $allLessons[$currentIndex - 1];
            $navigation['previous'] = [
                'id' => $prevLesson['id'],
                'title' => $prevLesson['title'],
                'url' => base_url('courses/' . $prevLesson['course_id'] . '/module/' . $prevLesson['module_id'] . '/lesson/' . $prevLesson['id']),
            ];
        }
        
        if ($currentIndex >= 0 && $currentIndex < count($allLessons) - 1) {
            $nextLesson = $allLessons[$currentIndex + 1];
            $navigation['next'] = [
                'id' => $nextLesson['id'],
                'title' => $nextLesson['title'],
                'url' => base_url('courses/' . $nextLesson['course_id'] . '/module/' . $nextLesson['module_id'] . '/lesson/' . $nextLesson['id']),
            ];
        }
        
        return $navigation;
    }

    /**
     * Toggle bookmark
     */
    public function toggleBookmark($courseId, $moduleId, $lessonId)
    {
        $userId = session()->get('user_id');
        $bookmarkModel = new \App\Models\BookmarkModel();
        
        $bookmarkModel->toggleBookmark($userId, $lessonId);
        
        return redirect()->back()->with('success', 'Bookmark updated');
    }

    /**
     * Mark lesson as complete
     */
    public function markComplete($courseId, $moduleId, $lessonId)
    {
        $userId = session()->get('user_id');
        $progressModel = new UserProgressModel();
        
        $progressModel->markLessonComplete($userId, $lessonId, $courseId, $moduleId);
        
        // Update course progress
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $courseProgress = $progressModel->getCourseProgress($userId, $courseId);
        $enrollmentModel->updateProgress($userId, $courseId, $courseProgress['percentage']);
        
        return redirect()->back()->with('success', 'Lesson marked as complete!');
    }

    /**
     * Track time spent on lesson (AJAX)
     */
    public function trackTime($courseId, $moduleId, $lessonId)
    {
        $userId = session()->get('user_id');
        $seconds = (int)$this->request->getPost('seconds', 0);
        
        if ($seconds > 0) {
            $progressModel = new UserProgressModel();
            $progressModel->addTimeSpent($userId, $lessonId, $seconds);
        }
        
        return $this->response->setJSON(['success' => true]);
    }

    public function submitExercise($courseId, $moduleId, $lessonId)
    {
        $exerciseId = $this->request->getPost('exercise_id');
        $code = $this->request->getPost('code');
        
        if (!$exerciseId || !$code) {
            return redirect()->back()->with('error', 'Exercise ID and code are required');
        }
        
        $exerciseModel = new ExerciseModel();
        $exercise = $exerciseModel->find($exerciseId);
        
        if (!$exercise || $exercise['lesson_id'] != $lessonId) {
            return redirect()->back()->with('error', 'Invalid exercise');
        }
        
        $userId = session()->get('user_id');
        $submissionModel = new CodeSubmissionModel();
        
        // Save submission
        $submissionData = [
            'user_id'    => $userId,
            'exercise_id' => $exerciseId,
            'code'       => $code,
            'status'     => 'submitted',
        ];
        
        $submissionId = $submissionModel->insert($submissionData);
        
        // Simple validation (in production, you'd run actual Python code)
        $isCorrect = false;
        if ($exercise['solution_code']) {
            // Basic string comparison (in production, use actual code execution)
            $isCorrect = trim($code) === trim($exercise['solution_code']);
        }
        
        // Update submission status
        $submissionModel->update($submissionId, [
            'status' => $isCorrect ? 'passed' : 'failed',
            'output' => $isCorrect ? 'Correct!' : 'Please check your code',
        ]);
        
        // Mark lesson as completed if exercise is correct
        if ($isCorrect) {
            $progressModel = new UserProgressModel();
            $progressModel->markLessonComplete($userId, $lessonId, $courseId, $moduleId);
        }
        
        return redirect()->back()->with(
            $isCorrect ? 'success' : 'error',
            $isCorrect ? 'Congratulations! Exercise completed successfully.' : 'Your code needs adjustment. Please try again.'
        );
    }
}

