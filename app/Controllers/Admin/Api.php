<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModuleModel;

class Api extends BaseController
{
    /**
     * Get modules for a course (AJAX endpoint)
     */
    public function getModules($courseId)
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $moduleModel = new ModuleModel();
        $modules = $moduleModel->where('course_id', $courseId)
                              ->orderBy('sort_order', 'ASC')
                              ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'modules' => $modules
        ]);
    }
}

