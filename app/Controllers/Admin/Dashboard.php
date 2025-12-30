<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\UserModel;
use App\Models\UserProgressModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $courseModel = new CourseModel();
        $userModel = new UserModel();
        $progressModel = new UserProgressModel();
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $lessonModel = new \App\Models\LessonModel();
        $moduleModel = new \App\Models\ModuleModel();
        
        // System statistics
        $data['total_courses'] = $courseModel->countAllResults();
        $data['published_courses'] = $courseModel->where('status', 'published')->countAllResults();
        $data['draft_courses'] = $courseModel->where('status', 'draft')->countAllResults();
        $data['total_users'] = $userModel->countAllResults();
        $data['total_students'] = $userModel->where('role', 'student')->countAllResults();
        $data['total_instructors'] = $userModel->where('role', 'instructor')->countAllResults();
        $data['total_progress'] = $progressModel->where('status', 'completed')->countAllResults();
        $data['total_enrollments'] = $enrollmentModel->countAllResults();
        $data['active_enrollments'] = $enrollmentModel->where('status', 'enrolled')->countAllResults();
        $data['total_lessons'] = $lessonModel->countAllResults();
        $data['published_lessons'] = $lessonModel->where('status', 'published')->countAllResults();
        $data['total_modules'] = $moduleModel->countAllResults();
        
        // Recent courses
        $data['recent_courses'] = $courseModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        
        // Recent users
        $data['recent_users'] = $userModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        
        return $this->render('admin/dashboard', $data);
    }
}

