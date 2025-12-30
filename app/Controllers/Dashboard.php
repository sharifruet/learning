<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\UserProgressModel;
use App\Models\EnrollmentModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userRole = session()->get('role');
        
        // Route to appropriate dashboard based on role
        if ($userRole === 'admin') {
            return redirect()->to('/admin');
        } elseif ($userRole === 'instructor') {
            return redirect()->to('/instructor');
        }
        
        // Student dashboard
        $enrollmentModel = new EnrollmentModel();
        $courseModel = new CourseModel();
        $progressModel = new UserProgressModel();
        
        // Get user's enrolled courses
        $enrollments = $enrollmentModel->getUserEnrollments($userId, 'enrolled');
        
        // Get course details for each enrollment
        $enrolledCourses = [];
        foreach ($enrollments as $enrollment) {
            $course = $courseModel->getCourseWithDetails($enrollment['course_id']);
            if ($course) {
                // Calculate progress
                $completedLessons = $progressModel->where('user_id', $userId)
                                                ->where('course_id', $course['id'])
                                                ->where('status', 'completed')
                                                ->countAllResults();
                
                // Count total lessons
                $totalLessons = 0;
                if (!empty($course['modules'])) {
                    foreach ($course['modules'] as $module) {
                        if (isset($module['lessons'])) {
                            $totalLessons += count($module['lessons']);
                        }
                    }
                }
                
                $course['enrollment'] = $enrollment;
                $course['progress'] = [
                    'completed' => $completedLessons,
                    'total' => $totalLessons,
                    'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0,
                ];
                
                $enrolledCourses[] = $course;
            }
        }
        
        // Get all published courses for "Browse Courses" section
        $allCourses = $courseModel->getPublishedCourses();
        
        // Get overall progress statistics
        $overallProgress = $progressModel->getOverallProgress($userId);
        
        // Get recent activity (last accessed lessons)
        $recentActivity = $progressModel->where('user_id', $userId)
                                       ->where('last_accessed_at IS NOT NULL')
                                       ->orderBy('last_accessed_at', 'DESC')
                                       ->limit(5)
                                       ->findAll();
        
        // Get bookmarked lessons
        $bookmarkModel = new \App\Models\BookmarkModel();
        $bookmarks = $bookmarkModel->getUserBookmarks($userId);
        
        $data['enrolledCourses'] = $enrolledCourses;
        $data['allCourses'] = $allCourses;
        $data['enrollmentCount'] = count($enrolledCourses);
        $data['overallProgress'] = $overallProgress;
        $data['recentActivity'] = $recentActivity;
        $data['bookmarks'] = $bookmarks;
        
        return $this->render('dashboard/index', $data);
    }
}

