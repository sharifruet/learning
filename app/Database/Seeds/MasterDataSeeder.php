<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        // Check if courses already exist
        $existingPython = $this->db->table('courses')->where('slug', 'python-programming')->first();
        $existingJavaScript = $this->db->table('courses')->where('slug', 'javascript-programming')->first();

        if ($existingPython || $existingJavaScript) {
            echo "Master data courses already exist. Skipping insertion.\n";
            echo "To re-seed, delete existing courses first.\n";
            return;
        }

        // Insert Python Course
        $pythonCourseId = $this->insertPythonCourse();
        
        // Insert JavaScript Course
        $javascriptCourseId = $this->insertJavaScriptCourse();

        echo "Master data seeded successfully!\n";
        echo "Python Course ID: {$pythonCourseId}\n";
        echo "JavaScript Course ID: {$javascriptCourseId}\n";
    }

    private function insertPythonCourse()
    {
        $courseData = [
            'title'       => 'Python Programming',
            'slug'        => 'python-programming',
            'description' => 'Master Python programming from basics to advanced topics. Learn syntax, data structures, object-oriented programming, and more in this comprehensive course.',
            'difficulty'  => 'beginner',
            'status'      => 'published',
            'sort_order'  => 1,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $this->db->table('courses')->insert($courseData);
        $courseId = $this->db->insertID();

        // Module 1: Getting Started with Python
        $module1Id = $this->insertModule($courseId, 'Getting Started with Python', 'Learn the fundamentals of Python programming and set up your development environment.', 1);
        
        $this->insertLesson($module1Id, $courseId, 'Introduction to Python', 'introduction-to-python', 
            '<h2>What is Python?</h2><p>Python is a high-level, interpreted programming language known for its simplicity and readability. It was created by Guido van Rossum and first released in 1991.</p><h3>Why Learn Python?</h3><ul><li>Easy to learn and read</li><li>Versatile - used in web development, data science, AI, automation, and more</li><li>Large community and extensive libraries</li><li>Great for beginners</li></ul>', 
            'print("Hello, World!")', 1);
        
        $this->insertLesson($module1Id, $courseId, 'Python Syntax and Basics', 'python-syntax-and-basics',
            '<h2>Python Syntax</h2><p>Python uses indentation to define code blocks, making it more readable than many other languages.</p><h3>Key Points:</h3><ul><li>Indentation matters - use 4 spaces</li><li>Comments start with #</li><li>No semicolons needed</li><li>Case-sensitive language</li></ul>',
            '# This is a comment\nprint("Hello, World!")\nx = 10\ny = 20\nprint(x + y)', 2);

        $this->insertLesson($module1Id, $courseId, 'Variables and Data Types', 'variables-and-data-types',
            '<h2>Variables in Python</h2><p>Variables are used to store data. Python is dynamically typed, meaning you don\'t need to declare variable types.</p><h3>Basic Data Types:</h3><ul><li>Integer (int): 10, -5, 0</li><li>Float: 3.14, -2.5</li><li>String: "Hello", \'Python\'</li><li>Boolean: True, False</li></ul>',
            '# Variables\name = "Python"\nage = 30\nprice = 99.99\nis_active = True\n\nprint(f"{name} is {age} years old")\nprint(f"Price: ${price}")\nprint(f"Active: {is_active}")', 3);

        // Module 2: Data Structures
        $module2Id = $this->insertModule($courseId, 'Data Structures', 'Learn about lists, tuples, dictionaries, and sets in Python.', 2);
        
        $this->insertLesson($module2Id, $courseId, 'Lists', 'lists',
            '<h2>Lists in Python</h2><p>Lists are ordered, mutable collections of items. They are one of the most versatile data structures in Python.</p><h3>Creating Lists:</h3><pre>fruits = ["apple", "banana", "cherry"]\nnumbers = [1, 2, 3, 4, 5]</pre>',
            '# Lists\nfruits = ["apple", "banana", "cherry"]\nprint(fruits[0])  # apple\nfruits.append("orange")\nprint(fruits)  # ["apple", "banana", "cherry", "orange"]', 1);

        $this->insertLesson($module2Id, $courseId, 'Dictionaries', 'dictionaries',
            '<h2>Dictionaries</h2><p>Dictionaries store key-value pairs. They are unordered and mutable.</p>',
            '# Dictionaries\nperson = {\n    "name": "John",\n    "age": 30,\n    "city": "New York"\n}\nprint(person["name"])  # John\nperson["email"] = "john@example.com"\nprint(person)', 2);

        // Module 3: Control Flow
        $module3Id = $this->insertModule($courseId, 'Control Flow', 'Learn about conditionals, loops, and program flow control.', 3);
        
        $this->insertLesson($module3Id, $courseId, 'If Statements', 'if-statements',
            '<h2>Conditional Statements</h2><p>Use if, elif, and else to control program flow based on conditions.</p>',
            '# If statements\nage = 18\n\nif age >= 18:\n    print("You are an adult")\nelif age >= 13:\n    print("You are a teenager")\nelse:\n    print("You are a child")', 1);

        $this->insertLesson($module3Id, $courseId, 'Loops', 'loops',
            '<h2>Loops in Python</h2><p>Python supports for and while loops for iteration.</p>',
            '# For loop\nfor i in range(5):\n    print(i)\n\n# While loop\ncount = 0\nwhile count < 5:\n    print(count)\n    count += 1', 2);

        return $courseId;
    }

    private function insertJavaScriptCourse()
    {
        $courseData = [
            'title'       => 'JavaScript Programming',
            'slug'        => 'javascript-programming',
            'description' => 'Learn JavaScript from scratch. Master the fundamentals of web programming, DOM manipulation, modern ES6+ features, and build interactive web applications.',
            'difficulty'  => 'beginner',
            'status'      => 'published',
            'sort_order'  => 2,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $this->db->table('courses')->insert($courseData);
        $courseId = $this->db->insertID();

        // Module 1: JavaScript Basics
        $module1Id = $this->insertModule($courseId, 'JavaScript Basics', 'Get started with JavaScript fundamentals and syntax.', 1);
        
        $this->insertLesson($module1Id, $courseId, 'Introduction to JavaScript', 'introduction-to-javascript',
            '<h2>What is JavaScript?</h2><p>JavaScript is a versatile programming language primarily used for web development. It enables interactive web pages and is an essential part of web applications.</p><h3>Key Features:</h3><ul><li>Client-side scripting language</li><li>Runs in web browsers</li><li>Can be used for both frontend and backend (Node.js)</li><li>Dynamic and flexible</li></ul>',
            'console.log("Hello, World!");\nlet message = "Welcome to JavaScript";\nconsole.log(message);', 1);

        $this->insertLesson($module1Id, $courseId, 'Variables and Data Types', 'javascript-variables',
            '<h2>Variables in JavaScript</h2><p>JavaScript has three ways to declare variables: var, let, and const.</p><h3>Data Types:</h3><ul><li>Number: 42, 3.14</li><li>String: "Hello"</li><li>Boolean: true, false</li><li>Undefined, Null</li><li>Object, Array</li></ul>',
            '// Variables\nlet name = "JavaScript";\nconst version = "ES6+";\nvar age = 25;\n\nconsole.log(name);\nconsole.log(version);\nconsole.log(age);', 2);

        $this->insertLesson($module1Id, $courseId, 'Functions', 'javascript-functions',
            '<h2>Functions in JavaScript</h2><p>Functions are reusable blocks of code that perform specific tasks.</p>',
            '// Function declaration\nfunction greet(name) {\n    return `Hello, ${name}!`;\n}\n\n// Arrow function\nconst add = (a, b) => a + b;\n\nconsole.log(greet("World"));\nconsole.log(add(5, 3));', 3);

        // Module 2: DOM Manipulation
        $module2Id = $this->insertModule($courseId, 'DOM Manipulation', 'Learn how to interact with HTML elements using JavaScript.', 2);
        
        $this->insertLesson($module2Id, $courseId, 'Selecting Elements', 'selecting-elements',
            '<h2>DOM Selection</h2><p>JavaScript provides various methods to select and manipulate HTML elements.</p>',
            '// Select element by ID\nconst element = document.getElementById("myId");\n\n// Select by class\nconst elements = document.getElementsByClassName("myClass");\n\n// Modern selectors\nconst element = document.querySelector("#myId");\nconst elements = document.querySelectorAll(".myClass");', 1);

        $this->insertLesson($module2Id, $courseId, 'Event Handling', 'event-handling',
            '<h2>Event Handling</h2><p>Learn how to respond to user interactions like clicks, keyboard input, and more.</p>',
            '// Add event listener\nconst button = document.querySelector("#myButton");\n\nbutton.addEventListener("click", function() {\n    console.log("Button clicked!");\n});\n\n// Arrow function\nbutton.addEventListener("click", () => {\n    alert("Hello!");\n});', 2);

        // Module 3: Arrays and Objects
        $module3Id = $this->insertModule($courseId, 'Arrays and Objects', 'Master working with arrays and objects in JavaScript.', 3);
        
        $this->insertLesson($module3Id, $courseId, 'Arrays', 'javascript-arrays',
            '<h2>Arrays in JavaScript</h2><p>Arrays are used to store multiple values in a single variable.</p>',
            '// Creating arrays\nconst fruits = ["apple", "banana", "cherry"];\nconst numbers = [1, 2, 3, 4, 5];\n\n// Array methods\nfruits.push("orange");\nfruits.pop();\n\n// Iteration\nfruits.forEach(fruit => console.log(fruit));\nconst doubled = numbers.map(n => n * 2);', 1);

        $this->insertLesson($module3Id, $courseId, 'Objects', 'javascript-objects',
            '<h2>Objects in JavaScript</h2><p>Objects store data as key-value pairs and are fundamental to JavaScript.</p>',
            '// Creating objects\nconst person = {\n    name: "John",\n    age: 30,\n    city: "New York"\n};\n\n// Accessing properties\nconsole.log(person.name);\nconsole.log(person["age"]);\n\n// Adding properties\nperson.email = "john@example.com";', 2);

        return $courseId;
    }

    private function insertModule($courseId, $title, $description, $sortOrder)
    {
        $moduleData = [
            'course_id'   => $courseId,
            'title'       => $title,
            'description' => $description,
            'sort_order'  => $sortOrder,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $this->db->table('modules')->insert($moduleData);
        return $this->db->insertID();
    }

    private function insertLesson($moduleId, $courseId, $title, $slug, $content, $codeExamples, $sortOrder)
    {
        $lessonData = [
            'module_id'     => $moduleId,
            'course_id'     => $courseId,
            'title'         => $title,
            'slug'          => $slug,
            'content'       => $content,
            'code_examples' => $codeExamples,
            'status'        => 'published',
            'content_type'  => 'text',
            'sort_order'    => $sortOrder,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        $this->db->table('lessons')->insert($lessonData);
        return $this->db->insertID();
    }
}

