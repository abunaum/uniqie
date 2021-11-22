<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Payment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'apikey'             => ['type' => 'varchar', 'constraint' => 255],
            'apiprivatekey'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'kodemerchant'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'callback'             => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'jenis'             => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('payment', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        }

        $this->forge->dropTable('payment', true);
    }
}
