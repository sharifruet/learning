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

        $exerciseModel = new ExerciseModel();
        $lesson['exercises'] = $exerciseModel->where('lesson_id', $lessonId)
                                             ->orderBy('sort_order', 'ASC')
                                             ->findAll();

        return $lesson;
    }
}

