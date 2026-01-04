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
        
        // SEO data
        $data['seo'] = [
            'title' => 'All Courses - Browse Free Online Courses',
            'description' => 'Browse our comprehensive catalog of free online courses. Learn Python, JavaScript, web development, and more. All courses are free, self-paced, and include interactive lessons.',
            'keywords' => 'free courses, online courses, programming courses, Python courses, JavaScript courses, web development courses, coding tutorials',
            'url' => base_url('courses'),
            'type' => 'website'
        ];
        
        return $this->render('courses/index', $data);
    }

    public function view($courseSlug)
    {
        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();
        
        // Find course by slug
        $course = $courseModel->getCourseWithDetailsBySlug($courseSlug);
        
        if (!$course || $course['status'] !== 'published') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $courseId = $course['id'];
        
        // Check if this is a parent course (has subcourses)
        $subcourses = $courseModel->getSubcoursesWithDetails($courseId);
        $isParentCourse = !empty($subcourses);
        
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
        if ($isEnrolled && $enrollment && !$isParentCourse) {
            // Only calculate progress for non-parent courses
            $progressModel = new UserProgressModel();
            $completedLessons = $progressModel->where('user_id', $userId)
                                            ->where('course_id', $courseId)
                                            ->where('status', 'completed')
                                            ->countAllResults();
            
            // Calculate progress percentage
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
        
        // For free courses, allow access without enrollment
        $canAccess = $isEnrolled || (isset($course['is_free']) && $course['is_free']);
        
        $data['course'] = $course;
        $data['isEnrolled'] = $isEnrolled;
        $data['canAccess'] = $canAccess;
        $data['enrollment'] = $enrollment;
        $data['enrollmentCount'] = $enrollmentCount;
        $data['progress'] = $progress;
        $data['subcourses'] = $subcourses;
        $data['isParentCourse'] = $isParentCourse;
        
        // SEO data
        $courseDescription = !empty($course['description']) ? $course['description'] : 'Learn ' . $course['title'] . ' with our comprehensive free online course.';
        $data['seo'] = [
            'title' => $course['title'],
            'description' => $courseDescription . (isset($enrollmentCount) && $enrollmentCount > 0 ? ' Join ' . $enrollmentCount . ' students learning this course.' : ''),
            'keywords' => $course['title'] . ', online course, free course, ' . $course['difficulty'] . ' programming, learn ' . $course['title'],
            'url' => base_url('courses/' . $course['slug']),
            'type' => 'article',
            'image' => !empty($course['image']) ? base_url($course['image']) : base_url('logo.png')
        ];
        
        return $this->render('courses/view', $data);
    }

    public function module($courseSlug, $moduleId)
    {
        $courseModel = new CourseModel();
        $moduleModel = new ModuleModel();
        
        // Find course by slug
        $course = $courseModel->findBySlug($courseSlug);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $courseId = $course['id'];
        $module = $moduleModel->getModuleWithLessons($moduleId);
        
        if (!$module || $module['course_id'] != $courseId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $userId = session()->get('user_id');
        $progressModel = new UserProgressModel();
        
        // Get completed lessons (only if user is logged in)
        $completedLessons = [];
        if ($userId) {
            $completedLessons = $progressModel->where('user_id', $userId)
                                              ->where('module_id', $moduleId)
                                              ->where('status', 'completed')
                                              ->findColumn('lesson_id');
            $completedLessons = $completedLessons ?: [];
        }
        
        $data['course'] = $course;
        $data['module'] = $module;
        $data['completed_lessons'] = $completedLessons;
        
        // SEO data
        $moduleDescription = !empty($module['description']) ? $module['description'] : 'Learn ' . $module['title'] . ' - Part of the ' . $course['title'] . ' course.';
        $data['seo'] = [
            'title' => $module['title'] . ' - ' . $course['title'],
            'description' => $moduleDescription . ' Free online module with interactive lessons and exercises.',
            'keywords' => $module['title'] . ', ' . $course['title'] . ', online module, free tutorial, programming module',
            'url' => base_url('courses/' . $courseSlug . '/module/' . $moduleId),
            'type' => 'article',
            'image' => !empty($course['image']) ? base_url($course['image']) : base_url('logo.png')
        ];
        
        return $this->render('courses/module', $data);
    }
}

