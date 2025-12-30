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
        $data['courses'] = $this->courseModel->orderBy('sort_order', 'ASC')->findAll();
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
            'title'       => $this->request->getPost('title'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'difficulty'  => $this->request->getPost('difficulty') ?: 'beginner',
            'status'      => $this->request->getPost('status') ?: 'draft',
            'sort_order'  => (int)$this->request->getPost('sort_order') ?: 0,
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
            'title'       => $this->request->getPost('title'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'difficulty'  => $this->request->getPost('difficulty'),
            'status'      => $this->request->getPost('status'),
            'sort_order'  => (int)$this->request->getPost('sort_order'),
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

