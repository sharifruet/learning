<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\ModuleModel;
use App\Models\UserProgressModel;

class Course extends BaseController
{
    public function index()
    {
        $courseModel = new CourseModel();
        $data['courses'] = $courseModel->getPublishedCourses();
        
        return $this->render('courses/index', $data);
    }

    public function view($courseId)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->getCourseWithModules($courseId);
        
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $userId = session()->get('user_id');
        $progressModel = new UserProgressModel();
        
        // Get user progress for this course
        $courseProgress = $progressModel->where('user_id', $userId)
                                        ->where('course_id', $courseId)
                                        ->where('status', 'completed')
                                        ->countAllResults();
        
        $data['course'] = $course;
        $data['progress'] = $courseProgress;
        
        return $this->render('courses/view', $data);
    }

    public function module($courseId, $moduleId)
    {
        $moduleModel = new ModuleModel();
        $module = $moduleModel->getModuleWithLessons($moduleId);
        
        if (!$module || $module['course_id'] != $courseId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $courseModel = new CourseModel();
        $course = $courseModel->find($courseId);
        
        $userId = session()->get('user_id');
        $progressModel = new UserProgressModel();
        
        // Get completed lessons
        $completedLessons = $progressModel->where('user_id', $userId)
                                          ->where('module_id', $moduleId)
                                          ->where('status', 'completed')
                                          ->findColumn('lesson_id');
        $completedLessons = $completedLessons ?: [];
        
        $data['course'] = $course;
        $data['module'] = $module;
        $data['completed_lessons'] = $completedLessons;
        
        return $this->render('courses/module', $data);
    }
}

