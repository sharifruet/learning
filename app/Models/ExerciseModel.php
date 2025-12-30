<?php

namespace App\Models;

use CodeIgniter\Model;

class ExerciseModel extends Model
{
    protected $table            = 'exercises';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'lesson_id',
        'title',
        'description',
        'starter_code',
        'solution_code',
        'test_cases',
        'hints',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

