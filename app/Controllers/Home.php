<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\ModuleModel;
use App\Models\LessonModel;

class Home extends BaseController
{
    public function python()
    {
        return redirect()->to('/courses/python-programming');
    }

    public function javascript()
    {
        return redirect()->to('/courses/javascript-programming');
    }

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
        
        // SEO data
        $data['seo'] = [
            'title' => 'Free Online Learning Platform - Learn Programming & More',
            'description' => 'Join thousands of learners on our free online learning platform. Master Python, JavaScript, web development, and more with interactive courses, lessons, and hands-on projects. Start learning today!',
            'keywords' => 'free online learning, programming courses, Python tutorial, JavaScript tutorial, web development, coding courses, learn programming online, free coding classes',
            'url' => base_url(),
            'type' => 'website'
        ];
        
        // Also set title for backward compatibility
        $data['title'] = 'Free Online Learning Platform - Learn Programming & More';
        
        return $this->render('home', $data);
    }
}

