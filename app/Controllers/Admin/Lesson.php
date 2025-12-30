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

    public function create($moduleId = null)
    {
        $data['modules'] = $this->moduleModel->orderBy('title', 'ASC')->findAll();
        $data['courses'] = $this->courseModel->orderBy('title', 'ASC')->findAll();
        $data['moduleId'] = $moduleId;
        
        // If module ID provided, get course ID
        if ($moduleId) {
            $module = $this->moduleModel->find($moduleId);
            if ($module) {
                $data['courseId'] = $module['course_id'];
            }
        }
        
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
            'module_id'      => $this->request->getPost('module_id'),
            'course_id'      => $this->request->getPost('course_id'),
            'title'          => $this->request->getPost('title'),
            'slug'           => url_title($this->request->getPost('title'), '-', true),
            'content'        => $this->request->getPost('content'),
            'code_examples'  => $this->request->getPost('code_examples'),
            'sort_order'     => (int)$this->request->getPost('sort_order') ?: 0,
            'status'         => $this->request->getPost('status') ?: 'draft',
            'content_type'   => $this->request->getPost('content_type') ?: 'text',
            'featured_image' => $this->request->getPost('featured_image'),
            'estimated_time' => $this->request->getPost('estimated_time') ?: null,
            'objectives'     => $this->request->getPost('objectives'),
        ];

        $lessonId = $this->lessonModel->insert($data);
        
        if ($lessonId) {
            // Handle lesson content blocks if provided
            $contentBlocks = $this->request->getPost('content_blocks');
            if (!empty($contentBlocks) && is_array($contentBlocks)) {
                $lessonContentModel = new \App\Models\LessonContentModel();
                foreach ($contentBlocks as $index => $block) {
                    if (!empty($block['content'])) {
                        $lessonContentModel->insert([
                            'lesson_id'         => $lessonId,
                            'content_block_type' => $block['type'] ?? 'text',
                            'content'          => $block['content'],
                            'code_language'     => $block['code_language'] ?? null,
                            'sort_order'        => $index,
                        ]);
                    }
                }
            }
            
            $moduleId = $this->request->getPost('module_id');
            return redirect()->to('/admin/modules/' . $moduleId . '/edit')
                ->with('success', 'Lesson created successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create lesson');
    }

    public function edit($id)
    {
        $lesson = $this->lessonModel->find($id);
        if (!$lesson) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['lesson'] = $lesson;
        $data['modules'] = $this->moduleModel->orderBy('title', 'ASC')->findAll();
        $data['courses'] = $this->courseModel->orderBy('title', 'ASC')->findAll();
        
        // Get lesson content blocks
        $lessonContentModel = new \App\Models\LessonContentModel();
        $data['contentBlocks'] = $lessonContentModel->getLessonContent($id);
        
        return $this->render('admin/lessons/edit', $data);
    }

    public function update($id)
    {
        $lesson = $this->lessonModel->find($id);
        if (!$lesson) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

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
            'module_id'      => $this->request->getPost('module_id'),
            'course_id'      => $this->request->getPost('course_id'),
            'title'          => $this->request->getPost('title'),
            'slug'           => url_title($this->request->getPost('title'), '-', true),
            'content'        => $this->request->getPost('content'),
            'code_examples'  => $this->request->getPost('code_examples'),
            'sort_order'     => (int)$this->request->getPost('sort_order'),
            'status'         => $this->request->getPost('status'),
            'content_type'   => $this->request->getPost('content_type'),
            'featured_image' => $this->request->getPost('featured_image'),
            'estimated_time' => $this->request->getPost('estimated_time') ?: null,
            'objectives'     => $this->request->getPost('objectives'),
        ];

        if ($this->lessonModel->update($id, $data)) {
            // Update content blocks
            $lessonContentModel = new \App\Models\LessonContentModel();
            $lessonContentModel->deleteLessonContent($id);
            
            $contentBlocks = $this->request->getPost('content_blocks');
            if (!empty($contentBlocks) && is_array($contentBlocks)) {
                foreach ($contentBlocks as $index => $block) {
                    if (!empty($block['content'])) {
                        $lessonContentModel->insert([
                            'lesson_id'         => $id,
                            'content_block_type' => $block['type'] ?? 'text',
                            'content'          => $block['content'],
                            'code_language'     => $block['code_language'] ?? null,
                            'sort_order'        => $index,
                        ]);
                    }
                }
            }
            
            return redirect()->to('/admin/modules/' . $data['module_id'] . '/edit')
                ->with('success', 'Lesson updated successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update lesson');
    }

    public function delete($id)
    {
        $lesson = $this->lessonModel->find($id);
        if (!$lesson) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $moduleId = $lesson['module_id'];
        
        // Delete content blocks
        $lessonContentModel = new \App\Models\LessonContentModel();
        $lessonContentModel->deleteLessonContent($id);
        
        if ($this->lessonModel->delete($id)) {
            return redirect()->to('/admin/modules/' . $moduleId . '/edit')
                ->with('success', 'Lesson deleted successfully');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete lesson');
    }
}

