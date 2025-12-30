<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\ModuleModel;

class Course extends BaseController
{
    protected $courseModel;
    protected $moduleModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->moduleModel = new ModuleModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $userRole = session()->get('role');
        
        // Filter courses by instructor if user is instructor (not admin)
        if ($userRole === 'instructor') {
            $data['courses'] = $this->courseModel->where('instructor_id', $userId)
                                                 ->orderBy('sort_order', 'ASC')
                                                 ->findAll();
        } else {
            $data['courses'] = $this->courseModel->orderBy('sort_order', 'ASC')->findAll();
        }
        
        return $this->render('admin/courses/index', $data);
    }

    public function create()
    {
        return $this->render('admin/courses/create', []);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug'  => 'required|is_unique[courses.slug]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'          => $this->request->getPost('title'),
            'slug'           => $this->request->getPost('slug'),
            'description'    => $this->request->getPost('description'),
            'difficulty'     => $this->request->getPost('difficulty') ?: 'beginner',
            'status'         => $this->request->getPost('status') ?: 'draft',
            'sort_order'     => (int)$this->request->getPost('sort_order') ?: 0,
            'category_id'    => $this->request->getPost('category_id') ?: null,
            'instructor_id'  => $this->request->getPost('instructor_id') ?: session()->get('user_id'),
            'enrollment_type' => $this->request->getPost('enrollment_type') ?: 'open',
            'is_free'        => $this->request->getPost('is_free') ? 1 : 0,
            'is_self_paced'  => $this->request->getPost('is_self_paced') ? 1 : 1,
            'capacity'       => $this->request->getPost('capacity') ?: null,
            'syllabus'       => $this->request->getPost('syllabus'),
            'tags'           => $this->request->getPost('tags'),
        ];

        if ($this->courseModel->insert($data)) {
            return redirect()->to('/admin/courses')
                ->with('success', 'Course created successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create course');
    }

    public function edit($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['course'] = $course;
        $data['categories'] = $this->categoryModel->getAllCategories();
        $data['instructors'] = $this->userModel->whereIn('role', ['instructor', 'admin'])->findAll();
        return $this->render('admin/courses/edit', $data);
    }

    public function update($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
        ];

        // Only validate slug uniqueness if it changed
        if ($course['slug'] !== $this->request->getPost('slug')) {
            $rules['slug'] = 'required|is_unique[courses.slug]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'          => $this->request->getPost('title'),
            'slug'           => $this->request->getPost('slug'),
            'description'    => $this->request->getPost('description'),
            'difficulty'     => $this->request->getPost('difficulty'),
            'status'         => $this->request->getPost('status'),
            'sort_order'     => (int)$this->request->getPost('sort_order'),
            'category_id'    => $this->request->getPost('category_id') ?: null,
            'instructor_id'  => $this->request->getPost('instructor_id') ?: null,
            'enrollment_type' => $this->request->getPost('enrollment_type'),
            'is_free'        => $this->request->getPost('is_free') ? 1 : 0,
            'is_self_paced'  => $this->request->getPost('is_self_paced') ? 1 : 0,
            'capacity'       => $this->request->getPost('capacity') ?: null,
            'syllabus'       => $this->request->getPost('syllabus'),
            'tags'           => $this->request->getPost('tags'),
        ];

        if ($this->courseModel->update($id, $data)) {
            return redirect()->to('/admin/courses')
                ->with('success', 'Course updated successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update course');
    }
}

