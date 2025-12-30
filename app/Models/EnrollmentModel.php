<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'course_id',
        'status',
        'enrolled_at',
        'completed_at',
        'progress_percentage',
        'last_accessed_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'user_id'   => 'required|integer',
        'course_id' => 'required|integer',
        'status'    => 'permit_empty|in_list[enrolled,completed,dropped]',
    ];

    /**
     * Check if user is enrolled in a course
     */
    public function isEnrolled(int $userId, int $courseId): bool
    {
        $enrollment = $this->where('user_id', $userId)
                          ->where('course_id', $courseId)
                          ->where('status', 'enrolled')
                          ->first();
        
        return $enrollment !== null;
    }

    /**
     * Get user enrollments
     */
    public function getUserEnrollments(int $userId, string $status = 'enrolled')
    {
        $builder = $this->where('user_id', $userId);
        
        if ($status !== 'all') {
            $builder->where('status', $status);
        }
        
        return $builder->orderBy('enrolled_at', 'DESC')
                      ->findAll();
    }

    /**
     * Get course enrollments count
     */
    public function getCourseEnrollmentCount(int $courseId, string $status = 'enrolled'): int
    {
        $builder = $this->where('course_id', $courseId);
        
        if ($status !== 'all') {
            $builder->where('status', $status);
        }
        
        return $builder->countAllResults();
    }

    /**
     * Enroll user in course
     */
    public function enrollUser(int $userId, int $courseId): bool
    {
        // Check if already enrolled
        if ($this->isEnrolled($userId, $courseId)) {
            return false;
        }

        $data = [
            'user_id'       => $userId,
            'course_id'     => $courseId,
            'status'        => 'enrolled',
            'enrolled_at'   => date('Y-m-d H:i:s'),
            'progress_percentage' => 0.00,
        ];

        return $this->insert($data) !== false;
    }

    /**
     * Update enrollment progress
     */
    public function updateProgress(int $userId, int $courseId, float $percentage): bool
    {
        return $this->where('user_id', $userId)
                   ->where('course_id', $courseId)
                   ->set([
                       'progress_percentage' => $percentage,
                       'last_accessed_at'    => date('Y-m-d H:i:s'),
                   ])
                   ->update() !== false;
    }

    /**
     * Mark course as completed
     */
    public function markCompleted(int $userId, int $courseId): bool
    {
        return $this->where('user_id', $userId)
                   ->where('course_id', $courseId)
                   ->set([
                       'status'        => 'completed',
                       'completed_at'  => date('Y-m-d H:i:s'),
                       'progress_percentage' => 100.00,
                   ])
                   ->update() !== false;
    }

    /**
     * Get enrollment with course details
     */
    public function getEnrollmentWithCourse(int $userId, int $courseId)
    {
        $enrollment = $this->where('user_id', $userId)
                          ->where('course_id', $courseId)
                          ->first();
        
        if (!$enrollment) {
            return null;
        }

        $courseModel = new CourseModel();
        $enrollment['course'] = $courseModel->find($courseId);

        return $enrollment;
    }
}

