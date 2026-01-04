<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JavaScriptLessonsSeeder extends Seeder
{
    public function run()
    {
        // Find JavaScript Fundamentals subcourse (not the parent course)
        $javascriptFundamentals = $this->db->table('courses')
            ->where('slug', 'javascript-fundamentals')
            ->get()
            ->getRowArray();

        if (!$javascriptFundamentals) {
            echo "JavaScript Fundamentals subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $courseId = $javascriptFundamentals['id'];
        echo "Found JavaScript Fundamentals subcourse (ID: {$courseId})\n";

        // Get or create Module 1: Getting Started with JavaScript
        $module1 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Getting Started with JavaScript')
            ->get()
            ->getRowArray();

        if (!$module1) {
            $module1Id = $this->insertModule($courseId, 'Getting Started with JavaScript', 
                'Learn the fundamentals of JavaScript programming and set up your development environment.', 1);
            echo "Created Module 1 (ID: {$module1Id})\n";
        } else {
            $module1Id = $module1['id'];
            echo "Found Module 1 (ID: {$module1Id})\n";
        }

        // Import all lessons from Module 1: Getting Started with JavaScript
        $lessonsPath = ROOTPATH . 'javascript/';
        
        // Lesson 1.1: Introduction to JavaScript
        $this->importLesson($module1Id, $courseId, $lessonsPath . 'lesson_1_1.md', 
            'Introduction to JavaScript', 'introduction-to-javascript', 1);
        
        // Lesson 1.2: JavaScript Syntax and Basics
        $this->importLesson($module1Id, $courseId, $lessonsPath . 'lesson_1_2.md', 
            'JavaScript Syntax and Basics', 'javascript-syntax-and-basics', 2);
        
        // Lesson 1.3: Variables and Data Types
        $this->importLesson($module1Id, $courseId, $lessonsPath . 'lesson_1_3.md', 
            'Variables and Data Types', 'variables-and-data-types', 3);

        echo "\n✅ Successfully imported all Module 1 lessons!\n";

        // Get or create Module 2: Operators and Expressions
        $module2 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Operators and Expressions')
            ->get()
            ->getRowArray();

        if (!$module2) {
            $module2Id = $this->insertModule($courseId, 'Operators and Expressions', 
                'Learn about arithmetic, comparison, logical, and assignment operators in JavaScript.', 2);
            echo "Created Module 2 (ID: {$module2Id})\n";
        } else {
            $module2Id = $module2['id'];
            echo "Found Module 2 (ID: {$module2Id})\n";
        }

        // Import all lessons from Module 2: Operators and Expressions
        // Lesson 2.1: Arithmetic Operators
        $this->importLesson($module2Id, $courseId, $lessonsPath . 'lesson_2_1.md', 
            'Arithmetic Operators', 'arithmetic-operators', 1);
        
        // Lesson 2.2: Comparison and Logical Operators
        $this->importLesson($module2Id, $courseId, $lessonsPath . 'lesson_2_2.md', 
            'Comparison and Logical Operators', 'comparison-and-logical-operators', 2);
        
        // Lesson 2.3: Assignment and Other Operators
        $this->importLesson($module2Id, $courseId, $lessonsPath . 'lesson_2_3.md', 
            'Assignment and Other Operators', 'assignment-and-other-operators', 3);

        echo "\n✅ Successfully imported all Module 2 lessons!\n";

        // Get or create Module 3: Control Flow
        $module3 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Control Flow')
            ->get()
            ->getRowArray();

        if (!$module3) {
            $module3Id = $this->insertModule($courseId, 'Control Flow', 
                'Learn about conditional statements, loops, and error handling in JavaScript.', 3);
            echo "Created Module 3 (ID: {$module3Id})\n";
        } else {
            $module3Id = $module3['id'];
            echo "Found Module 3 (ID: {$module3Id})\n";
        }

        // Import all lessons from Module 3: Control Flow
        // Lesson 3.1: Conditional Statements
        $this->importLesson($module3Id, $courseId, $lessonsPath . 'lesson_3_1.md', 
            'Conditional Statements', 'conditional-statements', 1);
        
        // Lesson 3.2: Loops
        $this->importLesson($module3Id, $courseId, $lessonsPath . 'lesson_3_2.md', 
            'Loops', 'loops', 2);
        
        // Lesson 3.3: Error Handling
        $this->importLesson($module3Id, $courseId, $lessonsPath . 'lesson_3_3.md', 
            'Error Handling', 'error-handling', 3);

        echo "\n✅ Successfully imported all Module 3 lessons!\n";

        // Get or create Module 4: Functions
        $module4 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Functions')
            ->get()
            ->getRowArray();

        if (!$module4) {
            $module4Id = $this->insertModule($courseId, 'Functions', 
                'Learn about function declarations, expressions, arrow functions, scope, hoisting, and advanced function concepts.', 4);
            echo "Created Module 4 (ID: {$module4Id})\n";
        } else {
            $module4Id = $module4['id'];
            echo "Found Module 4 (ID: {$module4Id})\n";
        }

        // Import all lessons from Module 4: Functions
        // Lesson 4.1: Function Basics
        $this->importLesson($module4Id, $courseId, $lessonsPath . 'lesson_4_1.md', 
            'Function Basics', 'function-basics', 1);
        
        // Lesson 4.2: Function Scope and Hoisting
        $this->importLesson($module4Id, $courseId, $lessonsPath . 'lesson_4_2.md', 
            'Function Scope and Hoisting', 'function-scope-and-hoisting', 2);
        
        // Lesson 4.3: Advanced Function Concepts
        $this->importLesson($module4Id, $courseId, $lessonsPath . 'lesson_4_3.md', 
            'Advanced Function Concepts', 'advanced-function-concepts', 3);

        echo "\n✅ Successfully imported all Module 4 lessons!\n";

        // Get or create Module 5: Objects and Arrays
        $module5 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Objects and Arrays')
            ->get()
            ->getRowArray();

        if (!$module5) {
            $module5Id = $this->insertModule($courseId, 'Objects and Arrays', 
                'Learn about objects, arrays, object methods, array methods, iteration, and advanced array operations.', 5);
            echo "Created Module 5 (ID: {$module5Id})\n";
        } else {
            $module5Id = $module5['id'];
            echo "Found Module 5 (ID: {$module5Id})\n";
        }

        // Import all lessons from Module 5: Objects and Arrays
        // Lesson 5.1: Objects
        $this->importLesson($module5Id, $courseId, $lessonsPath . 'lesson_5_1.md', 
            'Objects', 'objects', 1);
        
        // Lesson 5.2: Arrays
        $this->importLesson($module5Id, $courseId, $lessonsPath . 'lesson_5_2.md', 
            'Arrays', 'arrays', 2);
        
        // Lesson 5.3: Advanced Array Operations
        $this->importLesson($module5Id, $courseId, $lessonsPath . 'lesson_5_3.md', 
            'Advanced Array Operations', 'advanced-array-operations', 3);

        echo "\n✅ Successfully imported all Module 5 lessons!\n";

        // Get or create Module 6: Object-Oriented Programming
        $module6 = $this->db->table('modules')
            ->where('course_id', $courseId)
            ->where('title', 'Object-Oriented Programming')
            ->get()
            ->getRowArray();

        if (!$module6) {
            $module6Id = $this->insertModule($courseId, 'Object-Oriented Programming', 
                'Learn object-oriented programming concepts in JavaScript including classes, objects, inheritance, prototypes, and encapsulation.', 6);
            echo "Created Module 6 (ID: {$module6Id})\n";
        } else {
            $module6Id = $module6['id'];
            echo "Found Module 6 (ID: {$module6Id})\n";
        }

        // Import all lessons from Module 6: Object-Oriented Programming
        // Lesson 6.1: Object-Oriented Basics
        $this->importLesson($module6Id, $courseId, $lessonsPath . 'lesson_6_1.md', 
            'Object-Oriented Basics', 'object-oriented-basics', 1);
        
        // Lesson 6.2: Classes and Constructors
        $this->importLesson($module6Id, $courseId, $lessonsPath . 'lesson_6_2.md', 
            'Classes and Constructors', 'classes-and-constructors', 2);
        
        // Lesson 6.3: Inheritance and Prototypes
        $this->importLesson($module6Id, $courseId, $lessonsPath . 'lesson_6_3.md', 
            'Inheritance and Prototypes', 'inheritance-and-prototypes', 3);

        echo "\n✅ Successfully imported all Module 6 lessons!\n";

        // Module 7 belongs to Course 2: Intermediate JavaScript
        // Find Intermediate JavaScript subcourse
        $intermediateJavaScript = $this->db->table('courses')
            ->where('slug', 'intermediate-javascript')
            ->get()
            ->getRowArray();

        if (!$intermediateJavaScript) {
            echo "\n⚠️  Intermediate JavaScript subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $intermediateCourseId = $intermediateJavaScript['id'];
        echo "\nFound Intermediate JavaScript subcourse (ID: {$intermediateCourseId})\n";

        // Get or create Module 7: ES6+ Features
        $module7 = $this->db->table('modules')
            ->where('course_id', $intermediateCourseId)
            ->where('title', 'ES6+ Features')
            ->get()
            ->getRowArray();

        if (!$module7) {
            $module7Id = $this->insertModule($intermediateCourseId, 'ES6+ Features', 
                'Learn modern JavaScript features including let, const, block scope, destructuring, template literals, and symbols.', 1);
            echo "Created Module 7 (ID: {$module7Id})\n";
        } else {
            $module7Id = $module7['id'];
            echo "Found Module 7 (ID: {$module7Id})\n";
        }

        // Import all lessons from Module 7: ES6+ Features
        // Lesson 7.1: Let, Const, and Block Scope
        $this->importLesson($module7Id, $intermediateCourseId, $lessonsPath . 'lesson_7_1.md', 
            'Let, Const, and Block Scope', 'let-const-and-block-scope', 1);
        
        // Lesson 7.2: Destructuring
        $this->importLesson($module7Id, $intermediateCourseId, $lessonsPath . 'lesson_7_2.md', 
            'Destructuring', 'destructuring', 2);
        
        // Lesson 7.3: Template Literals and Symbols
        $this->importLesson($module7Id, $intermediateCourseId, $lessonsPath . 'lesson_7_3.md', 
            'Template Literals and Symbols', 'template-literals-and-symbols', 3);

        echo "\n✅ Successfully imported all Module 7 lessons!\n";

        // Get or create Module 8: Advanced Functions
        $module8 = $this->db->table('modules')
            ->where('course_id', $intermediateCourseId)
            ->where('title', 'Advanced Functions')
            ->get()
            ->getRowArray();

        if (!$module8) {
            $module8Id = $this->insertModule($intermediateCourseId, 'Advanced Functions', 
                'Learn advanced function concepts including closures, IIFE, bind, call, apply, and function composition.', 2);
            echo "Created Module 8 (ID: {$module8Id})\n";
        } else {
            $module8Id = $module8['id'];
            echo "Found Module 8 (ID: {$module8Id})\n";
        }

        // Import all lessons from Module 8: Advanced Functions
        // Lesson 8.1: Closures
        $this->importLesson($module8Id, $intermediateCourseId, $lessonsPath . 'lesson_8_1.md', 
            'Closures', 'closures', 1);
        
        // Lesson 8.2: IIFE (Immediately Invoked Function Expressions)
        $this->importLesson($module8Id, $intermediateCourseId, $lessonsPath . 'lesson_8_2.md', 
            'IIFE (Immediately Invoked Function Expressions)', 'iife', 2);
        
        // Lesson 8.3: Bind, Call, and Apply
        $this->importLesson($module8Id, $intermediateCourseId, $lessonsPath . 'lesson_8_3.md', 
            'Bind, Call, and Apply', 'bind-call-and-apply', 3);

        echo "\n✅ Successfully imported all Module 8 lessons!\n";

        // Get or create Module 9: Asynchronous JavaScript
        $module9 = $this->db->table('modules')
            ->where('course_id', $intermediateCourseId)
            ->where('title', 'Asynchronous JavaScript')
            ->get()
            ->getRowArray();

        if (!$module9) {
            $module9Id = $this->insertModule($intermediateCourseId, 'Asynchronous JavaScript', 
                'Learn asynchronous JavaScript concepts including callbacks, promises, async/await, and handling asynchronous operations.', 3);
            echo "Created Module 9 (ID: {$module9Id})\n";
        } else {
            $module9Id = $module9['id'];
            echo "Found Module 9 (ID: {$module9Id})\n";
        }

        // Import all lessons from Module 9: Asynchronous JavaScript
        // Lesson 9.1: Callbacks
        $this->importLesson($module9Id, $intermediateCourseId, $lessonsPath . 'lesson_9_1.md', 
            'Callbacks', 'callbacks', 1);
        
        // Lesson 9.2: Promises
        $this->importLesson($module9Id, $intermediateCourseId, $lessonsPath . 'lesson_9_2.md', 
            'Promises', 'promises', 2);
        
        // Lesson 9.3: Async/Await
        $this->importLesson($module9Id, $intermediateCourseId, $lessonsPath . 'lesson_9_3.md', 
            'Async/Await', 'async-await', 3);

        echo "\n✅ Successfully imported all Module 9 lessons!\n";

        // Get or create Module 10: Iterators and Generators
        $module10 = $this->db->table('modules')
            ->where('course_id', $intermediateCourseId)
            ->where('title', 'Iterators and Generators')
            ->get()
            ->getRowArray();

        if (!$module10) {
            $module10Id = $this->insertModule($intermediateCourseId, 'Iterators and Generators', 
                'Learn about iterators, generators, and how to create custom iterable objects in JavaScript.', 4);
            echo "Created Module 10 (ID: {$module10Id})\n";
        } else {
            $module10Id = $module10['id'];
            echo "Found Module 10 (ID: {$module10Id})\n";
        }

        // Import all lessons from Module 10: Iterators and Generators
        // Lesson 10.1: Iterators
        $this->importLesson($module10Id, $intermediateCourseId, $lessonsPath . 'lesson_10_1.md', 
            'Iterators', 'iterators', 1);
        
        // Lesson 10.2: Generators
        $this->importLesson($module10Id, $intermediateCourseId, $lessonsPath . 'lesson_10_2.md', 
            'Generators', 'generators', 2);

        echo "\n✅ Successfully imported all Module 10 lessons!\n";

        // Get or create Module 11: Modules
        $module11 = $this->db->table('modules')
            ->where('course_id', $intermediateCourseId)
            ->where('title', 'Modules')
            ->get()
            ->getRowArray();

        if (!$module11) {
            $module11Id = $this->insertModule($intermediateCourseId, 'Modules', 
                'Learn about ES6 modules, CommonJS, module systems, and module bundlers in JavaScript.', 5);
            echo "Created Module 11 (ID: {$module11Id})\n";
        } else {
            $module11Id = $module11['id'];
            echo "Found Module 11 (ID: {$module11Id})\n";
        }

        // Import all lessons from Module 11: Modules
        // Lesson 11.1: ES6 Modules
        $this->importLesson($module11Id, $intermediateCourseId, $lessonsPath . 'lesson_11_1.md', 
            'ES6 Modules', 'es6-modules', 1);
        
        // Lesson 11.2: CommonJS and Module Systems
        $this->importLesson($module11Id, $intermediateCourseId, $lessonsPath . 'lesson_11_2.md', 
            'CommonJS and Module Systems', 'commonjs-and-module-systems', 2);

        echo "\n✅ Successfully imported all Module 11 lessons!\n";

        // Get or create Module 12: Working with APIs
        $module12 = $this->db->table('modules')
            ->where('course_id', $intermediateCourseId)
            ->where('title', 'Working with APIs')
            ->get()
            ->getRowArray();

        if (!$module12) {
            $module12Id = $this->insertModule($intermediateCourseId, 'Working with APIs', 
                'Learn how to make HTTP requests using Fetch API, Axios, and handle API responses and errors.', 6);
            echo "Created Module 12 (ID: {$module12Id})\n";
        } else {
            $module12Id = $module12['id'];
            echo "Found Module 12 (ID: {$module12Id})\n";
        }

        // Import all lessons from Module 12: Working with APIs
        // Lesson 12.1: Fetch API
        $this->importLesson($module12Id, $intermediateCourseId, $lessonsPath . 'lesson_12_1.md', 
            'Fetch API', 'fetch-api', 1);
        
        // Lesson 12.2: Axios and HTTP Libraries
        $this->importLesson($module12Id, $intermediateCourseId, $lessonsPath . 'lesson_12_2.md', 
            'Axios and HTTP Libraries', 'axios-and-http-libraries', 2);
        
        // Lesson 12.3: Handling API Responses
        $this->importLesson($module12Id, $intermediateCourseId, $lessonsPath . 'lesson_12_3.md', 
            'Handling API Responses', 'handling-api-responses', 3);

        echo "\n✅ Successfully imported all Module 12 lessons!\n";

        // Module 13 belongs to Course 3: DOM Manipulation and Events
        // Find DOM Manipulation and Events subcourse
        $domCourse = $this->db->table('courses')
            ->where('slug', 'dom-manipulation-events')
            ->get()
            ->getRowArray();

        if (!$domCourse) {
            echo "\n⚠️  DOM Manipulation and Events subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $domCourseId = $domCourse['id'];
        echo "\nFound DOM Manipulation and Events subcourse (ID: {$domCourseId})\n";

        // Get or create Module 13: Document Object Model (DOM)
        $module13 = $this->db->table('modules')
            ->where('course_id', $domCourseId)
            ->where('title', 'Document Object Model (DOM)')
            ->get()
            ->getRowArray();

        if (!$module13) {
            $module13Id = $this->insertModule($domCourseId, 'Document Object Model (DOM)', 
                'Learn about the DOM, DOM structure, accessing elements, manipulating the DOM, and DOM traversal.', 1);
            echo "Created Module 13 (ID: {$module13Id})\n";
        } else {
            $module13Id = $module13['id'];
            echo "Found Module 13 (ID: {$module13Id})\n";
        }

        // Import all lessons from Module 13: Document Object Model (DOM)
        // Lesson 13.1: DOM Basics
        $this->importLesson($module13Id, $domCourseId, $lessonsPath . 'lesson_13_1.md', 
            'DOM Basics', 'dom-basics', 1);
        
        // Lesson 13.2: Manipulating the DOM
        $this->importLesson($module13Id, $domCourseId, $lessonsPath . 'lesson_13_2.md', 
            'Manipulating the DOM', 'manipulating-the-dom', 2);
        
        // Lesson 13.3: DOM Traversal
        $this->importLesson($module13Id, $domCourseId, $lessonsPath . 'lesson_13_3.md', 
            'DOM Traversal', 'dom-traversal', 3);

        echo "\n✅ Successfully imported all Module 13 lessons!\n";

        // Get or create Module 14: Events
        $module14 = $this->db->table('modules')
            ->where('course_id', $domCourseId)
            ->where('title', 'Events')
            ->get()
            ->getRowArray();

        if (!$module14) {
            $module14Id = $this->insertModule($domCourseId, 'Events', 
                'Learn about event handling, event types, event propagation, and advanced event patterns in JavaScript.', 2);
            echo "Created Module 14 (ID: {$module14Id})\n";
        } else {
            $module14Id = $module14['id'];
            echo "Found Module 14 (ID: {$module14Id})\n";
        }

        // Import all lessons from Module 14: Events
        // Lesson 14.1: Event Basics
        $this->importLesson($module14Id, $domCourseId, $lessonsPath . 'lesson_14_1.md', 
            'Event Basics', 'event-basics', 1);
        
        // Lesson 14.2: Event Propagation
        $this->importLesson($module14Id, $domCourseId, $lessonsPath . 'lesson_14_2.md', 
            'Event Propagation', 'event-propagation', 2);
        
        // Lesson 14.3: Advanced Events
        $this->importLesson($module14Id, $domCourseId, $lessonsPath . 'lesson_14_3.md', 
            'Advanced Events', 'advanced-events', 3);

        echo "\n✅ Successfully imported all Module 14 lessons!\n";

        // Get or create Module 15: Forms and Validation
        $module15 = $this->db->table('modules')
            ->where('course_id', $domCourseId)
            ->where('title', 'Forms and Validation')
            ->get()
            ->getRowArray();

        if (!$module15) {
            $module15Id = $this->insertModule($domCourseId, 'Forms and Validation', 
                'Learn how to work with forms, form elements, form validation, and input types in JavaScript.', 3);
            echo "Created Module 15 (ID: {$module15Id})\n";
        } else {
            $module15Id = $module15['id'];
            echo "Found Module 15 (ID: {$module15Id})\n";
        }

        // Import all lessons from Module 15: Forms and Validation
        // Lesson 15.1: Working with Forms
        $this->importLesson($module15Id, $domCourseId, $lessonsPath . 'lesson_15_1.md', 
            'Working with Forms', 'working-with-forms', 1);
        
        // Lesson 15.2: Input Types and Validation
        $this->importLesson($module15Id, $domCourseId, $lessonsPath . 'lesson_15_2.md', 
            'Input Types and Validation', 'input-types-and-validation', 2);

        echo "\n✅ Successfully imported all Module 15 lessons!\n";

        // Modules 16 and 17 belong to Course 4: Browser APIs and Storage
        // Find Browser APIs and Storage subcourse
        $browserAPICourse = $this->db->table('courses')
            ->where('slug', 'browser-apis-storage')
            ->get()
            ->getRowArray();

        if (!$browserAPICourse) {
            echo "\n⚠️  Browser APIs and Storage subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $browserAPICourseId = $browserAPICourse['id'];
        echo "\nFound Browser APIs and Storage subcourse (ID: {$browserAPICourseId})\n";

        // Get or create Module 16: Browser Storage
        $module16 = $this->db->table('modules')
            ->where('course_id', $browserAPICourseId)
            ->where('title', 'Browser Storage')
            ->get()
            ->getRowArray();

        if (!$module16) {
            $module16Id = $this->insertModule($browserAPICourseId, 'Browser Storage', 
                'Learn about browser storage APIs including localStorage, sessionStorage, and IndexedDB.', 1);
            echo "Created Module 16 (ID: {$module16Id})\n";
        } else {
            $module16Id = $module16['id'];
            echo "Found Module 16 (ID: {$module16Id})\n";
        }

        // Import all lessons from Module 16: Browser Storage
        // Lesson 16.1: localStorage and sessionStorage
        $this->importLesson($module16Id, $browserAPICourseId, $lessonsPath . 'lesson_16_1.md', 
            'localStorage and sessionStorage', 'localstorage-and-sessionstorage', 1);
        
        // Lesson 16.2: IndexedDB
        $this->importLesson($module16Id, $browserAPICourseId, $lessonsPath . 'lesson_16_2.md', 
            'IndexedDB', 'indexeddb', 2);

        echo "\n✅ Successfully imported all Module 16 lessons!\n";

        // Get or create Module 17: Browser APIs
        $module17 = $this->db->table('modules')
            ->where('course_id', $browserAPICourseId)
            ->where('title', 'Browser APIs')
            ->get()
            ->getRowArray();

        if (!$module17) {
            $module17Id = $this->insertModule($browserAPICourseId, 'Browser APIs', 
                'Learn about various browser APIs including Geolocation, Canvas, Web Audio, and other browser APIs.', 2);
            echo "Created Module 17 (ID: {$module17Id})\n";
        } else {
            $module17Id = $module17['id'];
            echo "Found Module 17 (ID: {$module17Id})\n";
        }

        // Import all lessons from Module 17: Browser APIs
        // Lesson 17.1: Geolocation API
        $this->importLesson($module17Id, $browserAPICourseId, $lessonsPath . 'lesson_17_1.md', 
            'Geolocation API', 'geolocation-api', 1);
        
        // Lesson 17.2: Canvas API
        $this->importLesson($module17Id, $browserAPICourseId, $lessonsPath . 'lesson_17_2.md', 
            'Canvas API', 'canvas-api', 2);
        
        // Lesson 17.3: Web Audio API
        $this->importLesson($module17Id, $browserAPICourseId, $lessonsPath . 'lesson_17_3.md', 
            'Web Audio API', 'web-audio-api', 3);

        echo "\n✅ Successfully imported all Module 17 lessons!\n";

        // Modules 18 and 19 belong to Course 5: Advanced JavaScript
        // Find Advanced JavaScript subcourse
        $advancedCourse = $this->db->table('courses')
            ->where('slug', 'advanced-javascript')
            ->get()
            ->getRowArray();

        if (!$advancedCourse) {
            echo "\n⚠️  Advanced JavaScript subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $advancedCourseId = $advancedCourse['id'];
        echo "\nFound Advanced JavaScript subcourse (ID: {$advancedCourseId})\n";

        // Get or create Module 18: Functional Programming
        $module18 = $this->db->table('modules')
            ->where('course_id', $advancedCourseId)
            ->where('title', 'Functional Programming')
            ->get()
            ->getRowArray();

        if (!$module18) {
            $module18Id = $this->insertModule($advancedCourseId, 'Functional Programming', 
                'Learn functional programming concepts including pure functions, immutability, higher-order functions, and functional patterns.', 1);
            echo "Created Module 18 (ID: {$module18Id})\n";
        } else {
            $module18Id = $module18['id'];
            echo "Found Module 18 (ID: {$module18Id})\n";
        }

        // Import all lessons from Module 18: Functional Programming
        // Lesson 18.1: Functional Programming Concepts
        $this->importLesson($module18Id, $advancedCourseId, $lessonsPath . 'lesson_18_1.md', 
            'Functional Programming Concepts', 'functional-programming-concepts', 1);
        
        // Lesson 18.2: Array Methods for Functional Programming
        $this->importLesson($module18Id, $advancedCourseId, $lessonsPath . 'lesson_18_2.md', 
            'Array Methods for Functional Programming', 'array-methods-for-functional-programming', 2);
        
        // Lesson 18.3: Advanced Functional Patterns
        $this->importLesson($module18Id, $advancedCourseId, $lessonsPath . 'lesson_18_3.md', 
            'Advanced Functional Patterns', 'advanced-functional-patterns', 3);

        echo "\n✅ Successfully imported all Module 18 lessons!\n";

        // Get or create Module 19: Design Patterns
        $module19 = $this->db->table('modules')
            ->where('course_id', $advancedCourseId)
            ->where('title', 'Design Patterns')
            ->get()
            ->getRowArray();

        if (!$module19) {
            $module19Id = $this->insertModule($advancedCourseId, 'Design Patterns', 
                'Learn common design patterns in JavaScript including creational, structural, and behavioral patterns.', 2);
            echo "Created Module 19 (ID: {$module19Id})\n";
        } else {
            $module19Id = $module19['id'];
            echo "Found Module 19 (ID: {$module19Id})\n";
        }

        // Import all lessons from Module 19: Design Patterns
        // Lesson 19.1: Creational Patterns
        $this->importLesson($module19Id, $advancedCourseId, $lessonsPath . 'lesson_19_1.md', 
            'Creational Patterns', 'creational-patterns', 1);
        
        // Lesson 19.2: Structural Patterns
        $this->importLesson($module19Id, $advancedCourseId, $lessonsPath . 'lesson_19_2.md', 
            'Structural Patterns', 'structural-patterns', 2);
        
        // Lesson 19.3: Behavioral Patterns
        $this->importLesson($module19Id, $advancedCourseId, $lessonsPath . 'lesson_19_3.md', 
            'Behavioral Patterns', 'behavioral-patterns', 3);

        echo "\n✅ Successfully imported all Module 19 lessons!\n";

        // Get or create Module 20: Error Handling and Debugging
        $module20 = $this->db->table('modules')
            ->where('course_id', $advancedCourseId)
            ->where('title', 'Error Handling and Debugging')
            ->get()
            ->getRowArray();

        if (!$module20) {
            $module20Id = $this->insertModule($advancedCourseId, 'Error Handling and Debugging', 
                'Learn advanced error handling techniques and debugging strategies for JavaScript applications.', 3);
            echo "Created Module 20 (ID: {$module20Id})\n";
        } else {
            $module20Id = $module20['id'];
            echo "Found Module 20 (ID: {$module20Id})\n";
        }

        // Import all lessons from Module 20: Error Handling and Debugging
        // Lesson 20.1: Advanced Error Handling
        $this->importLesson($module20Id, $advancedCourseId, $lessonsPath . 'lesson_20_1.md', 
            'Advanced Error Handling', 'advanced-error-handling', 1);
        
        // Lesson 20.2: Debugging Techniques
        $this->importLesson($module20Id, $advancedCourseId, $lessonsPath . 'lesson_20_2.md', 
            'Debugging Techniques', 'debugging-techniques', 2);

        echo "\n✅ Successfully imported all Module 20 lessons!\n";

        // Get or create Module 21: Performance Optimization
        $module21 = $this->db->table('modules')
            ->where('course_id', $advancedCourseId)
            ->where('title', 'Performance Optimization')
            ->get()
            ->getRowArray();

        if (!$module21) {
            $module21Id = $this->insertModule($advancedCourseId, 'Performance Optimization', 
                'Learn techniques for optimizing JavaScript code performance, memory management, and rendering optimization.', 4);
            echo "Created Module 21 (ID: {$module21Id})\n";
        } else {
            $module21Id = $module21['id'];
            echo "Found Module 21 (ID: {$module21Id})\n";
        }

        // Import all lessons from Module 21: Performance Optimization
        // Lesson 21.1: Performance Optimization Basics
        $this->importLesson($module21Id, $advancedCourseId, $lessonsPath . 'lesson_21_1.md', 
            'Performance Optimization Basics', 'performance-optimization-basics', 1);
        
        // Lesson 21.2: Memory Management
        $this->importLesson($module21Id, $advancedCourseId, $lessonsPath . 'lesson_21_2.md', 
            'Memory Management', 'memory-management', 2);

        echo "\n✅ Successfully imported all Module 21 lessons!\n";

        // Modules 22 and 23 belong to Course 6: Testing and Tools
        // Find Testing and Tools subcourse
        $testingCourse = $this->db->table('courses')
            ->where('slug', 'javascript-testing-tools')
            ->get()
            ->getRowArray();

        if (!$testingCourse) {
            echo "\n⚠️  Testing and Tools subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $testingCourseId = $testingCourse['id'];
        echo "\nFound Testing and Tools subcourse (ID: {$testingCourseId})\n";

        // Get or create Module 22: Testing
        $module22 = $this->db->table('modules')
            ->where('course_id', $testingCourseId)
            ->where('title', 'Testing')
            ->get()
            ->getRowArray();

        if (!$module22) {
            $module22Id = $this->insertModule($testingCourseId, 'Testing', 
                'Learn JavaScript testing fundamentals, Jest framework, and testing best practices.', 1);
            echo "Created Module 22 (ID: {$module22Id})\n";
        } else {
            $module22Id = $module22['id'];
            echo "Found Module 22 (ID: {$module22Id})\n";
        }

        // Import all lessons from Module 22: Testing
        // Lesson 22.1: Testing Basics
        $this->importLesson($module22Id, $testingCourseId, $lessonsPath . 'lesson_22_1.md', 
            'Testing Basics', 'testing-basics', 1);
        
        // Lesson 22.2: Jest Framework
        $this->importLesson($module22Id, $testingCourseId, $lessonsPath . 'lesson_22_2.md', 
            'Jest Framework', 'jest-framework', 2);
        
        // Lesson 22.3: Advanced Testing
        $this->importLesson($module22Id, $testingCourseId, $lessonsPath . 'lesson_22_3.md', 
            'Advanced Testing', 'advanced-testing', 3);

        echo "\n✅ Successfully imported all Module 22 lessons!\n";

        // Get or create Module 23: Build Tools and Bundlers
        $module23 = $this->db->table('modules')
            ->where('course_id', $testingCourseId)
            ->where('title', 'Build Tools and Bundlers')
            ->get()
            ->getRowArray();

        if (!$module23) {
            $module23Id = $this->insertModule($testingCourseId, 'Build Tools and Bundlers', 
                'Learn about build tools, bundlers like Webpack, and code quality tools for JavaScript development.', 2);
            echo "Created Module 23 (ID: {$module23Id})\n";
        } else {
            $module23Id = $module23['id'];
            echo "Found Module 23 (ID: {$module23Id})\n";
        }

        // Import all lessons from Module 23: Build Tools and Bundlers
        // Lesson 23.1: Build Tools Overview
        $this->importLesson($module23Id, $testingCourseId, $lessonsPath . 'lesson_23_1.md', 
            'Build Tools Overview', 'build-tools-overview', 1);
        
        // Lesson 23.2: Webpack
        $this->importLesson($module23Id, $testingCourseId, $lessonsPath . 'lesson_23_2.md', 
            'Webpack', 'webpack', 2);
        
        // Lesson 23.3: Code Quality and Linting
        $this->importLesson($module23Id, $testingCourseId, $lessonsPath . 'lesson_23_3.md', 
            'Code Quality and Linting', 'code-quality-and-linting', 3);

        echo "\n✅ Successfully imported all Module 23 lessons!\n";

        // Module 24 belongs to Course 6: Testing and Tools (same subcourse)
        // Get or create Module 24: Code Quality and Linting
        $module24 = $this->db->table('modules')
            ->where('course_id', $testingCourseId)
            ->where('title', 'Code Quality and Linting')
            ->get()
            ->getRowArray();

        if (!$module24) {
            $module24Id = $this->insertModule($testingCourseId, 'Code Quality and Linting', 
                'Learn about code quality tools, ESLint, Prettier, and best practices for maintaining JavaScript code quality.', 3);
            echo "Created Module 24 (ID: {$module24Id})\n";
        } else {
            $module24Id = $module24['id'];
            echo "Found Module 24 (ID: {$module24Id})\n";
        }

        // Import all lessons from Module 24: Code Quality and Linting
        // Lesson 24.1: ESLint
        $this->importLesson($module24Id, $testingCourseId, $lessonsPath . 'lesson_24_1.md', 
            'ESLint', 'eslint', 1);
        
        // Lesson 24.2: Prettier and Code Formatting
        $this->importLesson($module24Id, $testingCourseId, $lessonsPath . 'lesson_24_2.md', 
            'Prettier and Code Formatting', 'prettier-and-code-formatting', 2);

        echo "\n✅ Successfully imported all Module 24 lessons!\n";

        // Module 25 belongs to Course 7: Frontend Frameworks
        // Find Frontend Frameworks subcourse
        $frontendCourse = $this->db->table('courses')
            ->where('slug', 'frontend-frameworks')
            ->get()
            ->getRowArray();

        if (!$frontendCourse) {
            echo "\n⚠️  Frontend Frameworks subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $frontendCourseId = $frontendCourse['id'];
        echo "\nFound Frontend Frameworks subcourse (ID: {$frontendCourseId})\n";

        // Get or create Module 25: React Basics
        $module25 = $this->db->table('modules')
            ->where('course_id', $frontendCourseId)
            ->where('title', 'React Basics')
            ->get()
            ->getRowArray();

        if (!$module25) {
            $module25Id = $this->insertModule($frontendCourseId, 'React Basics', 
                'Learn React fundamentals including components, JSX, props, state, and React hooks.', 1);
            echo "Created Module 25 (ID: {$module25Id})\n";
        } else {
            $module25Id = $module25['id'];
            echo "Found Module 25 (ID: {$module25Id})\n";
        }

        // Import all lessons from Module 25: React Basics
        // Lesson 25.1: React Introduction
        $this->importLesson($module25Id, $frontendCourseId, $lessonsPath . 'lesson_25_1.md', 
            'React Introduction', 'react-introduction', 1);
        
        // Lesson 25.2: Components and JSX
        $this->importLesson($module25Id, $frontendCourseId, $lessonsPath . 'lesson_25_2.md', 
            'Components and JSX', 'components-and-jsx', 2);
        
        // Lesson 25.3: Props and State
        $this->importLesson($module25Id, $frontendCourseId, $lessonsPath . 'lesson_25_3.md', 
            'Props and State', 'props-and-state', 3);

        echo "\n✅ Successfully imported all Module 25 lessons!\n";

        // Get or create Module 26: React Advanced
        $module26 = $this->db->table('modules')
            ->where('course_id', $frontendCourseId)
            ->where('title', 'React Advanced')
            ->get()
            ->getRowArray();

        if (!$module26) {
            $module26Id = $this->insertModule($frontendCourseId, 'React Advanced', 
                'Learn advanced React concepts including hooks, routing, state management, and performance optimization.', 2);
            echo "Created Module 26 (ID: {$module26Id})\n";
        } else {
            $module26Id = $module26['id'];
            echo "Found Module 26 (ID: {$module26Id})\n";
        }

        // Import all lessons from Module 26: React Advanced
        // Lesson 26.1: React Hooks
        $this->importLesson($module26Id, $frontendCourseId, $lessonsPath . 'lesson_26_1.md', 
            'React Hooks', 'react-hooks', 1);
        
        // Lesson 26.2: React Router
        $this->importLesson($module26Id, $frontendCourseId, $lessonsPath . 'lesson_26_2.md', 
            'React Router', 'react-router', 2);
        
        // Lesson 26.3: State Management
        $this->importLesson($module26Id, $frontendCourseId, $lessonsPath . 'lesson_26_3.md', 
            'State Management', 'state-management', 3);

        echo "\n✅ Successfully imported all Module 26 lessons!\n";

        // Get or create Module 27: Vue.js (Alternative Framework)
        $module27 = $this->db->table('modules')
            ->where('course_id', $frontendCourseId)
            ->where('title', 'Vue.js (Alternative Framework)')
            ->get()
            ->getRowArray();

        if (!$module27) {
            $module27Id = $this->insertModule($frontendCourseId, 'Vue.js (Alternative Framework)', 
                'Learn Vue.js as an alternative frontend framework, including Vue components, directives, and Vue ecosystem.', 3);
            echo "Created Module 27 (ID: {$module27Id})\n";
        } else {
            $module27Id = $module27['id'];
            echo "Found Module 27 (ID: {$module27Id})\n";
        }

        // Import all lessons from Module 27: Vue.js (Alternative Framework)
        // Lesson 27.1: Vue.js Introduction
        $this->importLesson($module27Id, $frontendCourseId, $lessonsPath . 'lesson_27_1.md', 
            'Vue.js Introduction', 'vuejs-introduction', 1);
        
        // Lesson 27.2: Vue Components and Directives
        $this->importLesson($module27Id, $frontendCourseId, $lessonsPath . 'lesson_27_2.md', 
            'Vue Components and Directives', 'vue-components-and-directives', 2);
        
        // Lesson 27.3: Vue Router and State Management
        $this->importLesson($module27Id, $frontendCourseId, $lessonsPath . 'lesson_27_3.md', 
            'Vue Router and State Management', 'vue-router-and-state-management', 3);

        echo "\n✅ Successfully imported all Module 27 lessons!\n";

        // Modules 28, 29, and 30 belong to Course 8: Node.js and Backend Development
        // Find Node.js and Backend Development subcourse
        $nodejsCourse = $this->db->table('courses')
            ->where('slug', 'nodejs-backend-development')
            ->get()
            ->getRowArray();

        if (!$nodejsCourse) {
            echo "\n⚠️  Node.js and Backend Development subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $nodejsCourseId = $nodejsCourse['id'];
        echo "\nFound Node.js and Backend Development subcourse (ID: {$nodejsCourseId})\n";

        // Get or create Module 28: Node.js Basics
        $module28 = $this->db->table('modules')
            ->where('course_id', $nodejsCourseId)
            ->where('title', 'Node.js Basics')
            ->get()
            ->getRowArray();

        if (!$module28) {
            $module28Id = $this->insertModule($nodejsCourseId, 'Node.js Basics', 
                'Learn Node.js fundamentals including modules, file system operations, and Node.js runtime environment.', 1);
            echo "Created Module 28 (ID: {$module28Id})\n";
        } else {
            $module28Id = $module28['id'];
            echo "Found Module 28 (ID: {$module28Id})\n";
        }

        // Import all lessons from Module 28: Node.js Basics
        // Lesson 28.1: Node.js Introduction
        $this->importLesson($module28Id, $nodejsCourseId, $lessonsPath . 'lesson_28_1.md', 
            'Node.js Introduction', 'nodejs-introduction', 1);
        
        // Lesson 28.2: Node.js Modules
        $this->importLesson($module28Id, $nodejsCourseId, $lessonsPath . 'lesson_28_2.md', 
            'Node.js Modules', 'nodejs-modules', 2);
        
        // Lesson 28.3: File System Operations
        $this->importLesson($module28Id, $nodejsCourseId, $lessonsPath . 'lesson_28_3.md', 
            'File System Operations', 'file-system-operations', 3);

        echo "\n✅ Successfully imported all Module 28 lessons!\n";

        // Get or create Module 29: Building Web Servers
        $module29 = $this->db->table('modules')
            ->where('course_id', $nodejsCourseId)
            ->where('title', 'Building Web Servers')
            ->get()
            ->getRowArray();

        if (!$module29) {
            $module29Id = $this->insertModule($nodejsCourseId, 'Building Web Servers', 
                'Learn to build web servers using Node.js, Express.js framework, routing, and middleware.', 2);
            echo "Created Module 29 (ID: {$module29Id})\n";
        } else {
            $module29Id = $module29['id'];
            echo "Found Module 29 (ID: {$module29Id})\n";
        }

        // Import all lessons from Module 29: Building Web Servers
        // Lesson 29.1: HTTP Server with Node.js
        $this->importLesson($module29Id, $nodejsCourseId, $lessonsPath . 'lesson_29_1.md', 
            'HTTP Server with Node.js', 'http-server-with-nodejs', 1);
        
        // Lesson 29.2: Express.js Framework
        $this->importLesson($module29Id, $nodejsCourseId, $lessonsPath . 'lesson_29_2.md', 
            'Express.js Framework', 'expressjs-framework', 2);
        
        // Lesson 29.3: RESTful APIs with Express
        $this->importLesson($module29Id, $nodejsCourseId, $lessonsPath . 'lesson_29_3.md', 
            'RESTful APIs with Express', 'restful-apis-with-express', 3);

        echo "\n✅ Successfully imported all Module 29 lessons!\n";

        // Get or create Module 30: Databases and Authentication
        $module30 = $this->db->table('modules')
            ->where('course_id', $nodejsCourseId)
            ->where('title', 'Databases and Authentication')
            ->get()
            ->getRowArray();

        if (!$module30) {
            $module30Id = $this->insertModule($nodejsCourseId, 'Databases and Authentication', 
                'Learn to work with databases (MongoDB, SQL) and implement authentication in Node.js applications.', 3);
            echo "Created Module 30 (ID: {$module30Id})\n";
        } else {
            $module30Id = $module30['id'];
            echo "Found Module 30 (ID: {$module30Id})\n";
        }

        // Import all lessons from Module 30: Databases and Authentication
        // Lesson 30.1: Working with Databases
        $this->importLesson($module30Id, $nodejsCourseId, $lessonsPath . 'lesson_30_1.md', 
            'Working with Databases', 'working-with-databases', 1);
        
        // Lesson 30.2: Authentication and Security
        $this->importLesson($module30Id, $nodejsCourseId, $lessonsPath . 'lesson_30_2.md', 
            'Authentication and Security', 'authentication-and-security', 2);
        
        // Lesson 30.3: API Development
        $this->importLesson($module30Id, $nodejsCourseId, $lessonsPath . 'lesson_30_3.md', 
            'API Development', 'api-development', 3);

        echo "\n✅ Successfully imported all Module 30 lessons!\n";

        // Project 1 belongs to Course 9: Practical Projects
        // Find Practical Projects subcourse
        $practicalProjectsCourse = $this->db->table('courses')
            ->where('slug', 'javascript-practical-projects')
            ->get()
            ->getRowArray();

        if (!$practicalProjectsCourse) {
            echo "\n⚠️  Practical Projects subcourse not found.\n";
            echo "Please run JavaScriptSubcoursesSeeder first to create the subcourses.\n";
            return;
        }

        $practicalProjectsCourseId = $practicalProjectsCourse['id'];
        echo "\nFound Practical Projects subcourse (ID: {$practicalProjectsCourseId})\n";

        // Get or create Project 1 module (or use a generic module name)
        // Based on javascript.md, Project 1 is "Interactive Web Pages"
        $project1Module = $this->db->table('modules')
            ->where('course_id', $practicalProjectsCourseId)
            ->where('title', 'Interactive Web Pages')
            ->get()
            ->getRowArray();

        if (!$project1Module) {
            $project1ModuleId = $this->insertModule($practicalProjectsCourseId, 'Interactive Web Pages', 
                'Build interactive web pages with DOM manipulation, event handling, and local storage.', 1);
            echo "Created Project 1 Module (ID: {$project1ModuleId})\n";
        } else {
            $project1ModuleId = $project1Module['id'];
            echo "Found Project 1 Module (ID: {$project1ModuleId})\n";
        }

        // Import all Project 1 lessons
        // Project 1.1: Todo List Application
        $this->importLesson($project1ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_1_1.md', 
            'Todo List Application', 'todo-list-application', 1);
        
        // Project 1.2: Weather App
        $this->importLesson($project1ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_1_2.md', 
            'Weather App', 'weather-app', 2);
        
        // Project 1.3: Calculator
        $this->importLesson($project1ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_1_3.md', 
            'Calculator', 'calculator', 3);

        echo "\n✅ Successfully imported all Project 1 lessons!\n";

        // Get or create Project 2 module: Frontend Applications
        $project2Module = $this->db->table('modules')
            ->where('course_id', $practicalProjectsCourseId)
            ->where('title', 'Frontend Applications')
            ->get()
            ->getRowArray();

        if (!$project2Module) {
            $project2ModuleId = $this->insertModule($practicalProjectsCourseId, 'Frontend Applications', 
                'Build frontend applications with React, including React components, routing, and state management.', 2);
            echo "Created Project 2 Module (ID: {$project2ModuleId})\n";
        } else {
            $project2ModuleId = $project2Module['id'];
            echo "Found Project 2 Module (ID: {$project2ModuleId})\n";
        }

        // Import all Project 2 lessons
        // Project 2.1: React Todo App
        $this->importLesson($project2ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_2_1.md', 
            'React Todo App', 'react-todo-app', 1);
        
        // Project 2.2: React Blog Application
        $this->importLesson($project2ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_2_2.md', 
            'React Blog Application', 'react-blog-application', 2);
        
        // Project 2.3: E-commerce Frontend
        $this->importLesson($project2ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_2_3.md', 
            'E-commerce Frontend', 'ecommerce-frontend', 3);

        echo "\n✅ Successfully imported all Project 2 lessons!\n";

        // Get or create Project 3 module: Full-Stack Applications
        $project3Module = $this->db->table('modules')
            ->where('course_id', $practicalProjectsCourseId)
            ->where('title', 'Full-Stack Applications')
            ->get()
            ->getRowArray();

        if (!$project3Module) {
            $project3ModuleId = $this->insertModule($practicalProjectsCourseId, 'Full-Stack Applications', 
                'Build full-stack applications with React frontend and Node.js backend, including database integration and authentication.', 3);
            echo "Created Project 3 Module (ID: {$project3ModuleId})\n";
        } else {
            $project3ModuleId = $project3Module['id'];
            echo "Found Project 3 Module (ID: {$project3ModuleId})\n";
        }

        // Import all Project 3 lessons
        // Project 3.1: REST API with Node.js
        $this->importLesson($project3ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_3_1.md', 
            'REST API with Node.js', 'rest-api-with-nodejs', 1);
        
        // Project 3.2: Full-Stack Application
        $this->importLesson($project3ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_3_2.md', 
            'Full-Stack Application', 'full-stack-application', 2);

        echo "\n✅ Successfully imported all Project 3 lessons!\n";

        // Get or create Project 4 module: Advanced Projects
        $project4Module = $this->db->table('modules')
            ->where('course_id', $practicalProjectsCourseId)
            ->where('title', 'Advanced Projects')
            ->get()
            ->getRowArray();

        if (!$project4Module) {
            $project4ModuleId = $this->insertModule($practicalProjectsCourseId, 'Advanced Projects', 
                'Build advanced projects including real-time applications, WebSockets, and complex JavaScript applications.', 4);
            echo "Created Project 4 Module (ID: {$project4ModuleId})\n";
        } else {
            $project4ModuleId = $project4Module['id'];
            echo "Found Project 4 Module (ID: {$project4ModuleId})\n";
        }

        // Import all Project 4 lessons
        // Project 4.1: Real-Time Chat Application
        $this->importLesson($project4ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_4_1.md', 
            'Real-Time Chat Application', 'realtime-chat-application', 1);
        
        // Project 4.2: Social Media Clone
        $this->importLesson($project4ModuleId, $practicalProjectsCourseId, $lessonsPath . 'project_4_2.md', 
            'Social Media Clone', 'social-media-clone', 2);

        echo "\n✅ Successfully imported all Project 4 lessons!\n";

        // Get or create Capstone Projects module
        $capstoneModule = $this->db->table('modules')
            ->where('course_id', $practicalProjectsCourseId)
            ->where('title', 'Capstone Projects')
            ->get()
            ->getRowArray();

        if (!$capstoneModule) {
            $capstoneModuleId = $this->insertModule($practicalProjectsCourseId, 'Capstone Projects', 
                'Complete capstone projects to demonstrate mastery of JavaScript, full-stack development, and modern web application architecture.', 5);
            echo "Created Capstone Projects Module (ID: {$capstoneModuleId})\n";
        } else {
            $capstoneModuleId = $capstoneModule['id'];
            echo "Found Capstone Projects Module (ID: {$capstoneModuleId})\n";
        }

        // Import Capstone Project 1: Full-Stack Web Application
        $this->importLesson($capstoneModuleId, $practicalProjectsCourseId, $lessonsPath . 'capstone_1.md', 
            'Full-Stack Web Application', 'full-stack-web-application', 1);
        
        // Import Capstone Project 2: Single Page Application (SPA)
        $this->importLesson($capstoneModuleId, $practicalProjectsCourseId, $lessonsPath . 'capstone_2.md', 
            'Single Page Application (SPA)', 'single-page-application-spa', 2);
        
        // Import Capstone Project 3: Real-Time Application
        $this->importLesson($capstoneModuleId, $practicalProjectsCourseId, $lessonsPath . 'capstone_3.md', 
            'Real-Time Application', 'realtime-application', 3);

        echo "\n✅ Successfully imported all Capstone Projects (1, 2, and 3)!\n";
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

        // Prepare lesson data - use same structure as PythonLessonsSeeder
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

