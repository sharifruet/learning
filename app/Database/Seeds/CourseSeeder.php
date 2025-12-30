<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courseData = [
            [
                'title'       => 'Python Basics',
                'slug'        => 'python-basics',
                'description' => 'Learn the fundamentals of Python programming',
                'difficulty'  => 'beginner',
                'status'      => 'published',
                'sort_order'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('courses')->insertBatch($courseData);

        $courseId = $this->db->insertID();

        $moduleData = [
            [
                'course_id'   => $courseId,
                'title'       => 'Introduction to Python',
                'description' => 'Get started with Python programming',
                'sort_order'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('modules')->insertBatch($moduleData);

        $moduleId = $this->db->insertID();

        $lessonData = [
            [
                'module_id'    => $moduleId,
                'course_id'    => $courseId,
                'title'        => 'Welcome to Python',
                'slug'         => 'welcome-to-python',
                'content'      => '<h2>Welcome to Python Programming</h2><p>Python is a powerful and versatile programming language.</p>',
                'code_examples' => 'print("Hello, World!")',
                'sort_order'   => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('lessons')->insertBatch($lessonData);
    }
}

