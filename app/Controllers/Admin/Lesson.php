<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use App\Models\CourseModel;

class Lesson extends BaseController
{
    protected $lessonModel;
    protected $moduleModel;
    protected $courseModel;

    public function __construct()
    {
        $this->lessonModel = new LessonModel();
        $this->moduleModel = new ModuleModel();
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        $data['lessons'] = $this->lessonModel->orderBy('created_at', 'DESC')->findAll();
        return $this->render('admin/lessons/index', $data);
    }

    public function create()
    {
        $data['modules'] = $this->moduleModel->findAll();
        $data['courses'] = $this->courseModel->findAll();
        return $this->render('admin/lessons/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'     => 'required|min_length[3]|max_length[255]',
            'module_id' => 'required|numeric',
            'course_id' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'module_id'    => $this->request->getPost('module_id'),
            'course_id'    => $this->request->getPost('course_id'),
            'title'        => $this->request->getPost('title'),
            'slug'         => url_title($this->request->getPost('title'), '-', true),
            'content'      => $this->request->getPost('content'),
            'code_examples' => $this->request->getPost('code_examples'),
            'sort_order'   => (int)$this->request->getPost('sort_order') ?: 0,
        ];

        if ($this->lessonModel->insert($data)) {
            return redirect()->to('/admin/lessons')
                ->with('success', 'Lesson created successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create lesson');
    }
}

