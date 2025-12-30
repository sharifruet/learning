<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class FileUpload extends BaseController
{
    /**
     * Upload image for lessons/courses
     */
    public function uploadImage()
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $file = $this->request->getFile('image');
        
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No file uploaded or file is invalid'
            ])->setStatusCode(400);
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.'
            ])->setStatusCode(400);
        }

        // Validate file size (max 5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File size exceeds 5MB limit'
            ])->setStatusCode(400);
        }

        // Generate unique filename
        $newName = $file->getRandomName();
        $uploadPath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Move file
        if ($file->move($uploadPath, $newName)) {
            $url = base_url('uploads/images/' . $newName);
            
            return $this->response->setJSON([
                'success' => true,
                'url' => $url,
                'message' => 'Image uploaded successfully'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to upload image'
        ])->setStatusCode(500);
    }
}

