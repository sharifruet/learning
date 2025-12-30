<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailVerificationAndPasswordResetToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'email_verification_token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'comment'    => 'Token for email verification',
            ],
            'email_verification_token_expires' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Expiration time for email verification token',
            ],
            'password_reset_token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'comment'    => 'Token for password reset',
            ],
            'password_reset_token_expires' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Expiration time for password reset token',
            ],
        ];

        $this->forge->addColumn('users', $fields);

        // Add indexes for faster lookups
        $this->db->query('ALTER TABLE users ADD INDEX idx_email_verification_token (email_verification_token)');
        $this->db->query('ALTER TABLE users ADD INDEX idx_password_reset_token (password_reset_token)');
    }

    public function down()
    {
        $this->forge->dropColumn('users', [
            'email_verification_token',
            'email_verification_token_expires',
            'password_reset_token',
            'password_reset_token_expires',
        ]);
    }
}

