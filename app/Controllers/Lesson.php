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
        
        // Check if lesson is completed
        $progress = $progressModel->where('user_id', $userId)
                                  ->where('lesson_id', $lessonId)
                                  ->first();
        
        $data['course'] = $course;
        $data['module'] = $module;
        $data['lesson'] = $lesson;
        $data['progress'] = $progress;
        $data['is_completed'] = $progress && $progress['status'] === 'completed';
        
        return $this->render('lessons/view', $data);
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

