<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'slug',
        'description',
        'image',
        'difficulty',
        'status',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'slug'  => 'required|is_unique[courses.slug]',
    ];

    public function getPublishedCourses()
    {
        return $this->where('status', 'published')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getCourseWithModules($courseId)
    {
        $course = $this->find($courseId);
        if (!$course) {
            return null;
        }

        $moduleModel = new ModuleModel();
        $course['modules'] = $moduleModel->where('course_id', $courseId)
                                         ->orderBy('sort_order', 'ASC')
                                         ->findAll();

        return $course;
    }
}

