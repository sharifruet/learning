<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\ModuleModel;
use App\Models\UserProgressModel;
use App\Models\EnrollmentModel;
use App\Models\CourseCategoryModel;

class Course extends BaseController
{
    public function index()
    {
        $courseModel = new CourseModel();
        $categoryModel = new CourseCategoryModel();
        
        // Get filters from request
        $filters = [
            'search' => $this->request->getGet('search'),
            'category_id' => $this->request->getGet('category'),
            'difficulty' => $this->request->getGet('difficulty'),
            'enrollment_type' => 'open', // Default: show open enrollment courses
        ];
        
        // Remove empty filters
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });
        
        $data['courses'] = $courseModel->getPublishedCourses($filters);
        $data['categories'] = $categoryModel->getAllCategories();
        $data['current_filters'] = $filters;
        
        return $this->render('courses/index', $data);
    }

    public function view($courseId)
    {
        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();
        
        $course = $courseModel->getCourseWithDetails($courseId);
        
        if (!$course || $course['status'] !== 'published') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $userId = session()->get('user_id');
        $isEnrolled = false;
        $enrollment = null;
        
        if ($userId) {
            $isEnrolled = $enrollmentModel->isEnrolled($userId, $courseId);
            if ($isEnrolled) {
                $enrollment = $enrollmentModel->getEnrollmentWithCourse($userId, $courseId);
            }
        }
        
        // Get enrollment count
        $enrollmentCount = $enrollmentModel->getCourseEnrollmentCount($courseId);
        
        // Get user progress if enrolled
        $progress = null;
        if ($isEnrolled && $enrollment) {
            $progressModel = new UserProgressModel();
            $completedLessons = $progressModel->where('user_id', $userId)
                                            ->where('course_id', $courseId)
                                            ->where('status', 'completed')
                                            ->countAllResults();
            
            // Calculate progress percentage (simplified - will be enhanced in Phase 1.4)
            $totalLessons = 0;
            if (!empty($course['modules'])) {
                foreach ($course['modules'] as $module) {
                    if (isset($module['lessons'])) {
                        $totalLessons += count($module['lessons']);
                    }
                }
            }
            
            $progress = [
                'completed' => $completedLessons,
                'total' => $totalLessons,
                'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0,
            ];
        }
        
        $data['course'] = $course;
        $data['isEnrolled'] = $isEnrolled;
        $data['enrollment'] = $enrollment;
        $data['enrollmentCount'] = $enrollmentCount;
        $data['progress'] = $progress;
        
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

