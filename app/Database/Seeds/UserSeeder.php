<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'admin',
                'email'         => 'admin@pythonlearn.com',
                'password'      => password_hash('admin123', PASSWORD_DEFAULT),
                'first_name'    => 'Admin',
                'last_name'     => 'User',
                'role'          => 'admin',
                'email_verified' => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'student',
                'email'         => 'student@pythonlearn.com',
                'password'      => password_hash('student123', PASSWORD_DEFAULT),
                'first_name'    => 'Student',
                'last_name'     => 'User',
                'role'          => 'student',
                'email_verified' => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}

