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
        
        // Check role-based access if arguments are provided
        if (!empty($arguments)) {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($session->get('user_id'));
            
            if (!$user) {
                $session->destroy();
                return redirect()->to('/auth/login');
            }
            
            $userRole = $user['role'];
            
            // Check for specific role requirements
            foreach ($arguments as $requiredRole) {
                if ($requiredRole === 'admin' && $userRole !== 'admin') {
                    return redirect()->to('/dashboard')
                        ->with('error', 'Access denied. Administrator privileges required.');
                }
                
                // Allow both instructor and admin for instructor routes
                if ($requiredRole === 'instructor' && !in_array($userRole, ['instructor', 'admin'])) {
                    return redirect()->to('/dashboard')
                        ->with('error', 'Access denied. Instructor privileges required.');
                }
                
                if ($requiredRole === 'student' && !in_array($userRole, ['student', 'instructor', 'admin'])) {
                    return redirect()->to('/dashboard')
                        ->with('error', 'Access denied.');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

