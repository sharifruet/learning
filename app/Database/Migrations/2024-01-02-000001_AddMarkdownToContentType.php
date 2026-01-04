<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMarkdownToContentType extends Migration
{
    public function up()
    {
        // Update the content_type enum to include 'markdown'
        $this->db->query("ALTER TABLE lessons MODIFY COLUMN content_type ENUM('text', 'video', 'mixed', 'markdown') DEFAULT 'text'");
    }

    public function down()
    {
        // Revert back to original enum values
        $this->db->query("ALTER TABLE lessons MODIFY COLUMN content_type ENUM('text', 'video', 'mixed') DEFAULT 'text'");
    }
}

