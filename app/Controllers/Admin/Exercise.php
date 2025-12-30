<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExerciseModel;
use App\Models\LessonModel;

class Exercise extends BaseController
{
    protected $exerciseModel;
    protected $lessonModel;

    public function __construct()
    {
        $this->exerciseModel = new ExerciseModel();
        $this->lessonModel = new LessonModel();
    }

    /**
     * List exercises for a lesson
     */
    public function index($lessonId = null)
    {
        if ($lessonId) {
            $lesson = $this->lessonModel->find($lessonId);
            if (!$lesson) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            
            $data['lesson'] = $lesson;
            $data['exercises'] = $this->exerciseModel->where('lesson_id', $lessonId)
                                                     ->orderBy('sort_order', 'ASC')
                                                     ->findAll();
        } else {
            $data['exercises'] = $this->exerciseModel->orderBy('created_at', 'DESC')->findAll();
        }
        
        return $this->render('admin/exercises/index', $data);
    }

    /**
     * Show create exercise form
     */
    public function create($lessonId = null)
    {
        if ($lessonId) {
            $lesson = $this->lessonModel->find($lessonId);
            if (!$lesson) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            $data['lesson'] = $lesson;
        } else {
            $data['lessons'] = $this->lessonModel->where('status', 'published')
                                                 ->orderBy('title', 'ASC')
                                                 ->findAll();
        }
        
        $data['lessonId'] = $lessonId;
        return $this->render('admin/exercises/create', $data);
    }

    /**
     * Store new exercise
     */
    public function store()
    {
        $rules = [
            'lesson_id' => 'required|numeric',
            'title'     => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'lesson_id'     => $this->request->getPost('lesson_id'),
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'starter_code'  => $this->request->getPost('starter_code'),
            'solution_code' => $this->request->getPost('solution_code'),
            'hints'         => $this->request->getPost('hints'),
            'sort_order'    => (int)$this->request->getPost('sort_order') ?: 0,
        ];

        if ($this->exerciseModel->insert($data)) {
            $lessonId = $this->request->getPost('lesson_id');
            return redirect()->to('/admin/exercises/' . $lessonId)
                ->with('success', 'Exercise created successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create exercise');
    }

    /**
     * Show edit exercise form
     */
    public function edit($id)
    {
        $exercise = $this->exerciseModel->find($id);
        if (!$exercise) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $lesson = $this->lessonModel->find($exercise['lesson_id']);
        
        $data['exercise'] = $exercise;
        $data['lesson'] = $lesson;
        
        return $this->render('admin/exercises/edit', $data);
    }

    /**
     * Update exercise
     */
    public function update($id)
    {
        $exercise = $this->exerciseModel->find($id);
        if (!$exercise) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'starter_code'  => $this->request->getPost('starter_code'),
            'solution_code' => $this->request->getPost('solution_code'),
            'hints'         => $this->request->getPost('hints'),
            'sort_order'    => (int)$this->request->getPost('sort_order'),
        ];

        if ($this->exerciseModel->update($id, $data)) {
            return redirect()->to('/admin/exercises/' . $exercise['lesson_id'])
                ->with('success', 'Exercise updated successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update exercise');
    }

    /**
     * Delete exercise
     */
    public function delete($id)
    {
        $exercise = $this->exerciseModel->find($id);
        if (!$exercise) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $lessonId = $exercise['lesson_id'];
        
        if ($this->exerciseModel->delete($id)) {
            return redirect()->to('/admin/exercises/' . $lessonId)
                ->with('success', 'Exercise deleted successfully');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete exercise');
    }
}

