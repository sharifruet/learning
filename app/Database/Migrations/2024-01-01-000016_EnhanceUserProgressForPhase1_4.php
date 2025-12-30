<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EnhanceUserProgressForPhase1_4 extends Migration
{
    public function up()
    {
        $fields = [
            'last_accessed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Last time user accessed this lesson',
            ],
        ];

        $this->forge->addColumn('user_progress', $fields);
        $this->db->query('ALTER TABLE user_progress ADD INDEX idx_user_last_accessed (user_id, last_accessed_at)');
    }

    public function down()
    {
        $this->forge->dropColumn('user_progress', ['last_accessed_at']);
    }
}

