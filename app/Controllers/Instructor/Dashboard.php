<?php

namespace App\Controllers\Instructor;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use App\Models\UserProgressModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        
        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();
        $lessonModel = new LessonModel();
        $moduleModel = new ModuleModel();
        $progressModel = new UserProgressModel();
        
        // Get instructor's courses
        $myCourses = $courseModel->where('instructor_id', $userId)
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        
        // Get statistics for each course
        $courseStats = [];
        $totalEnrollments = 0;
        $totalLessons = 0;
        $totalModules = 0;
        
        foreach ($myCourses as $course) {
            // Enrollment count
            $enrollmentCount = $enrollmentModel->where('course_id', $course['id'])
                                              ->where('status', 'enrolled')
                                              ->countAllResults();
            
            // Module count
            $moduleCount = $moduleModel->where('course_id', $course['id'])
                                      ->countAllResults();
            
            // Lesson count
            $lessonCount = $lessonModel->where('course_id', $course['id'])
                                      ->where('status', 'published')
                                      ->countAllResults();
            
            // Completed enrollments
            $completedEnrollments = $enrollmentModel->where('course_id', $course['id'])
                                                   ->where('status', 'completed')
                                                   ->countAllResults();
            
            $courseStats[] = [
                'course' => $course,
                'enrollments' => $enrollmentCount,
                'completed' => $completedEnrollments,
                'modules' => $moduleCount,
                'lessons' => $lessonCount,
            ];
            
            $totalEnrollments += $enrollmentCount;
            $totalLessons += $lessonCount;
            $totalModules += $moduleCount;
        }
        
        $data['myCourses'] = $courseStats;
        $data['totalCourses'] = count($myCourses);
        $data['totalEnrollments'] = $totalEnrollments;
        $data['totalLessons'] = $totalLessons;
        $data['totalModules'] = $totalModules;
        
        return $this->render('instructor/dashboard', $data);
    }
}

