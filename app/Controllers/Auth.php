<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        return $this->render('auth/login', []);
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }

        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'first_name' => $user['first_name'],
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin');
        }

        return redirect()->to('/dashboard');
    }

    public function register()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        return $this->render('auth/register', []);
    }

    public function attemptRegister()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'role'       => 'student',
        ];

        $userId = $this->userModel->insert($data);

        if ($userId) {
            $user = $this->userModel->find($userId);
            session()->set([
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'first_name' => $user['first_name'],
            ]);

            return redirect()->to('/dashboard')
                ->with('success', 'Registration successful! Welcome to Python Learning Platform.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Registration failed. Please try again.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}

