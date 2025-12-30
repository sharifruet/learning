<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProgressModel extends Model
{
    protected $table            = 'user_progress';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'course_id',
        'module_id',
        'lesson_id',
        'exercise_id',
        'status',
        'score',
        'time_spent',
        'completed_at',
        'last_accessed_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUserProgress($userId, $lessonId = null, $courseId = null)
    {
        $builder = $this->where('user_id', $userId);
        
        if ($lessonId) {
            $builder->where('lesson_id', $lessonId);
        }
        
        if ($courseId) {
            $builder->where('course_id', $courseId);
        }
        
        return $builder->findAll();
    }

    public function markLessonComplete($userId, $lessonId, $courseId, $moduleId)
    {
        $data = [
            'user_id'     => $userId,
            'lesson_id'   => $lessonId,
            'course_id'   => $courseId,
            'module_id'   => $moduleId,
            'status'      => 'completed',
            'completed_at' => date('Y-m-d H:i:s'),
            'last_accessed_at' => date('Y-m-d H:i:s'),
        ];

        $existing = $this->where('user_id', $userId)
                         ->where('lesson_id', $lessonId)
                         ->first();

        if ($existing) {
            return $this->update($existing['id'], $data);
        }

        return $this->insert($data);
    }

    /**
     * Update last accessed time for a lesson
     */
    public function updateLastAccessed($userId, $lessonId, $courseId = null, $moduleId = null)
    {
        $data = [
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'last_accessed_at' => date('Y-m-d H:i:s'),
            'status' => 'in_progress',
        ];

        if ($courseId) {
            $data['course_id'] = $courseId;
        }
        if ($moduleId) {
            $data['module_id'] = $moduleId;
        }

        $existing = $this->where('user_id', $userId)
                         ->where('lesson_id', $lessonId)
                         ->first();

        if ($existing) {
            return $this->update($existing['id'], ['last_accessed_at' => $data['last_accessed_at']]);
        }

        return $this->insert($data);
    }

    /**
     * Add time spent to a lesson
     */
    public function addTimeSpent($userId, $lessonId, $seconds)
    {
        $existing = $this->where('user_id', $userId)
                         ->where('lesson_id', $lessonId)
                         ->first();

        if ($existing) {
            $currentTime = (int)($existing['time_spent'] ?? 0);
            return $this->update($existing['id'], [
                'time_spent' => $currentTime + $seconds
            ]);
        }

        return $this->insert([
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'time_spent' => $seconds,
            'status' => 'in_progress',
        ]);
    }

    /**
     * Get course progress percentage
     */
    public function getCourseProgress($userId, $courseId)
    {
        $lessonModel = new \App\Models\LessonModel();
        $moduleModel = new \App\Models\ModuleModel();

        // Get all modules for course
        $modules = $moduleModel->where('course_id', $courseId)->findAll();
        
        $totalLessons = 0;
        $completedLessons = 0;

        foreach ($modules as $module) {
            $lessons = $lessonModel->where('module_id', $module['id'])
                                  ->where('status', 'published')
                                  ->findAll();
            
            $totalLessons += count($lessons);
            
            foreach ($lessons as $lesson) {
                $progress = $this->where('user_id', $userId)
                                ->where('lesson_id', $lesson['id'])
                                ->where('status', 'completed')
                                ->first();
                
                if ($progress) {
                    $completedLessons++;
                }
            }
        }

        return [
            'completed' => $completedLessons,
            'total' => $totalLessons,
            'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0,
        ];
    }

    /**
     * Get overall progress for user
     */
    public function getOverallProgress($userId)
    {
        $courseModel = new \App\Models\CourseModel();
        $enrollmentModel = new \App\Models\EnrollmentModel();

        $enrollments = $enrollmentModel->where('user_id', $userId)
                                      ->where('status', 'enrolled')
                                      ->findAll();

        $totalCourses = count($enrollments);
        $completedCourses = 0;
        $totalLessons = 0;
        $completedLessons = 0;

        foreach ($enrollments as $enrollment) {
            $progress = $this->getCourseProgress($userId, $enrollment['course_id']);
            $totalLessons += $progress['total'];
            $completedLessons += $progress['completed'];
            
            if ($progress['percentage'] >= 100) {
                $completedCourses++;
            }
        }

        return [
            'courses' => [
                'completed' => $completedCourses,
                'total' => $totalCourses,
            ],
            'lessons' => [
                'completed' => $completedLessons,
                'total' => $totalLessons,
                'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0,
            ],
        ];
    }
}

