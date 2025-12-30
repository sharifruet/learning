<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLessonContentTable extends Migration
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
            'content_block_type' => [
                'type'       => 'ENUM',
                'constraint' => ['text', 'code', 'image', 'video', 'exercise'],
                'default'    => 'text',
                'comment'    => 'Type of content block',
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => true,
                'comment' => 'Content of the block (HTML for text, code for code blocks, URL for media)',
            ],
            'code_language' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'comment'    => 'Programming language for code blocks (python, javascript, etc.)',
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'comment'    => 'Order of content blocks within lesson',
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
        $this->forge->addKey(['lesson_id', 'sort_order']);
        $this->forge->addForeignKey('lesson_id', 'lessons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lesson_content');
    }

    public function down()
    {
        $this->forge->dropTable('lesson_content');
    }
}

