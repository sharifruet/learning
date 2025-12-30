<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EnhanceCoursesTableForPhase1_2 extends Migration
{
    public function up()
    {
        $fields = [
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Course category',
            ],
            'instructor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Course instructor/creator',
            ],
            'enrollment_type' => [
                'type'       => 'ENUM',
                'constraint' => ['open', 'approval_required', 'closed'],
                'default'    => 'open',
                'comment'    => 'Enrollment type: open (default), approval_required, closed',
            ],
            'is_free' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => 'Is course free (1) or paid (0)',
            ],
            'is_self_paced' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => 'Is course self-paced (1) or scheduled (0)',
            ],
            'capacity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Course capacity (null = unlimited)',
            ],
            'syllabus' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Course syllabus/outline',
            ],
            'tags' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
                'comment'    => 'Comma-separated course tags',
            ],
        ];

        $this->forge->addColumn('courses', $fields);

        // Add foreign keys
        $this->forge->addForeignKey('category_id', 'course_categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('instructor_id', 'users', 'id', 'SET NULL', 'CASCADE');

        // Add indexes
        $this->db->query('ALTER TABLE courses ADD INDEX idx_category_id (category_id)');
        $this->db->query('ALTER TABLE courses ADD INDEX idx_instructor_id (instructor_id)');
        $this->db->query('ALTER TABLE courses ADD INDEX idx_enrollment_type (enrollment_type)');
        $this->db->query('ALTER TABLE courses ADD INDEX idx_status (status)');
    }

    public function down()
    {
        // Drop foreign keys first
        $this->db->query('ALTER TABLE courses DROP FOREIGN KEY courses_category_id_foreign');
        $this->db->query('ALTER TABLE courses DROP FOREIGN KEY courses_instructor_id_foreign');

        $this->forge->dropColumn('courses', [
            'category_id',
            'instructor_id',
            'enrollment_type',
            'is_free',
            'is_self_paced',
            'capacity',
            'syllabus',
            'tags',
        ]);
    }
}

