<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuleModel extends Model
{
    protected $table            = 'modules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'course_id',
        'title',
        'description',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getModuleWithLessons($moduleId)
    {
        $module = $this->find($moduleId);
        if (!$module) {
            return null;
        }

        $lessonModel = new LessonModel();
        $module['lessons'] = $lessonModel->where('module_id', $moduleId)
                                         ->orderBy('sort_order', 'ASC')
                                         ->findAll();

        return $module;
    }
}

