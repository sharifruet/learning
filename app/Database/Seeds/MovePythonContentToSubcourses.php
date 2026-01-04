<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MovePythonContentToSubcourses extends Seeder
{
    public function run()
    {
        $parentCourseId = 1; // Python Programming
        
        // Get subcourse IDs by slug
        $subcourses = $this->db->table('courses')
            ->where('parent_course_id', $parentCourseId)
            ->get()
            ->getResultArray();
        
        $subcourseMap = [];
        foreach ($subcourses as $subcourse) {
            $subcourseMap[$subcourse['slug']] = $subcourse['id'];
        }

        // Define module mapping: module_title => [subcourse_slug, new_sort_order]
        // Based on python.md structure
        $moduleMapping = [
            // Course 1: Python Fundamentals
            'Getting Started with Python' => ['python-fundamentals', 1],
            'Operators and Expressions' => ['python-fundamentals', 2],
            'Data Structures - Lists and Tuples' => ['python-fundamentals', 3],
            'Data Structures - Dictionaries and Sets' => ['python-fundamentals', 4],
            'Control Flow' => ['python-fundamentals', 5],
            'Functions' => ['python-fundamentals', 6],
            'String Manipulation' => ['python-fundamentals', 7],
            
            // Course 2: Intermediate Python
            'Object-Oriented Programming' => ['intermediate-python', 1],
            'File Handling' => ['intermediate-python', 2],
            'Error Handling and Debugging' => ['intermediate-python', 3],
            'Modules and Packages' => ['intermediate-python', 4],
            'Advanced Data Structures' => ['intermediate-python', 5],
            
            // Course 3: Advanced Python
            'Decorators' => ['advanced-python', 1],
            'Context Managers and Resource Management' => ['advanced-python', 2],
            'Metaclasses and Descriptors' => ['advanced-python', 3],
            'Concurrency and Parallelism' => ['advanced-python', 4],
            'Testing' => ['advanced-python', 5],
            'Performance Optimization' => ['advanced-python', 6],
            
            // Course 4: Python for Web Development
            'Web Development Basics' => ['python-web-development', 1],
            'Advanced Web Development' => ['python-web-development', 2],
            'Working with APIs' => ['python-web-development', 3],
            
            // Course 5: Python for Data Science
            'NumPy' => ['python-data-science', 1],
            'Pandas' => ['python-data-science', 2],
            'Data Visualization' => ['python-data-science', 3],
            
            // Course 6: Practical Projects
            'Command-Line Tools' => ['python-practical-projects', 1],
            'Web Scraping' => ['python-practical-projects', 2],
            'Database Applications' => ['python-practical-projects', 3],
            'Automation Scripts' => ['python-practical-projects', 4],
            'API Development' => ['python-practical-projects', 5],
            
            // Course 7: Best Practices and Design Patterns
            'Code Quality' => ['python-best-practices', 1],
            'Design Patterns' => ['python-best-practices', 2],
            'Software Architecture' => ['python-best-practices', 3],
            
            // Projects (capstone)
            'Full-Stack Web Application' => ['python-practical-projects', 6],
            'Data Analysis Project' => ['python-practical-projects', 7],
            'API Development Project' => ['python-practical-projects', 8],
        ];

        // Handle legacy "Data Structures" module (might be merged or renamed)
        // We'll skip modules that don't match exactly - they might need manual review
        
        // Get all modules from parent course
        $modules = $this->db->table('modules')
            ->where('course_id', $parentCourseId)
            ->get()
            ->getResultArray();

        $movedCount = 0;
        $skippedCount = 0;
        $skippedModules = [];

        foreach ($modules as $module) {
            $moduleTitle = $module['title'];
            
            if (isset($moduleMapping[$moduleTitle])) {
                [$subcourseSlug, $newSortOrder] = $moduleMapping[$moduleTitle];
                
                if (!isset($subcourseMap[$subcourseSlug])) {
                    echo "Warning: Subcourse '{$subcourseSlug}' not found for module '{$moduleTitle}'\n";
                    $skippedCount++;
                    $skippedModules[] = $moduleTitle;
                    continue;
                }
                
                $targetCourseId = $subcourseMap[$subcourseSlug];
                $moduleId = $module['id'];
                
                // Start transaction for each module move
                $this->db->transStart();
                
                // Update module's course_id and sort_order
                $this->db->table('modules')
                    ->where('id', $moduleId)
                    ->update([
                        'course_id' => $targetCourseId,
                        'sort_order' => $newSortOrder,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                
                // Update all lessons' course_id that belong to this module
                $this->db->table('lessons')
                    ->where('module_id', $moduleId)
                    ->update([
                        'course_id' => $targetCourseId,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                
                // Also update any exercises, assignments, or other content linked to this module/course
                // (Add more updates as needed based on your schema)
                
                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                    echo "Error moving module '{$moduleTitle}' (ID: {$moduleId})\n";
                    $skippedCount++;
                    $skippedModules[] = $moduleTitle;
                } else {
                    $this->db->transComplete();
                    echo "Moved module '{$moduleTitle}' (ID: {$moduleId}) to '{$subcourseSlug}' (Course ID: {$targetCourseId})\n";
                    $movedCount++;
                }
            } else {
                echo "Warning: No mapping found for module '{$moduleTitle}' (ID: {$module['id']})\n";
                $skippedCount++;
                $skippedModules[] = $moduleTitle;
            }
        }

        echo "\n=== Migration Summary ===\n";
        echo "Modules moved: {$movedCount}\n";
        echo "Modules skipped: {$skippedCount}\n";
        
        if (!empty($skippedModules)) {
            echo "\nSkipped modules (need manual review):\n";
            foreach ($skippedModules as $skipped) {
                echo "  - {$skipped}\n";
            }
        }
        
        // Verify: count remaining modules in parent course
        $remainingModules = $this->db->table('modules')
            ->where('course_id', $parentCourseId)
            ->countAllResults();
        
        echo "\nRemaining modules in parent course: {$remainingModules}\n";
    }
}

