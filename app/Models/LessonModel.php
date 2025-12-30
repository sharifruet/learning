<?php

namespace App\Models;

use CodeIgniter\Model;

class LessonModel extends Model
{
    protected $table            = 'lessons';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'module_id',
        'course_id',
        'title',
        'slug',
        'content',
        'code_examples',
        'sort_order',
        'status',
        'content_type',
        'featured_image',
        'estimated_time',
        'objectives',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getLessonWithExercises($lessonId)
    {
        $lesson = $this->find($lessonId);
        if (!$lesson) {
            return null;
        }

        // Only show published lessons to students (unless admin/instructor)
        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'instructor'])) {
            if (($lesson['status'] ?? 'draft') !== 'published') {
                return null;
            }
        }

        $exerciseModel = new ExerciseModel();
        $lesson['exercises'] = $exerciseModel->where('lesson_id', $lessonId)
                                             ->orderBy('sort_order', 'ASC')
                                             ->findAll();

        // Get lesson content blocks
        $lessonContentModel = new \App\Models\LessonContentModel();
        $lesson['content_blocks'] = $lessonContentModel->getLessonContent($lessonId);

        return $lesson;
    }

    /**
     * Get published lessons for a module
     */
    public function getPublishedLessons(int $moduleId)
    {
        return $this->where('module_id', $moduleId)
                   ->where('status', 'published')
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }
}

