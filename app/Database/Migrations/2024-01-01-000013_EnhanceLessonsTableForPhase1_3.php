<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EnhanceLessonsTableForPhase1_3 extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default'    => 'draft',
                'comment'    => 'Lesson status: draft or published',
            ],
            'content_type' => [
                'type'       => 'ENUM',
                'constraint' => ['text', 'video', 'mixed'],
                'default'    => 'text',
                'comment'    => 'Type of lesson content',
            ],
            'featured_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
                'comment'    => 'Featured image URL for the lesson',
            ],
            'estimated_time' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Estimated time to complete in minutes',
            ],
            'objectives' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Learning objectives for this lesson',
            ],
        ];

        $this->forge->addColumn('lessons', $fields);

        // Add index for status
        $this->db->query('ALTER TABLE lessons ADD INDEX idx_status (status)');
        $this->db->query('ALTER TABLE lessons ADD INDEX idx_module_sort (module_id, sort_order)');
    }

    public function down()
    {
        $this->forge->dropColumn('lessons', [
            'status',
            'content_type',
            'featured_image',
            'estimated_time',
            'objectives',
        ]);
    }
}

