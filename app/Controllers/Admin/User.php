<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * List all users
     */
    public function index()
    {
        $role = $this->request->getGet('role');
        
        $builder = $this->userModel->orderBy('created_at', 'DESC');
        
        if ($role && in_array($role, ['student', 'instructor', 'admin'])) {
            $builder->where('role', $role);
        }
        
        $data['users'] = $builder->findAll();
        $data['total_users'] = $this->userModel->countAllResults();
        $data['total_students'] = $this->userModel->where('role', 'student')->countAllResults();
        $data['total_instructors'] = $this->userModel->where('role', 'instructor')->countAllResults();
        $data['total_admins'] = $this->userModel->where('role', 'admin')->countAllResults();
        $data['current_role'] = $role;
        
        return $this->render('admin/users/index', $data);
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['user'] = $user;
        return $this->render('admin/users/edit', $data);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[255]',
            'role' => 'required|in_list[student,instructor,admin]',
        ];

        // Only validate password if provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/admin/users')
                ->with('success', 'User updated successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update user');
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Prevent deleting yourself
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')
                ->with('success', 'User deleted successfully');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete user');
    }
}

