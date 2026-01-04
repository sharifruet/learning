<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PythonLessonsSeeder extends Seeder
{
    public function run()
    {
        // Find Python course
        $pythonCourse = $this->db->table('courses')
            ->where('slug', 'python-programming')
            ->get()
            ->getRowArray();

        if (!$pythonCourse) {
            echo "Python course not found. Please run MasterDataSeeder first.\n";
            return;
        }

        $courseId = $pythonCourse['id'];
        echo "Found Python course (ID: {$courseId})\n";

        // Get or create Module 1: Getting Started with Python
        $module1 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Getting Started with Python')
            ->get()
            ->getRowArray();

        if (!$module1) {
            $module1Id = $this->insertModule($courseId, 'Getting Started with Python', 
                'Learn the fundamentals of Python programming and set up your development environment.', 1);
            echo "Created Module 1 (ID: {$module1Id})\n";
        } else {
            $module1Id = $module1['id'];
            echo "Found Module 1 (ID: {$module1Id})\n";
        }

        // Get or create Module 2: Operators and Expressions
        $module2 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Operators and Expressions')
            ->get()
            ->getRowArray();

        if (!$module2) {
            $module2Id = $this->insertModule($courseId, 'Operators and Expressions', 
                'Learn about arithmetic, comparison, and logical operators in Python.', 2);
            echo "Created Module 2 (ID: {$module2Id})\n";
        } else {
            $module2Id = $module2['id'];
            echo "Found Module 2 (ID: {$module2Id})\n";
        }

        // Import lessons
        $lessonsPath = ROOTPATH . 'python/';
        
        // Lesson 1.1: Introduction to Python
        $this->importLesson($module1Id, $courseId, $lessonsPath . 'lesson_1_1.md', 
            'Introduction to Python', 'introduction-to-python', 1);
        
        // Lesson 1.2: Python Syntax and Basics
        $this->importLesson($module1Id, $courseId, $lessonsPath . 'lesson_1_2.md', 
            'Python Syntax and Basics', 'python-syntax-and-basics', 2);
        
        // Lesson 1.3: Variables and Data Types
        $this->importLesson($module1Id, $courseId, $lessonsPath . 'lesson_1_3.md', 
            'Variables and Data Types', 'variables-and-data-types', 3);
        
        // Lesson 2.1: Arithmetic Operators
        $this->importLesson($module2Id, $courseId, $lessonsPath . 'lesson_2_1.md', 
            'Arithmetic Operators', 'arithmetic-operators', 1);
        
        // Lesson 2.2: Comparison and Logical Operators
        $this->importLesson($module2Id, $courseId, $lessonsPath . 'lesson_2_2.md', 
            'Comparison and Logical Operators', 'comparison-and-logical-operators', 2);
        
        // Lesson 2.3: Assignment Operators
        $this->importLesson($module2Id, $courseId, $lessonsPath . 'lesson_2_3.md', 
            'Assignment Operators', 'assignment-operators', 3);

        // Get or create Module 3: Data Structures - Lists and Tuples
        $module3 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Data Structures - Lists and Tuples')
            ->get()
            ->getRowArray();

        if (!$module3) {
            $module3Id = $this->insertModule($courseId, 'Data Structures - Lists and Tuples', 
                'Learn about lists, tuples, and nested data structures in Python.', 3);
            echo "Created Module 3 (ID: {$module3Id})\n";
        } else {
            $module3Id = $module3['id'];
            echo "Found Module 3 (ID: {$module3Id})\n";
        }
        
        // Lesson 3.1: Lists
        $this->importLesson($module3Id, $courseId, $lessonsPath . 'lesson_3_1.md', 
            'Lists', 'lists', 1);
        
        // Lesson 3.2: Tuples
        $this->importLesson($module3Id, $courseId, $lessonsPath . 'lesson_3_2.md', 
            'Tuples', 'tuples', 2);
        
        // Lesson 3.3: Nested Data Structures
        $this->importLesson($module3Id, $courseId, $lessonsPath . 'lesson_3_3.md', 
            'Nested Data Structures', 'nested-data-structures', 3);

        // Get or create Module 4: Data Structures - Dictionaries and Sets
        $module4 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Data Structures - Dictionaries and Sets')
            ->get()
            ->getRowArray();

        if (!$module4) {
            $module4Id = $this->insertModule($courseId, 'Data Structures - Dictionaries and Sets', 
                'Learn about dictionaries, sets, and how to choose the right data structure.', 4);
            echo "Created Module 4 (ID: {$module4Id})\n";
        } else {
            $module4Id = $module4['id'];
            echo "Found Module 4 (ID: {$module4Id})\n";
        }
        
        // Lesson 4.1: Dictionaries
        $this->importLesson($module4Id, $courseId, $lessonsPath . 'lesson_4_1.md', 
            'Dictionaries', 'dictionaries', 1);
        
        // Lesson 4.2: Sets
        $this->importLesson($module4Id, $courseId, $lessonsPath . 'lesson_4_2.md', 
            'Sets', 'sets', 2);
        
        // Lesson 4.3: Choosing the Right Data Structure
        $this->importLesson($module4Id, $courseId, $lessonsPath . 'lesson_4_3.md', 
            'Choosing the Right Data Structure', 'choosing-the-right-data-structure', 3);

        // Get or create Module 5: Control Flow
        $module5 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Control Flow')
            ->get()
            ->getRowArray();

        if (!$module5) {
            $module5Id = $this->insertModule($courseId, 'Control Flow', 
                'Learn about conditionals, loops, and program flow control in Python.', 5);
            echo "Created Module 5 (ID: {$module5Id})\n";
        } else {
            $module5Id = $module5['id'];
            echo "Found Module 5 (ID: {$module5Id})\n";
        }
        
        // Lesson 5.1: Conditional Statements
        $this->importLesson($module5Id, $courseId, $lessonsPath . 'lesson_5_1.md', 
            'Conditional Statements', 'conditional-statements', 1);
        
        // Lesson 5.2: Loops - For Loops
        $this->importLesson($module5Id, $courseId, $lessonsPath . 'lesson_5_2.md', 
            'Loops - For Loops', 'loops-for-loops', 2);
        
        // Lesson 5.3: Loops - While Loops
        $this->importLesson($module5Id, $courseId, $lessonsPath . 'lesson_5_3.md', 
            'Loops - While Loops', 'loops-while-loops', 3);
        
        // Lesson 5.4: Loop Techniques
        $this->importLesson($module5Id, $courseId, $lessonsPath . 'lesson_5_4.md', 
            'Loop Techniques', 'loop-techniques', 4);

        // Get or create Module 6: Functions
        $module6 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Functions')
            ->get()
            ->getRowArray();

        if (!$module6) {
            $module6Id = $this->insertModule($courseId, 'Functions', 
                'Learn how to define, call, and use functions effectively in Python.', 6);
            echo "Created Module 6 (ID: {$module6Id})\n";
        } else {
            $module6Id = $module6['id'];
            echo "Found Module 6 (ID: {$module6Id})\n";
        }
        
        // Lesson 6.1: Function Basics
        $this->importLesson($module6Id, $courseId, $lessonsPath . 'lesson_6_1.md', 
            'Function Basics', 'function-basics', 1);
        
        // Lesson 6.2: Function Arguments
        $this->importLesson($module6Id, $courseId, $lessonsPath . 'lesson_6_2.md', 
            'Function Arguments', 'function-arguments', 2);
        
        // Lesson 6.3: Scope and Namespaces
        $this->importLesson($module6Id, $courseId, $lessonsPath . 'lesson_6_3.md', 
            'Scope and Namespaces', 'scope-and-namespaces', 3);
        
        // Lesson 6.4: Lambda Functions
        $this->importLesson($module6Id, $courseId, $lessonsPath . 'lesson_6_4.md', 
            'Lambda Functions', 'lambda-functions', 4);

        // Get or create Module 7: String Manipulation
        $module7 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'String Manipulation')
            ->get()
            ->getRowArray();

        if (!$module7) {
            $module7Id = $this->insertModule($courseId, 'String Manipulation', 
                'Learn advanced string operations, formatting, and regular expressions in Python.', 7);
            echo "Created Module 7 (ID: {$module7Id})\n";
        } else {
            $module7Id = $module7['id'];
            echo "Found Module 7 (ID: {$module7Id})\n";
        }
        
        // Lesson 7.1: String Methods
        $this->importLesson($module7Id, $courseId, $lessonsPath . 'lesson_7_1.md', 
            'String Methods', 'string-methods', 1);
        
        // Lesson 7.2: Regular Expressions
        $this->importLesson($module7Id, $courseId, $lessonsPath . 'lesson_7_2.md', 
            'Regular Expressions', 'regular-expressions', 2);

        // Get or create Module 8: Object-Oriented Programming
        $module8 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Object-Oriented Programming')
            ->get()
            ->getRowArray();

        if (!$module8) {
            $module8Id = $this->insertModule($courseId, 'Object-Oriented Programming', 
                'Learn object-oriented programming concepts including classes, objects, inheritance, and polymorphism.', 8);
            echo "Created Module 8 (ID: {$module8Id})\n";
        } else {
            $module8Id = $module8['id'];
            echo "Found Module 8 (ID: {$module8Id})\n";
        }
        
        // Lesson 8.1: Classes and Objects
        $this->importLesson($module8Id, $courseId, $lessonsPath . 'lesson_8_1.md', 
            'Classes and Objects', 'classes-and-objects', 1);
        
        // Lesson 8.2: Inheritance (or Methods and Attributes if 8.2 is that)
        // Check if 8.2 exists, if not check for 8.3
        if (file_exists($lessonsPath . 'lesson_8_2.md')) {
            $this->importLesson($module8Id, $courseId, $lessonsPath . 'lesson_8_2.md', 
                'Methods and Attributes', 'methods-and-attributes', 2);
        }
        
        // Lesson 8.3: Constructors and Special Methods
        if (file_exists($lessonsPath . 'lesson_8_3.md')) {
            $this->importLesson($module8Id, $courseId, $lessonsPath . 'lesson_8_3.md', 
                'Constructors and Special Methods', 'constructors-and-special-methods', 3);
        }
        
        // For inheritance, check if there's a specific lesson file
        // Based on the outline, 8.4 should be Inheritance
        // Let's check what files exist and use them appropriately
        $lesson82 = $this->db->table('lessons')
            ->where('module_id', $module8Id)
            ->where('slug', 'inheritance')
            ->get()
            ->getRowArray();
        
        if (!$lesson82 && file_exists($lessonsPath . 'lesson_8_5.md')) {
            // If inheritance wasn't imported yet and 8.5 exists, it might be inheritance
            $this->importLesson($module8Id, $courseId, $lessonsPath . 'lesson_8_5.md', 
                'Inheritance', 'inheritance', 4);
        } elseif (!$lesson82 && file_exists($lessonsPath . 'lesson_8_6.md')) {
            $this->importLesson($module8Id, $courseId, $lessonsPath . 'lesson_8_6.md', 
                'Inheritance', 'inheritance', 4);
        }

        // Get or create Module 9: File Handling
        $module9 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'File Handling')
            ->get()
            ->getRowArray();

        if (!$module9) {
            $module9Id = $this->insertModule($courseId, 'File Handling', 
                'Learn how to read from and write to files in Python.', 9);
            echo "Created Module 9 (ID: {$module9Id})\n";
        } else {
            $module9Id = $module9['id'];
            echo "Found Module 9 (ID: {$module9Id})\n";
        }
        
        // Lesson 9.1: Reading and Writing Files
        if (file_exists($lessonsPath . 'lesson_9_1.md')) {
            $this->importLesson($module9Id, $courseId, $lessonsPath . 'lesson_9_1.md', 
                'Reading and Writing Files', 'reading-and-writing-files', 1);
        }
        
        // Lesson 9.2: Working with File Paths
        if (file_exists($lessonsPath . 'lesson_9_2.md')) {
            $this->importLesson($module9Id, $courseId, $lessonsPath . 'lesson_9_2.md', 
                'Working with File Paths', 'working-with-file-paths', 2);
        }
        
        // Lesson 9.3: Context Managers
        if (file_exists($lessonsPath . 'lesson_9_3.md')) {
            $this->importLesson($module9Id, $courseId, $lessonsPath . 'lesson_9_3.md', 
                'Context Managers', 'context-managers', 3);
        }
        
        // Lesson 9.4: Working with Different File Formats
        if (file_exists($lessonsPath . 'lesson_9_4.md')) {
            $this->importLesson($module9Id, $courseId, $lessonsPath . 'lesson_9_4.md', 
                'Working with Different File Formats', 'working-with-different-file-formats', 4);
        }

        // Get or create Module 10: Error Handling and Debugging
        $module10 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Error Handling and Debugging')
            ->get()
            ->getRowArray();

        if (!$module10) {
            $module10Id = $this->insertModule($courseId, 'Error Handling and Debugging', 
                'Learn how to handle errors, exceptions, and debug Python programs.', 10);
            echo "Created Module 10 (ID: {$module10Id})\n";
        } else {
            $module10Id = $module10['id'];
            echo "Found Module 10 (ID: {$module10Id})\n";
        }
        
        // Lesson 10.1: Exceptions
        if (file_exists($lessonsPath . 'lesson_10_1.md')) {
            $this->importLesson($module10Id, $courseId, $lessonsPath . 'lesson_10_1.md', 
                'Exceptions', 'exceptions', 1);
        }
        
        // Lesson 10.2: Try-Except Blocks
        if (file_exists($lessonsPath . 'lesson_10_2.md')) {
            $this->importLesson($module10Id, $courseId, $lessonsPath . 'lesson_10_2.md', 
                'Try-Except Blocks', 'try-except-blocks', 2);
        }
        
        // Lesson 10.3: Raising Exceptions
        if (file_exists($lessonsPath . 'lesson_10_3.md')) {
            $this->importLesson($module10Id, $courseId, $lessonsPath . 'lesson_10_3.md', 
                'Raising Exceptions', 'raising-exceptions', 3);
        }
        
        // Lesson 10.4: Debugging Techniques
        if (file_exists($lessonsPath . 'lesson_10_4.md')) {
            $this->importLesson($module10Id, $courseId, $lessonsPath . 'lesson_10_4.md', 
                'Debugging Techniques', 'debugging-techniques', 4);
        }

        // Get or create Module 11: Modules and Packages
        $module11 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Modules and Packages')
            ->get()
            ->getRowArray();

        if (!$module11) {
            $module11Id = $this->insertModule($courseId, 'Modules and Packages', 
                'Learn how to organize code using modules and packages in Python.', 11);
            echo "Created Module 11 (ID: {$module11Id})\n";
        } else {
            $module11Id = $module11['id'];
            echo "Found Module 11 (ID: {$module11Id})\n";
        }
        
        // Lesson 11.1: Importing Modules
        if (file_exists($lessonsPath . 'lesson_11_1.md')) {
            $this->importLesson($module11Id, $courseId, $lessonsPath . 'lesson_11_1.md', 
                'Importing Modules', 'importing-modules', 1);
        }
        
        // Lesson 11.2: Creating Modules
        if (file_exists($lessonsPath . 'lesson_11_2.md')) {
            $this->importLesson($module11Id, $courseId, $lessonsPath . 'lesson_11_2.md', 
                'Creating Modules', 'creating-modules', 2);
        }
        
        // Lesson 11.3: Packages
        if (file_exists($lessonsPath . 'lesson_11_3.md')) {
            $this->importLesson($module11Id, $courseId, $lessonsPath . 'lesson_11_3.md', 
                'Packages', 'packages', 3);
        }
        
        // Lesson 11.4: Standard Library Overview
        if (file_exists($lessonsPath . 'lesson_11_4.md')) {
            $this->importLesson($module11Id, $courseId, $lessonsPath . 'lesson_11_4.md', 
                'Standard Library Overview', 'standard-library-overview', 4);
        }

        // Get or create Module 12: Advanced Data Structures
        $module12 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Advanced Data Structures')
            ->get()
            ->getRowArray();

        if (!$module12) {
            $module12Id = $this->insertModule($courseId, 'Advanced Data Structures', 
                'Learn advanced data structures from the collections module and other advanced Python features.', 12);
            echo "Created Module 12 (ID: {$module12Id})\n";
        } else {
            $module12Id = $module12['id'];
            echo "Found Module 12 (ID: {$module12Id})\n";
        }
        
        // Lesson 12.1: Collections Module
        if (file_exists($lessonsPath . 'lesson_12_1.md')) {
            $this->importLesson($module12Id, $courseId, $lessonsPath . 'lesson_12_1.md', 
                'Collections Module', 'collections-module', 1);
        }
        
        // Lesson 12.2: Generators and Iterators
        if (file_exists($lessonsPath . 'lesson_12_2.md')) {
            $this->importLesson($module12Id, $courseId, $lessonsPath . 'lesson_12_2.md', 
                'Generators and Iterators', 'generators-and-iterators', 2);
        }
        
        // Lesson 12.3: Comprehensions Advanced
        if (file_exists($lessonsPath . 'lesson_12_3.md')) {
            $this->importLesson($module12Id, $courseId, $lessonsPath . 'lesson_12_3.md', 
                'Comprehensions Advanced', 'comprehensions-advanced', 3);
        }

        // Get or create Module 13: Decorators
        $module13 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Decorators')
            ->get()
            ->getRowArray();

        if (!$module13) {
            $module13Id = $this->insertModule($courseId, 'Decorators', 
                'Learn how to use and create decorators in Python for function and class modification.', 13);
            echo "Created Module 13 (ID: {$module13Id})\n";
        } else {
            $module13Id = $module13['id'];
            echo "Found Module 13 (ID: {$module13Id})\n";
        }
        
        // Lesson 13.1: Understanding Decorators
        if (file_exists($lessonsPath . 'lesson_13_1.md')) {
            $this->importLesson($module13Id, $courseId, $lessonsPath . 'lesson_13_1.md', 
                'Understanding Decorators', 'understanding-decorators', 1);
        }
        
        // Lesson 13.2: Creating Decorators
        if (file_exists($lessonsPath . 'lesson_13_2.md')) {
            $this->importLesson($module13Id, $courseId, $lessonsPath . 'lesson_13_2.md', 
                'Creating Decorators', 'creating-decorators', 2);
        }
        
        // Lesson 13.3: Class Decorators
        if (file_exists($lessonsPath . 'lesson_13_3.md')) {
            $this->importLesson($module13Id, $courseId, $lessonsPath . 'lesson_13_3.md', 
                'Class Decorators', 'class-decorators', 3);
        }
        
        // Lesson 13.4: Advanced Decorator Patterns
        if (file_exists($lessonsPath . 'lesson_13_4.md')) {
            $this->importLesson($module13Id, $courseId, $lessonsPath . 'lesson_13_4.md', 
                'Advanced Decorator Patterns', 'advanced-decorator-patterns', 4);
        }

        // Get or create Module 14: Context Managers and Resource Management
        $module14 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Context Managers and Resource Management')
            ->get()
            ->getRowArray();

        if (!$module14) {
            $module14Id = $this->insertModule($courseId, 'Context Managers and Resource Management', 
                'Learn how to use context managers for proper resource management in Python.', 14);
            echo "Created Module 14 (ID: {$module14Id})\n";
        } else {
            $module14Id = $module14['id'];
            echo "Found Module 14 (ID: {$module14Id})\n";
        }
        
        // Lesson 14.1: Context Manager Protocol
        if (file_exists($lessonsPath . 'lesson_14_1.md')) {
            $this->importLesson($module14Id, $courseId, $lessonsPath . 'lesson_14_1.md', 
                'Context Manager Protocol', 'context-manager-protocol', 1);
        }
        
        // Lesson 14.2: contextlib Module
        if (file_exists($lessonsPath . 'lesson_14_2.md')) {
            $this->importLesson($module14Id, $courseId, $lessonsPath . 'lesson_14_2.md', 
                'contextlib Module', 'contextlib-module', 2);
        }

        // Get or create Module 15: Metaclasses and Descriptors
        $module15 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Metaclasses and Descriptors')
            ->get()
            ->getRowArray();

        if (!$module15) {
            $module15Id = $this->insertModule($courseId, 'Metaclasses and Descriptors', 
                'Learn advanced Python concepts including descriptors and metaclasses.', 15);
            echo "Created Module 15 (ID: {$module15Id})\n";
        } else {
            $module15Id = $module15['id'];
            echo "Found Module 15 (ID: {$module15Id})\n";
        }
        
        // Lesson 15.1: Descriptors
        if (file_exists($lessonsPath . 'lesson_15_1.md')) {
            $this->importLesson($module15Id, $courseId, $lessonsPath . 'lesson_15_1.md', 
                'Descriptors', 'descriptors', 1);
        }
        
        // Lesson 15.2: Metaclasses
        if (file_exists($lessonsPath . 'lesson_15_2.md')) {
            $this->importLesson($module15Id, $courseId, $lessonsPath . 'lesson_15_2.md', 
                'Metaclasses', 'metaclasses', 2);
        }

        // Get or create Module 16: Concurrency and Parallelism
        $module16 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Concurrency and Parallelism')
            ->get()
            ->getRowArray();

        if (!$module16) {
            $module16Id = $this->insertModule($courseId, 'Concurrency and Parallelism', 
                'Learn about threading, multiprocessing, and asynchronous programming in Python.', 16);
            echo "Created Module 16 (ID: {$module16Id})\n";
        } else {
            $module16Id = $module16['id'];
            echo "Found Module 16 (ID: {$module16Id})\n";
        }
        
        // Lesson 16.1: Threading
        if (file_exists($lessonsPath . 'lesson_16_1.md')) {
            $this->importLesson($module16Id, $courseId, $lessonsPath . 'lesson_16_1.md', 
                'Threading', 'threading', 1);
        }
        
        // Lesson 16.2: Multiprocessing
        if (file_exists($lessonsPath . 'lesson_16_2.md')) {
            $this->importLesson($module16Id, $courseId, $lessonsPath . 'lesson_16_2.md', 
                'Multiprocessing', 'multiprocessing', 2);
        }
        
        // Lesson 16.3: Asynchronous Programming
        if (file_exists($lessonsPath . 'lesson_16_3.md')) {
            $this->importLesson($module16Id, $courseId, $lessonsPath . 'lesson_16_3.md', 
                'Asynchronous Programming', 'asynchronous-programming', 3);
        }

        // Get or create Module 17: Testing
        $module17 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Testing')
            ->get()
            ->getRowArray();

        if (!$module17) {
            $module17Id = $this->insertModule($courseId, 'Testing', 
                'Learn how to write and run tests for your Python code.', 17);
            echo "Created Module 17 (ID: {$module17Id})\n";
        } else {
            $module17Id = $module17['id'];
            echo "Found Module 17 (ID: {$module17Id})\n";
        }
        
        // Lesson 17.1: Testing Basics
        if (file_exists($lessonsPath . 'lesson_17_1.md')) {
            $this->importLesson($module17Id, $courseId, $lessonsPath . 'lesson_17_1.md', 
                'Testing Basics', 'testing-basics', 1);
        }
        
        // Lesson 17.2: pytest Framework
        if (file_exists($lessonsPath . 'lesson_17_2.md')) {
            $this->importLesson($module17Id, $courseId, $lessonsPath . 'lesson_17_2.md', 
                'pytest Framework', 'pytest-framework', 2);
        }
        
        // Lesson 17.3: Test-Driven Development (TDD)
        if (file_exists($lessonsPath . 'lesson_17_3.md')) {
            $this->importLesson($module17Id, $courseId, $lessonsPath . 'lesson_17_3.md', 
                'Test-Driven Development (TDD)', 'test-driven-development', 3);
        }
        
        // Lesson 17.4: Mocking and Patching
        if (file_exists($lessonsPath . 'lesson_17_4.md')) {
            $this->importLesson($module17Id, $courseId, $lessonsPath . 'lesson_17_4.md', 
                'Mocking and Patching', 'mocking-and-patching', 4);
        }

        // Get or create Module 18: Performance Optimization
        $module18 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Performance Optimization')
            ->get()
            ->getRowArray();

        if (!$module18) {
            $module18Id = $this->insertModule($courseId, 'Performance Optimization', 
                'Learn how to profile and optimize Python code for better performance.', 18);
            echo "Created Module 18 (ID: {$module18Id})\n";
        } else {
            $module18Id = $module18['id'];
            echo "Found Module 18 (ID: {$module18Id})\n";
        }
        
        // Lesson 18.1: Profiling
        if (file_exists($lessonsPath . 'lesson_18_1.md')) {
            $this->importLesson($module18Id, $courseId, $lessonsPath . 'lesson_18_1.md', 
                'Profiling', 'profiling', 1);
        }
        
        // Lesson 18.2: Optimization Techniques
        if (file_exists($lessonsPath . 'lesson_18_2.md')) {
            $this->importLesson($module18Id, $courseId, $lessonsPath . 'lesson_18_2.md', 
                'Optimization Techniques', 'optimization-techniques', 2);
        }

        // Get or create Module 19: Web Development Basics
        $module19 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Web Development Basics')
            ->get()
            ->getRowArray();

        if (!$module19) {
            $module19Id = $this->insertModule($courseId, 'Web Development Basics', 
                'Learn the fundamentals of web development with Python.', 19);
            echo "Created Module 19 (ID: {$module19Id})\n";
        } else {
            $module19Id = $module19['id'];
            echo "Found Module 19 (ID: {$module19Id})\n";
        }
        
        // Lesson 19.1: HTTP and Web Concepts
        if (file_exists($lessonsPath . 'lesson_19_1.md')) {
            $this->importLesson($module19Id, $courseId, $lessonsPath . 'lesson_19_1.md', 
                'HTTP and Web Concepts', 'http-and-web-concepts', 1);
        }
        
        // Lesson 19.2: Flask Framework
        if (file_exists($lessonsPath . 'lesson_19_2.md')) {
            $this->importLesson($module19Id, $courseId, $lessonsPath . 'lesson_19_2.md', 
                'Flask Framework', 'flask-framework', 2);
        }
        
        // Lesson 19.3: Django Basics (if available)
        if (file_exists($lessonsPath . 'lesson_19_3.md')) {
            $this->importLesson($module19Id, $courseId, $lessonsPath . 'lesson_19_3.md', 
                'Django Basics', 'django-basics', 3);
        }
        
        // Lesson 19.4: (if available)
        if (file_exists($lessonsPath . 'lesson_19_4.md')) {
            $this->importLesson($module19Id, $courseId, $lessonsPath . 'lesson_19_4.md', 
                'RESTful APIs with Python', 'restful-apis-with-python', 4);
        }

        // Get or create Module 20: Working with APIs
        $module20 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Working with APIs')
            ->get()
            ->getRowArray();

        if (!$module20) {
            $module20Id = $this->insertModule($courseId, 'Working with APIs', 
                'Learn how to consume and build APIs with Python.', 20);
            echo "Created Module 20 (ID: {$module20Id})\n";
        } else {
            $module20Id = $module20['id'];
            echo "Found Module 20 (ID: {$module20Id})\n";
        }
        
        // Lesson 20.1: Consuming APIs
        if (file_exists($lessonsPath . 'lesson_20_1.md')) {
            $this->importLesson($module20Id, $courseId, $lessonsPath . 'lesson_20_1.md', 
                'Consuming APIs', 'consuming-apis', 1);
        }
        
        // Lesson 20.2: Building REST APIs
        if (file_exists($lessonsPath . 'lesson_20_2.md')) {
            $this->importLesson($module20Id, $courseId, $lessonsPath . 'lesson_20_2.md', 
                'Building REST APIs', 'building-rest-apis', 2);
        }
        
        // Lesson 20.3: GraphQL Basics
        if (file_exists($lessonsPath . 'lesson_20_3.md')) {
            $this->importLesson($module20Id, $courseId, $lessonsPath . 'lesson_20_3.md', 
                'GraphQL Basics', 'graphql-basics', 3);
        }

        // Get or create Module 21: NumPy (for Data Science course)
        $module21 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'NumPy')
            ->get()
            ->getRowArray();

        if (!$module21) {
            $module21Id = $this->insertModule($courseId, 'NumPy', 
                'Learn NumPy for numerical computing in Python.', 21);
            echo "Created Module 21 (ID: {$module21Id})\n";
        } else {
            $module21Id = $module21['id'];
            echo "Found Module 21 (ID: {$module21Id})\n";
        }
        
        // Lesson 21.1: NumPy Basics
        if (file_exists($lessonsPath . 'lesson_21_1.md')) {
            $this->importLesson($module21Id, $courseId, $lessonsPath . 'lesson_21_1.md', 
                'NumPy Basics', 'numpy-basics', 1);
        }
        
        // Lesson 21.2: Array Operations
        if (file_exists($lessonsPath . 'lesson_21_2.md')) {
            $this->importLesson($module21Id, $courseId, $lessonsPath . 'lesson_21_2.md', 
                'Array Operations', 'array-operations', 2);
        }

        // Get or create Module 22: Pandas
        $module22 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Pandas')
            ->get()
            ->getRowArray();

        if (!$module22) {
            $module22Id = $this->insertModule($courseId, 'Pandas', 
                'Learn Pandas for data manipulation and analysis in Python.', 22);
            echo "Created Module 22 (ID: {$module22Id})\n";
        } else {
            $module22Id = $module22['id'];
            echo "Found Module 22 (ID: {$module22Id})\n";
        }
        
        // Lesson 22.1: Pandas DataFrames
        if (file_exists($lessonsPath . 'lesson_22_1.md')) {
            $this->importLesson($module22Id, $courseId, $lessonsPath . 'lesson_22_1.md', 
                'Pandas DataFrames', 'pandas-dataframes', 1);
        }
        
        // Lesson 22.2: Data Manipulation
        if (file_exists($lessonsPath . 'lesson_22_2.md')) {
            $this->importLesson($module22Id, $courseId, $lessonsPath . 'lesson_22_2.md', 
                'Data Manipulation', 'data-manipulation', 2);
        }
        
        // Lesson 22.3: Data Cleaning
        if (file_exists($lessonsPath . 'lesson_22_3.md')) {
            $this->importLesson($module22Id, $courseId, $lessonsPath . 'lesson_22_3.md', 
                'Data Cleaning', 'data-cleaning', 3);
        }

        // Get or create Module 23: Data Visualization
        $module23 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Data Visualization')
            ->get()
            ->getRowArray();

        if (!$module23) {
            $module23Id = $this->insertModule($courseId, 'Data Visualization', 
                'Learn to create beautiful data visualizations with Matplotlib and Seaborn.', 23);
            echo "Created Module 23 (ID: {$module23Id})\n";
        } else {
            $module23Id = $module23['id'];
            echo "Found Module 23 (ID: {$module23Id})\n";
        }
        
        // Lesson 23.1: Matplotlib
        if (file_exists($lessonsPath . 'lesson_23_1.md')) {
            $this->importLesson($module23Id, $courseId, $lessonsPath . 'lesson_23_1.md', 
                'Matplotlib', 'matplotlib', 1);
        }
        
        // Lesson 23.2: Seaborn
        if (file_exists($lessonsPath . 'lesson_23_2.md')) {
            $this->importLesson($module23Id, $courseId, $lessonsPath . 'lesson_23_2.md', 
                'Seaborn', 'seaborn', 2);
        }

        // Get or create Module 24: Command-Line Tools (Project 1)
        $module24 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Command-Line Tools')
            ->get()
            ->getRowArray();

        if (!$module24) {
            $module24Id = $this->insertModule($courseId, 'Command-Line Tools', 
                'Build practical command-line interface applications with Python.', 24);
            echo "Created Module 24 (ID: {$module24Id})\n";
        } else {
            $module24Id = $module24['id'];
            echo "Found Module 24 (ID: {$module24Id})\n";
        }
        
        // Project 1.1: Building a CLI Application
        if (file_exists($lessonsPath . 'project_1_1.md')) {
            $this->importLesson($module24Id, $courseId, $lessonsPath . 'project_1_1.md', 
                'Building a CLI Application', 'building-a-cli-application', 1);
        }

        // Get or create Module 25: Web Scraping (Project 2)
        $module25 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Web Scraping')
            ->get()
            ->getRowArray();

        if (!$module25) {
            $module25Id = $this->insertModule($courseId, 'Web Scraping', 
                'Learn to scrape and extract data from websites using Python.', 25);
            echo "Created Module 25 (ID: {$module25Id})\n";
        } else {
            $module25Id = $module25['id'];
            echo "Found Module 25 (ID: {$module25Id})\n";
        }
        
        // Project 2.1: Web Scraping Basics
        if (file_exists($lessonsPath . 'project_2_1.md')) {
            $this->importLesson($module25Id, $courseId, $lessonsPath . 'project_2_1.md', 
                'Web Scraping Basics', 'web-scraping-basics', 1);
        }

        // Get or create Module 26: Database Applications (Project 3)
        $module26 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Database Applications')
            ->get()
            ->getRowArray();

        if (!$module26) {
            $module26Id = $this->insertModule($courseId, 'Database Applications', 
                'Build database-driven applications with SQLite and SQLAlchemy.', 26);
            echo "Created Module 26 (ID: {$module26Id})\n";
        } else {
            $module26Id = $module26['id'];
            echo "Found Module 26 (ID: {$module26Id})\n";
        }
        
        // Project 3.1: SQLite with Python
        if (file_exists($lessonsPath . 'project_3_1.md')) {
            $this->importLesson($module26Id, $courseId, $lessonsPath . 'project_3_1.md', 
                'SQLite with Python', 'sqlite-with-python', 1);
        }
        
        // Project 3.2: SQLAlchemy ORM
        if (file_exists($lessonsPath . 'project_3_2.md')) {
            $this->importLesson($module26Id, $courseId, $lessonsPath . 'project_3_2.md', 
                'SQLAlchemy ORM', 'sqlalchemy-orm', 2);
        }

        // Get or create Module 27: Automation Scripts (Project 4)
        $module27 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Automation Scripts')
            ->get()
            ->getRowArray();

        if (!$module27) {
            $module27Id = $this->insertModule($courseId, 'Automation Scripts', 
                'Create automation scripts to streamline file and system operations.', 27);
            echo "Created Module 27 (ID: {$module27Id})\n";
        } else {
            $module27Id = $module27['id'];
            echo "Found Module 27 (ID: {$module27Id})\n";
        }
        
        // Project 4.1: File Automation
        if (file_exists($lessonsPath . 'project_4_1.md')) {
            $this->importLesson($module27Id, $courseId, $lessonsPath . 'project_4_1.md', 
                'File Automation', 'file-automation', 1);
        }

        // Get or create Module 28: API Development (Project 5)
        $module28 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'API Development')
            ->get()
            ->getRowArray();

        if (!$module28) {
            $module28Id = $this->insertModule($courseId, 'API Development', 
                'Build full-stack REST APIs with authentication and documentation.', 28);
            echo "Created Module 28 (ID: {$module28Id})\n";
        } else {
            $module28Id = $module28['id'];
            echo "Found Module 28 (ID: {$module28Id})\n";
        }
        
        // Project 5.1: Full-Stack API Project
        if (file_exists($lessonsPath . 'project_5_1.md')) {
            $this->importLesson($module28Id, $courseId, $lessonsPath . 'project_5_1.md', 
                'Full-Stack API Project', 'full-stack-api-project', 1);
        }

        // Get or create Module 29: Code Quality (Module 24 from outline)
        $module29 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Code Quality')
            ->get()
            ->getRowArray();

        if (!$module29) {
            $module29Id = $this->insertModule($courseId, 'Code Quality', 
                'Learn best practices for writing clean, maintainable, and well-documented Python code.', 29);
            echo "Created Module 29 (ID: {$module29Id})\n";
        } else {
            $module29Id = $module29['id'];
            echo "Found Module 29 (ID: {$module29Id})\n";
        }
        
        // Lesson 24.1: PEP 8 Style Guide
        if (file_exists($lessonsPath . 'lesson_24_1.md')) {
            $this->importLesson($module29Id, $courseId, $lessonsPath . 'lesson_24_1.md', 
                'PEP 8 Style Guide', 'pep-8-style-guide', 1);
        }
        
        // Lesson 24.2: Code Documentation
        if (file_exists($lessonsPath . 'lesson_24_2.md')) {
            $this->importLesson($module29Id, $courseId, $lessonsPath . 'lesson_24_2.md', 
                'Code Documentation', 'code-documentation', 2);
        }
        
        // Lesson 24.3: Code Review
        if (file_exists($lessonsPath . 'lesson_24_3.md')) {
            $this->importLesson($module29Id, $courseId, $lessonsPath . 'lesson_24_3.md', 
                'Code Review', 'code-review', 3);
        }

        // Get or create Module 30: Design Patterns (Module 25 from outline)
        $module30 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Design Patterns')
            ->get()
            ->getRowArray();

        if (!$module30) {
            $module30Id = $this->insertModule($courseId, 'Design Patterns', 
                'Learn common design patterns in Python: Creational, Structural, and Behavioral patterns.', 30);
            echo "Created Module 30 (ID: {$module30Id})\n";
        } else {
            $module30Id = $module30['id'];
            echo "Found Module 30 (ID: {$module30Id})\n";
        }
        
        // Lesson 25.1: Creational Patterns
        if (file_exists($lessonsPath . 'lesson_25_1.md')) {
            $this->importLesson($module30Id, $courseId, $lessonsPath . 'lesson_25_1.md', 
                'Creational Patterns', 'creational-patterns', 1);
        }
        
        // Lesson 25.2: Structural Patterns
        if (file_exists($lessonsPath . 'lesson_25_2.md')) {
            $this->importLesson($module30Id, $courseId, $lessonsPath . 'lesson_25_2.md', 
                'Structural Patterns', 'structural-patterns', 2);
        }
        
        // Lesson 25.3: Behavioral Patterns
        if (file_exists($lessonsPath . 'lesson_25_3.md')) {
            $this->importLesson($module30Id, $courseId, $lessonsPath . 'lesson_25_3.md', 
                'Behavioral Patterns', 'behavioral-patterns', 3);
        }

        // Get or create Module 31: Software Architecture (Module 26 from outline)
        $module31 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Software Architecture')
            ->get()
            ->getRowArray();

        if (!$module31) {
            $module31Id = $this->insertModule($courseId, 'Software Architecture', 
                'Learn how to structure large Python projects and manage dependencies effectively.', 31);
            echo "Created Module 31 (ID: {$module31Id})\n";
        } else {
            $module31Id = $module31['id'];
            echo "Found Module 31 (ID: {$module31Id})\n";
        }
        
        // Lesson 26.1: Project Structure
        if (file_exists($lessonsPath . 'lesson_26_1.md')) {
            $this->importLesson($module31Id, $courseId, $lessonsPath . 'lesson_26_1.md', 
                'Project Structure', 'project-structure', 1);
        }
        
        // Lesson 26.2: Dependency Management
        if (file_exists($lessonsPath . 'lesson_26_2.md')) {
            $this->importLesson($module31Id, $courseId, $lessonsPath . 'lesson_26_2.md', 
                'Dependency Management', 'dependency-management', 2);
        }

        // Get or create Module 32: Capstone Project 1 - Full-Stack Web Application
        $module32 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Full-Stack Web Application')
            ->get()
            ->getRowArray();

        if (!$module32) {
            $module32Id = $this->insertModule($courseId, 'Full-Stack Web Application', 
                'Capstone Project: Build a complete full-stack web application using Python.', 32);
            echo "Created Module 32 (ID: {$module32Id})\n";
        } else {
            $module32Id = $module32['id'];
            echo "Found Module 32 (ID: {$module32Id})\n";
        }
        
        // Capstone Project 1: Full-Stack Web Application
        if (file_exists($lessonsPath . 'capstone_project_1.md')) {
            $this->importLesson($module32Id, $courseId, $lessonsPath . 'capstone_project_1.md', 
                'Full-Stack Web Application', 'full-stack-web-application', 1);
        }

        // Get or create Module 33: Capstone Project 2 - Data Analysis Project
        $module33 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Data Analysis Project')
            ->get()
            ->getRowArray();

        if (!$module33) {
            $module33Id = $this->insertModule($courseId, 'Data Analysis Project', 
                'Capstone Project: Build a comprehensive data analysis project using Python data science tools.', 33);
            echo "Created Module 33 (ID: {$module33Id})\n";
        } else {
            $module33Id = $module33['id'];
            echo "Found Module 33 (ID: {$module33Id})\n";
        }
        
        // Capstone Project 2: Data Analysis Project
        if (file_exists($lessonsPath . 'capstone_project_2.md')) {
            $this->importLesson($module33Id, $courseId, $lessonsPath . 'capstone_project_2.md', 
                'Data Analysis Project', 'data-analysis-project', 1);
        }

        // Get or create Module 34: Capstone Project 3 - API Development Project
        $module34 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'API Development Project')
            ->get()
            ->getRowArray();

        if (!$module34) {
            $module34Id = $this->insertModule($courseId, 'API Development Project', 
                'Capstone Project: Build a comprehensive REST API with authentication, documentation, and best practices.', 34);
            echo "Created Module 34 (ID: {$module34Id})\n";
        } else {
            $module34Id = $module34['id'];
            echo "Found Module 34 (ID: {$module34Id})\n";
        }
        
        // Capstone Project 3: API Development Project
        if (file_exists($lessonsPath . 'capstone_project_3.md')) {
            $this->importLesson($module34Id, $courseId, $lessonsPath . 'capstone_project_3.md', 
                'API Development Project', 'api-development-project', 1);
        }

        echo "\n✅ Successfully imported lessons!\n";
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

    private function importLesson($moduleId, $courseId, $filePath, $title, $slug, $sortOrder)
    {
        if (!file_exists($filePath)) {
            echo "⚠️  Warning: File not found: {$filePath}\n";
            return;
        }

        // Read the Markdown file
        $content = file_get_contents($filePath);
        
        if (empty($content)) {
            echo "⚠️  Warning: Empty file: {$filePath}\n";
            return;
        }

        // Extract learning objectives from the file (if present)
        $objectives = null;
        if (preg_match('/## Learning Objectives\s*\n\n(.*?)(?=\n---|\n##)/s', $content, $matches)) {
            $objectives = trim($matches[1]);
        }

        // Check if lesson already exists
        $existingLesson = $this->db->table('lessons')
            ->where('module_id', $moduleId)
            ->where('slug', $slug)
            ->get()
            ->getRowArray();

        $lessonData = [
            'module_id'     => $moduleId,
            'course_id'     => $courseId,
            'title'         => $title,
            'slug'          => $slug,
            'content'       => $content,
            'code_examples' => null, // Can be extracted later if needed
            'status'        => 'published',
            'content_type'  => 'markdown', // Store as markdown, will be parsed to HTML
            'sort_order'    => $sortOrder,
            'objectives'    => $objectives,
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        if ($existingLesson) {
            // Update existing lesson
            $this->db->table('lessons')
                ->where('id', $existingLesson['id'])
                ->update($lessonData);
            echo "  ✓ Updated: {$title}\n";
        } else {
            // Create new lesson
            $lessonData['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('lessons')->insert($lessonData);
            echo "  ✓ Created: {$title}\n";
        }
    }
}

