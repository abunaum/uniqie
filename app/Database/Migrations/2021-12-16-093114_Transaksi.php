<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        $produk = [
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'produk'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'nama'           => ['type' => 'varchar', 'constraint' => 255],
            'email'          => ['type' => 'varchar', 'constraint' => 255],
            'reference'      => ['type' => 'varchar', 'constraint' => 255],
            'merchant_ref'   => ['type' => 'varchar', 'constraint' => 255],
            'channel'        => ['type' => 'varchar', 'constraint' => 255],
            'info'           => ['type' => 'varchar', 'constraint' => 255],
            'status'         => ['type' => 'varchar', 'constraint' => 255],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($produk);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['user', 'produk']);
        $this->forge->addForeignKey('user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk', 'produk', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaksi', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('transaksi', 'transaksi_user_foreign');
            $this->forge->dropForeignKey('transaksi', 'transaksi_produk_foreign');
        }

        $this->forge->dropTable('transaksi', true);
    }
}
