<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PythonSubcoursesSeeder extends Seeder
{
    public function run()
    {
        // Find the parent "Python Programming" course
        $parentCourse = $this->db->table('courses')
            ->where('slug', 'python-programming')
            ->get()
            ->getRowArray();

        if (!$parentCourse) {
            echo "Error: Python Programming parent course not found!\n";
            echo "Please run MasterDataSeeder first to create the parent course.\n";
            return;
        }

        $parentCourseId = $parentCourse['id'];
        echo "Found Python Programming parent course (ID: {$parentCourseId})\n";

        // Define the 7 subcourses based on python.md
        $subcourses = [
            [
                'title'       => 'Python Fundamentals',
                'slug'        => 'python-fundamentals',
                'description' => 'Learn the fundamentals of Python programming. Master syntax, variables, data types, control flow, functions, and string manipulation.',
                'difficulty'  => 'beginner',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Intermediate Python',
                'slug'        => 'intermediate-python',
                'description' => 'Advance your Python skills with object-oriented programming, file handling, error handling, modules, packages, and advanced data structures.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Advanced Python',
                'slug'        => 'advanced-python',
                'description' => 'Master advanced Python concepts including decorators, context managers, metaclasses, concurrency, testing, and performance optimization.',
                'difficulty'  => 'advanced',
                'sort_order'  => 3,
            ],
            [
                'title'       => 'Python for Web Development',
                'slug'        => 'python-web-development',
                'description' => 'Build web applications with Python using Flask and Django. Learn HTTP concepts, REST APIs, and GraphQL.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 4,
            ],
            [
                'title'       => 'Python for Data Science',
                'slug'        => 'python-data-science',
                'description' => 'Explore data science with Python using NumPy, Pandas, and data visualization libraries like Matplotlib and Seaborn.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 5,
            ],
            [
                'title'       => 'Practical Projects',
                'slug'        => 'python-practical-projects',
                'description' => 'Build real-world Python projects including CLI tools, web scraping, database applications, automation scripts, and API development.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 6,
            ],
            [
                'title'       => 'Best Practices and Design Patterns',
                'slug'        => 'python-best-practices',
                'description' => 'Learn Python best practices, code quality, PEP 8, documentation, design patterns, and software architecture for large projects.',
                'difficulty'  => 'advanced',
                'sort_order'  => 7,
            ],
        ];

        // Check if subcourses already exist
        $existingSubcourses = $this->db->table('courses')
            ->where('parent_course_id', $parentCourseId)
            ->countAllResults();

        if ($existingSubcourses > 0) {
            echo "Subcourses already exist. Found {$existingSubcourses} subcourses.\n";
            echo "To re-seed, delete existing subcourses first.\n";
            return;
        }

        // Insert subcourses
        $inserted = 0;
        foreach ($subcourses as $subcourse) {
            $subcourseData = [
                'title'          => $subcourse['title'],
                'slug'           => $subcourse['slug'],
                'description'    => $subcourse['description'],
                'difficulty'     => $subcourse['difficulty'],
                'status'         => 'published',
                'sort_order'     => $subcourse['sort_order'],
                'parent_course_id' => $parentCourseId,
                'enrollment_type' => 'open',
                'is_free'        => 1,
                'is_self_paced'  => 1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ];

            $this->db->table('courses')->insert($subcourseData);
            $inserted++;
            echo "Created subcourse: {$subcourse['title']} (ID: {$this->db->insertID()})\n";
        }

        echo "\nSuccessfully created {$inserted} Python subcourses!\n";
        echo "Parent course: Python Programming (ID: {$parentCourseId})\n";
    }
}

