<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTabelTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'no_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
            ],
            'jenis_transaksi' => [
                'type'       => 'ENUM',
                'constraint' => ['Umum', 'Penyesuaian'],
                'default'    => 'Umum',
            ],
            'tanggal' => [
                'type' => 'DATE'
            ], 
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'keterangan_jurnal' =>[
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, 
            ],
            'id_akun_3' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, 
            ],
            'debit' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2', 
                'default'    => 0.00,
            ],
            'kredit' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0.00,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'Penerimaan', 
                    'Pengeluaran', 
                    'Investasi Masuk', 
                    'Investasi Keluar', 
                    'Pendanaan Masuk', 
                    'Pendanaan Keluar'
                ],
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id', 'CASCADE', 'CASCADE'); 
        $this->forge->addForeignKey('id_akun_3', 'akun_3', 'id', 'RESTRICT', 'CASCADE'); 
        $this->forge->createTable('detail_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('detail_transaksi');
        $this->forge->dropTable('transaksi');
    }
}
