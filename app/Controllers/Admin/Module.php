<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModuleModel;
use App\Models\CourseModel;
use App\Models\LessonModel;

class Module extends BaseController
{
    protected $moduleModel;
    protected $courseModel;
    protected $lessonModel;

    public function __construct()
    {
        $this->moduleModel = new ModuleModel();
        $this->courseModel = new CourseModel();
        $this->lessonModel = new LessonModel();
    }

    /**
     * List modules for a course
     */
    public function index($courseId = null)
    {
        if ($courseId) {
            $data['course'] = $this->courseModel->find($courseId);
            $data['modules'] = $this->moduleModel->where('course_id', $courseId)
                                               ->orderBy('sort_order', 'ASC')
                                               ->findAll();
            $data['courseId'] = $courseId;
        } else {
            $data['modules'] = $this->moduleModel->orderBy('created_at', 'DESC')->findAll();
        }
        
        return $this->render('admin/modules/index', $data);
    }

    /**
     * Show create module form
     */
    public function create($courseId = null)
    {
        $data['courses'] = $this->courseModel->orderBy('title', 'ASC')->findAll();
        $data['courseId'] = $courseId;
        return $this->render('admin/modules/create', $data);
    }

    /**
     * Store new module
     */
    public function store()
    {
        $rules = [
            'course_id' => 'required|numeric',
            'title'     => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'course_id'   => $this->request->getPost('course_id'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => (int)$this->request->getPost('sort_order') ?: 0,
        ];

        if ($this->moduleModel->insert($data)) {
            $courseId = $this->request->getPost('course_id');
            return redirect()->to('/admin/courses/' . $courseId . '/modules')
                ->with('success', 'Module created successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create module');
    }

    /**
     * Show edit module form
     */
    public function edit($id)
    {
        $module = $this->moduleModel->find($id);
        if (!$module) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['module'] = $module;
        $data['courses'] = $this->courseModel->orderBy('title', 'ASC')->findAll();
        $data['lessons'] = $this->lessonModel->where('module_id', $id)
                                           ->orderBy('sort_order', 'ASC')
                                           ->findAll();
        
        return $this->render('admin/modules/edit', $data);
    }

    /**
     * Update module
     */
    public function update($id)
    {
        $module = $this->moduleModel->find($id);
        if (!$module) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'course_id' => 'required|numeric',
            'title'     => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'course_id'   => $this->request->getPost('course_id'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => (int)$this->request->getPost('sort_order'),
        ];

        if ($this->moduleModel->update($id, $data)) {
            return redirect()->to('/admin/courses/' . $data['course_id'] . '/modules')
                ->with('success', 'Module updated successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update module');
    }

    /**
     * Delete module
     */
    public function delete($id)
    {
        $module = $this->moduleModel->find($id);
        if (!$module) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $courseId = $module['course_id'];
        
        if ($this->moduleModel->delete($id)) {
            return redirect()->to('/admin/courses/' . $courseId . '/modules')
                ->with('success', 'Module deleted successfully');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete module');
    }
}

