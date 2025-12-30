<?php

namespace App\Controllers;

use App\Models\CourseModel;

class Home extends BaseController
{
    public function index()
    {
        $courseModel = new CourseModel();
        $data['courses'] = $courseModel->getPublishedCourses();
        
        return view('home', $data);
    }
}

