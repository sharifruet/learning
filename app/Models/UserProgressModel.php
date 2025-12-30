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
        ];

        $existing = $this->where('user_id', $userId)
                         ->where('lesson_id', $lessonId)
                         ->first();

        if ($existing) {
            return $this->update($existing['id'], $data);
        }

        return $this->insert($data);
    }
}

