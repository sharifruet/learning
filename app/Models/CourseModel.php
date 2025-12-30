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
        'category_id',
        'instructor_id',
        'enrollment_type',
        'is_free',
        'is_self_paced',
        'capacity',
        'syllabus',
        'tags',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'slug'  => 'required|is_unique[courses.slug]',
    ];

    public function getPublishedCourses(array $filters = [])
    {
        $builder = $this->where('status', 'published');

        // Filter by category
        if (!empty($filters['category_id'])) {
            $builder->where('category_id', $filters['category_id']);
        }

        // Filter by difficulty
        if (!empty($filters['difficulty'])) {
            $builder->where('difficulty', $filters['difficulty']);
        }

        // Search by title or description
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                   ->like('title', $search)
                   ->orLike('description', $search)
                   ->orLike('tags', $search)
                   ->groupEnd();
        }

        // Filter by enrollment type (default: open)
        if (isset($filters['enrollment_type'])) {
            $builder->where('enrollment_type', $filters['enrollment_type']);
        } else {
            // Default: show open enrollment courses
            $builder->where('enrollment_type', 'open');
        }

        return $builder->orderBy('sort_order', 'ASC')
                      ->orderBy('created_at', 'DESC')
                      ->findAll();
    }

    /**
     * Get course with instructor and category info
     */
    public function getCourseWithDetails($courseId)
    {
        $course = $this->find($courseId);
        if (!$course) {
            return null;
        }

        // Get instructor info
        if (!empty($course['instructor_id'])) {
            $userModel = new \App\Models\UserModel();
            $course['instructor'] = $userModel->find($course['instructor_id']);
        }

        // Get category info
        if (!empty($course['category_id'])) {
            $categoryModel = new \App\Models\CourseCategoryModel();
            $course['category'] = $categoryModel->find($course['category_id']);
        }

        // Get modules with lessons
        $moduleModel = new ModuleModel();
        $modules = $moduleModel->where('course_id', $courseId)
                              ->orderBy('sort_order', 'ASC')
                              ->findAll();
        
        // Load lessons for each module
        $lessonModel = new \App\Models\LessonModel();
        foreach ($modules as &$module) {
            $module['lessons'] = $lessonModel->where('module_id', $module['id'])
                                           ->orderBy('sort_order', 'ASC')
                                           ->findAll();
        }
        
        $course['modules'] = $modules;

        return $course;
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

