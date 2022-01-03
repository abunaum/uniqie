<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Smtp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'host'     => ['type' => 'varchar', 'constraint' => 255],
            'port'     => ['type' => 'varchar', 'constraint' => 255],
            'user'     => ['type' => 'varchar', 'constraint' => 255],
            'password' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('smtp', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        }

        $this->forge->dropTable('smtp', true);
    }
}
