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
        
        $data['total_courses'] = $courseModel->countAllResults();
        $data['published_courses'] = $courseModel->where('status', 'published')->countAllResults();
        $data['total_users'] = $userModel->countAllResults();
        $data['total_progress'] = $progressModel->where('status', 'completed')->countAllResults();
        
        return $this->render('admin/dashboard', $data);
    }
}

