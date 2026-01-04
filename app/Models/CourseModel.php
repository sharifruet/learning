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
        'parent_course_id',
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
        
        // Exclude subcourses - only show parent courses and standalone courses
        $builder->where('parent_course_id IS NULL');

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

    /**
     * Find course by slug
     */
    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Get course with details by slug
     */
    public function getCourseWithDetailsBySlug($slug)
    {
        $course = $this->findBySlug($slug);
        if (!$course) {
            return null;
        }

        return $this->getCourseWithDetails($course['id']);
    }

    /**
     * Get parent course for a subcourse
     */
    public function getParentCourse($courseId)
    {
        $course = $this->find($courseId);
        if (!$course || empty($course['parent_course_id'])) {
            return null;
        }

        return $this->find($course['parent_course_id']);
    }

    /**
     * Get all subcourses for a parent course
     */
    public function getSubcourses($parentCourseId)
    {
        return $this->where('parent_course_id', $parentCourseId)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'ASC')
                   ->findAll();
    }

    /**
     * Get all subcourses with details for a parent course
     */
    public function getSubcoursesWithDetails($parentCourseId)
    {
        $subcourses = $this->getSubcourses($parentCourseId);
        
        foreach ($subcourses as &$subcourse) {
            $subcourse = $this->getCourseWithDetails($subcourse['id']);
        }

        return $subcourses;
    }

    /**
     * Check if a course is a parent course (has subcourses)
     */
    public function isParentCourse($courseId)
    {
        return $this->where('parent_course_id', $courseId)->countAllResults() > 0;
    }

    /**
     * Check if a course is a subcourse (has a parent)
     */
    public function isSubcourse($courseId)
    {
        $course = $this->find($courseId);
        return $course && !empty($course['parent_course_id']);
    }

    /**
     * Get all standalone courses (courses without parent)
     */
    public function getStandaloneCourses(array $filters = [])
    {
        $builder = $this->where('parent_course_id IS NULL');

        // Apply same filters as getPublishedCourses
        if (!empty($filters['category_id'])) {
            $builder->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['difficulty'])) {
            $builder->where('difficulty', $filters['difficulty']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                   ->like('title', $search)
                   ->orLike('description', $search)
                   ->orLike('tags', $search)
                   ->groupEnd();
        }

        if (isset($filters['enrollment_type'])) {
            $builder->where('enrollment_type', $filters['enrollment_type']);
        } else {
            $builder->where('enrollment_type', 'open');
        }

        if (isset($filters['status'])) {
            $builder->where('status', $filters['status']);
        } else {
            $builder->where('status', 'published');
        }

        return $builder->orderBy('sort_order', 'ASC')
                      ->orderBy('created_at', 'DESC')
                      ->findAll();
    }

    /**
     * Get parent courses (courses that have subcourses or can have subcourses)
     */
    public function getParentCourses(array $filters = [])
    {
        $builder = $this->where('parent_course_id IS NULL')
                       ->where('status', 'published');

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
            $builder->where('enrollment_type', 'open');
        }

        return $builder->orderBy('sort_order', 'ASC')
                      ->orderBy('created_at', 'DESC')
                      ->findAll();
    }

    /**
     * Get course with parent and subcourses information
     */
    public function getCourseWithHierarchy($courseId)
    {
        $course = $this->getCourseWithDetails($courseId);
        if (!$course) {
            return null;
        }

        // Get parent course if this is a subcourse
        if (!empty($course['parent_course_id'])) {
            $course['parent'] = $this->find($course['parent_course_id']);
        }

        // Get subcourses if this is a parent course
        $subcourses = $this->getSubcourses($courseId);
        if (!empty($subcourses)) {
            $course['subcourses'] = $subcourses;
        }

        return $course;
    }

    /**
     * Validate parent_course_id to prevent circular references
     * 
     * @param int|null $parentCourseId The parent course ID to validate
     * @param int|null $currentCourseId The current course ID (for updates, null for new courses)
     * @return array ['valid' => bool, 'error' => string|null]
     */
    public function validateParentCourse($parentCourseId, $currentCourseId = null)
    {
        // NULL is valid (standalone or parent course)
        if (empty($parentCourseId)) {
            return ['valid' => true, 'error' => null];
        }

        // Check if parent course exists
        $parentCourse = $this->find($parentCourseId);
        if (!$parentCourse) {
            return ['valid' => false, 'error' => 'Parent course does not exist'];
        }

        // Prevent a course from being its own parent
        if ($currentCourseId && (int)$parentCourseId === (int)$currentCourseId) {
            return ['valid' => false, 'error' => 'A course cannot be its own parent'];
        }

        // Prevent circular references: check if the parent course is a subcourse of the current course
        if ($currentCourseId) {
            $parentParentId = $parentCourse['parent_course_id'] ?? null;
            if ($parentParentId && (int)$parentParentId === (int)$currentCourseId) {
                return ['valid' => false, 'error' => 'Cannot set parent: would create circular reference'];
            }
            
            // Recursively check deeper levels (prevent multi-level circular references)
            $ancestors = $this->getAncestorCourseIds($parentCourseId);
            if (in_array($currentCourseId, $ancestors)) {
                return ['valid' => false, 'error' => 'Cannot set parent: would create circular reference'];
            }
        }

        return ['valid' => true, 'error' => null];
    }

    /**
     * Get all ancestor course IDs (parent, grandparent, etc.)
     * 
     * @param int $courseId
     * @return array Array of ancestor course IDs
     */
    protected function getAncestorCourseIds($courseId)
    {
        $ancestors = [];
        $course = $this->find($courseId);
        
        while ($course && !empty($course['parent_course_id'])) {
            $ancestors[] = (int)$course['parent_course_id'];
            $course = $this->find($course['parent_course_id']);
        }
        
        return $ancestors;
    }
}

