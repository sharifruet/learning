<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Enrollment extends BaseController
{
    protected $enrollmentModel;
    protected $courseModel;

    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
        $this->courseModel = new CourseModel();
    }

    /**
     * Enroll in a course (one-click enrollment)
     */
    public function enroll($courseId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Please log in to enroll in courses.');
        }

        $userId = session()->get('user_id');
        $course = $this->courseModel->find($courseId);

        if (!$course) {
            return redirect()->to('/courses')
                ->with('error', 'Course not found.');
        }

        // Check if course is published
        if ($course['status'] !== 'published') {
            return redirect()->to('/courses')
                ->with('error', 'This course is not available for enrollment.');
        }

        // Check enrollment type
        if ($course['enrollment_type'] === 'closed') {
            return redirect()->back()
                ->with('error', 'This course is closed for enrollment.');
        }

        // Check if already enrolled
        if ($this->enrollmentModel->isEnrolled($userId, $courseId)) {
            return redirect()->to('/courses/' . $courseId)
                ->with('info', 'You are already enrolled in this course.');
        }

        // Check capacity (if set)
        if (!empty($course['capacity'])) {
            $currentEnrollments = $this->enrollmentModel->getCourseEnrollmentCount($courseId);
            if ($currentEnrollments >= $course['capacity']) {
                return redirect()->back()
                    ->with('error', 'This course has reached its enrollment capacity.');
            }
        }

        // Enroll user
        if ($this->enrollmentModel->enrollUser($userId, $courseId)) {
            // Update last accessed
            $this->enrollmentModel->updateProgress($userId, $courseId, 0.00);
            
            return redirect()->to('/courses/' . $courseId)
                ->with('success', 'Successfully enrolled in ' . $course['title'] . '!');
        }

        return redirect()->back()
            ->with('error', 'Failed to enroll. Please try again.');
    }

    /**
     * Unenroll from a course
     */
    public function unenroll($courseId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        
        $enrollment = $this->enrollmentModel->where('user_id', $userId)
                                           ->where('course_id', $courseId)
                                           ->first();

        if (!$enrollment) {
            return redirect()->to('/dashboard')
                ->with('error', 'You are not enrolled in this course.');
        }

        // Update status to dropped
        $this->enrollmentModel->update($enrollment['id'], [
            'status' => 'dropped',
        ]);

        return redirect()->to('/dashboard')
            ->with('success', 'Successfully unenrolled from the course.');
    }
}

