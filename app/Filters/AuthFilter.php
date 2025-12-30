<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->has('user_id')) {
            return redirect()->to('/auth/login');
        }
        
        // Check for admin role if required
        if (isset($arguments) && in_array('admin', $arguments)) {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($session->get('user_id'));
            
            if (!$user || $user['role'] !== 'admin') {
                return redirect()->to('/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

