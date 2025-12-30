<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExercisesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'lesson_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'starter_code' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'solution_code' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'test_cases' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON encoded test cases',
            ],
            'hints' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('lesson_id');
        $this->forge->addForeignKey('lesson_id', 'lessons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('exercises');
    }

    public function down()
    {
        $this->forge->dropTable('exercises');
    }
}

