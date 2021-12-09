<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Channelpayment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode'             => ['type' => 'varchar', 'constraint' => 255],
            'nama'             => ['type' => 'varchar', 'constraint' => 255],
            'status'           => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('channel', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        }

        $this->forge->dropTable('channel', true);
    }
}
