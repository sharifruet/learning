<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JavaScriptSubcoursesSeeder extends Seeder
{
    public function run()
    {
        // Find the parent "JavaScript Programming" course
        $parentCourse = $this->db->table('courses')
            ->where('slug', 'javascript-programming')
            ->get()
            ->getRowArray();

        if (!$parentCourse) {
            echo "Error: JavaScript Programming parent course not found!\n";
            echo "Please run MasterDataSeeder first to create the parent course.\n";
            return;
        }

        $parentCourseId = $parentCourse['id'];
        echo "Found JavaScript Programming parent course (ID: {$parentCourseId})\n";

        // Define the 9 subcourses based on javascript.md
        $subcourses = [
            [
                'title'       => 'JavaScript Fundamentals',
                'slug'        => 'javascript-fundamentals',
                'description' => 'Learn the fundamentals of JavaScript programming. Master syntax, variables, data types, operators, control flow, functions, objects, and arrays.',
                'difficulty'  => 'beginner',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Intermediate JavaScript',
                'slug'        => 'intermediate-javascript',
                'description' => 'Advance your JavaScript skills with ES6+ features, advanced functions, asynchronous JavaScript, iterators, generators, and modules.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'DOM Manipulation and Events',
                'slug'        => 'dom-manipulation-events',
                'description' => 'Master the Document Object Model (DOM), event handling, form validation, and creating interactive web pages.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 3,
            ],
            [
                'title'       => 'Browser APIs and Storage',
                'slug'        => 'browser-apis-storage',
                'description' => 'Learn browser storage (localStorage, sessionStorage, IndexedDB) and browser APIs for modern web development.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 4,
            ],
            [
                'title'       => 'Advanced JavaScript',
                'slug'        => 'advanced-javascript',
                'description' => 'Master advanced JavaScript concepts including functional programming, design patterns, error handling, debugging, and performance optimization.',
                'difficulty'  => 'advanced',
                'sort_order'  => 5,
            ],
            [
                'title'       => 'Testing and Tools',
                'slug'        => 'javascript-testing-tools',
                'description' => 'Learn JavaScript testing frameworks, build tools, bundlers, code quality tools, and linting for professional development.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 6,
            ],
            [
                'title'       => 'Frontend Frameworks',
                'slug'        => 'frontend-frameworks',
                'description' => 'Explore modern frontend frameworks including React basics and advanced concepts, and Vue.js as an alternative framework.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 7,
            ],
            [
                'title'       => 'Node.js and Backend Development',
                'slug'        => 'nodejs-backend-development',
                'description' => 'Build backend applications with Node.js. Learn to create web servers, work with databases, and implement authentication.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 8,
            ],
            [
                'title'       => 'Practical Projects',
                'slug'        => 'javascript-practical-projects',
                'description' => 'Build real-world JavaScript projects including interactive web applications, API integrations, and full-stack applications.',
                'difficulty'  => 'intermediate',
                'sort_order'  => 9,
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
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ];

            $this->db->table('courses')->insert($subcourseData);
            $inserted++;
            echo "Created subcourse: {$subcourse['title']} (ID: {$this->db->insertID()})\n";
        }

        echo "\nSuccessfully created {$inserted} JavaScript subcourses!\n";
        echo "Parent course: JavaScript Programming (ID: {$parentCourseId})\n";
    }
}

