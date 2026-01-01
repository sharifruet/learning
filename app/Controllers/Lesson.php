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
    public function view($courseSlug, $moduleId, $lessonId)
    {
        $courseModel = new CourseModel();
        $lessonModel = new LessonModel();
        
        // Find course by slug
        $course = $courseModel->findBySlug($courseSlug);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $courseId = $course['id'];
        $lesson = $lessonModel->getLessonWithExercises($lessonId);
        
        if (!$lesson || $lesson['course_id'] != $courseId || $lesson['module_id'] != $moduleId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $moduleModel = new ModuleModel();
        $module = $moduleModel->find($moduleId);
        
        $userId = session()->get('user_id');
        $progressModel = new UserProgressModel();
        $bookmarkModel = new \App\Models\BookmarkModel();
        
        // Update last accessed time (only if user is logged in)
        if ($userId) {
            $progressModel->updateLastAccessed($userId, $lessonId, $courseId, $moduleId);
        }
        
        // Check if lesson is completed (only if user is logged in)
        $progress = null;
        if ($userId) {
            $progress = $progressModel->where('user_id', $userId)
                                      ->where('lesson_id', $lessonId)
                                      ->first();
        }
        
        // Check if bookmarked (only if user is logged in)
        $isBookmarked = false;
        if ($userId) {
            $isBookmarked = $bookmarkModel->isBookmarked($userId, $lessonId);
        }
        
        // Get previous and next lessons
        $navigation = $this->getLessonNavigation($courseId, $moduleId, $lessonId, $courseSlug);
        
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
    private function getLessonNavigation($courseId, $moduleId, $lessonId, $courseSlug)
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
                'url' => base_url('courses/' . $courseSlug . '/module/' . $prevLesson['module_id'] . '/lesson/' . $prevLesson['id']),
            ];
        }
        
        if ($currentIndex >= 0 && $currentIndex < count($allLessons) - 1) {
            $nextLesson = $allLessons[$currentIndex + 1];
            $navigation['next'] = [
                'id' => $nextLesson['id'],
                'title' => $nextLesson['title'],
                'url' => base_url('courses/' . $courseSlug . '/module/' . $nextLesson['module_id'] . '/lesson/' . $nextLesson['id']),
            ];
        }
        
        return $navigation;
    }

    /**
     * Toggle bookmark
     */
    public function toggleBookmark($courseSlug, $moduleId, $lessonId)
    {
        $userId = session()->get('user_id');
        $bookmarkModel = new \App\Models\BookmarkModel();
        
        $bookmarkModel->toggleBookmark($userId, $lessonId);
        
        return redirect()->back()->with('success', 'Bookmark updated');
    }

    /**
     * Mark lesson as complete
     */
    public function markComplete($courseSlug, $moduleId, $lessonId)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->findBySlug($courseSlug);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $courseId = $course['id'];
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
    public function trackTime($courseSlug, $moduleId, $lessonId)
    {
        $userId = session()->get('user_id');
        $seconds = (int)$this->request->getPost('seconds', 0);
        
        if ($seconds > 0) {
            $progressModel = new UserProgressModel();
            $progressModel->addTimeSpent($userId, $lessonId, $seconds);
        }
        
        return $this->response->setJSON(['success' => true]);
    }

    public function submitExercise($courseSlug, $moduleId, $lessonId)
    {
        // Exercise submission requires login
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/auth/login')
                ->with('error', 'Please login to submit exercises.');
        }
        
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
            $courseModel = new CourseModel();
            $course = $courseModel->findBySlug($courseSlug);
            $courseId = $course ? $course['id'] : null;
            
            $progressModel = new UserProgressModel();
            $progressModel->markLessonComplete($userId, $lessonId, $courseId, $moduleId);
        }
        
        return redirect()->back()->with(
            $isCorrect ? 'success' : 'error',
            $isCorrect ? 'Congratulations! Exercise completed successfully.' : 'Your code needs adjustment. Please try again.'
        );
    }
}

