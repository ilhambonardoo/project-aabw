<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAkunTable extends Migration
{
    public function up()
    {
        // Create akun_1 table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_akun_1' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'unique'     => true, 
            ],
            'nama_akun_1' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', 
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('akun_1');

        // Create akun_2 table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_akun_1' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, 
            ],
            'kode_akun_2' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'unique'     => true, 
            ],
            'nama_akun_2' => [
                'type'       => 'VARCHAR',
                'constraint' => '100', 
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_akun_1', 'akun_1', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('akun_2');

        // Create akun_3 table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_akun_2' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, 
            ],
            'kode_akun_3' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'nama_akun_3' => [
                'type'       => 'VARCHAR',
                'constraint' => '100', 
            ],
            'saldo_normal' => [
                'type'       => 'ENUM',
                'constraint' => ['Debit', 'Kredit'],
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_akun_2', 'akun_2', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('akun_3');
    }

    public function down()
    {
        $this->forge->dropTable('akun_3');
        $this->forge->dropTable('akun_2');
        $this->forge->dropTable('akun_1');
    }
}
