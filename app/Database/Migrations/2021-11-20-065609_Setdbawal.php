<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Setdbawal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'oauth_id'         => ['type' => 'varchar', 'constraint' => 255],
            'name'             => ['type' => 'varchar', 'constraint' => 255],
            'email'            => ['type' => 'varchar', 'constraint' => 255],
            'profile'          => ['type' => 'varchar', 'constraint' => 255],
            'status'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'role'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');

        $this->forge->createTable('users', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        }

        $this->forge->dropTable('users', true);
    }
}
