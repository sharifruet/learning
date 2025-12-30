<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOAuthFieldsToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'provider' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'comment'    => 'OAuth provider: google, facebook, or null for regular users',
            ],
            'provider_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'comment'    => 'User ID from OAuth provider',
            ],
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
                'comment'    => 'User avatar URL from OAuth provider',
            ],
        ];

        $this->forge->addColumn('users', $fields);

        // Add index for faster lookups
        $this->db->query('ALTER TABLE users ADD INDEX idx_provider (provider, provider_id)');
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['provider', 'provider_id', 'avatar']);
    }
}

