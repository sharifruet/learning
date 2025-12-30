<?php

namespace App\Models;

use CodeIgniter\Model;

class LessonContentModel extends Model
{
    protected $table            = 'lesson_content';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'lesson_id',
        'content_block_type',
        'content',
        'code_language',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all content blocks for a lesson ordered by sort_order
     */
    public function getLessonContent(int $lessonId)
    {
        return $this->where('lesson_id', $lessonId)
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    /**
     * Delete all content blocks for a lesson
     */
    public function deleteLessonContent(int $lessonId): bool
    {
        return $this->where('lesson_id', $lessonId)->delete() !== false;
    }
}

