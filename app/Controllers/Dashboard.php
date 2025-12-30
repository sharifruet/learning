<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\UserProgressModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        
        $courseModel = new CourseModel();
        $progressModel = new UserProgressModel();
        
        $data['courses'] = $courseModel->getPublishedCourses();
        $data['user_progress'] = $progressModel->getUserProgress($userId);
        
        // Calculate progress for each course
        foreach ($data['courses'] as &$course) {
            $courseProgress = $progressModel->where('user_id', $userId)
                                            ->where('course_id', $course['id'])
                                            ->where('status', 'completed')
                                            ->countAllResults();
            $course['progress'] = $courseProgress;
        }
        
        return $this->render('dashboard/index', $data);
    }
}

