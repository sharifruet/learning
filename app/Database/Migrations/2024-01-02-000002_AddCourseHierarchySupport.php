<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCourseHierarchySupport extends Migration
{
    public function up()
    {
        // Add parent_course_id field to courses table
        $fields = [
            'parent_course_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Parent course ID for subcourse relationships (NULL for standalone or parent courses)',
                'after'      => 'id',
            ],
        ];

        $this->forge->addColumn('courses', $fields);

        // Add index for parent_course_id for better query performance
        $this->db->query('ALTER TABLE courses ADD INDEX idx_parent_course_id (parent_course_id)');

        // Add foreign key constraint for self-referencing relationship
        // Note: Using raw SQL because CodeIgniter's Forge may have issues with self-referencing FKs
        $this->db->query('ALTER TABLE courses ADD CONSTRAINT courses_parent_course_id_foreign 
                         FOREIGN KEY (parent_course_id) REFERENCES courses(id) 
                         ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraint first
        $this->db->query('ALTER TABLE courses DROP FOREIGN KEY courses_parent_course_id_foreign');

        // Drop index
        $this->db->query('ALTER TABLE courses DROP INDEX idx_parent_course_id');

        // Drop the column
        $this->forge->dropColumn('courses', 'parent_course_id');
    }
}

