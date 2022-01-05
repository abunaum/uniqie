<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Telegram extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'userid'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'teleid'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'code'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['userid']);
        $this->forge->addForeignKey('userid', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('telegram', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('telegram', 'telegram_userid_foreign');
        }

        $this->forge->dropTable('telegram', true);
    }
}
