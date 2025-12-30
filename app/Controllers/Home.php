<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\ModuleModel;
use App\Models\LessonModel;

class Home extends BaseController
{
    public function index()
    {
        $courseModel = new CourseModel();
        $moduleModel = new ModuleModel();
        $lessonModel = new LessonModel();
        
        $data['courses'] = $courseModel->getPublishedCourses();
        $data['courseCount'] = count($data['courses']);
        $data['totalModules'] = $moduleModel->countAllResults();
        $data['totalLessons'] = $lessonModel->countAllResults();
        
        // Get featured courses (first 3 published courses)
        $data['featuredCourses'] = array_slice($data['courses'], 0, 3);
        
        return view('home', $data);
    }
}

