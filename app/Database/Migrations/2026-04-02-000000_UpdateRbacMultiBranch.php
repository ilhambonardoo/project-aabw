<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRbacMultiBranch extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'Admin', 
                    'Ketua Yayasan', 
                    'Bendahara Yayasan', 
                    'Kepala Sekolah', 
                    'Bendahara Pendidikan', 
                    'Ketua Majelis Talim', 
                    'Bendahara Majelis Talim'
                ],
                'default'    => 'Admin',
                'after'      => 'password'
            ],
            'bidang' => [
                'type'       => 'ENUM',
                'constraint' => ['Yayasan', 'Pendidikan', 'Majelis_Talim', 'Semua'],
                'default'    => 'Semua',
                'after'      => 'role'
            ],
        ]);

        $this->forge->addColumn('akun_3', [
            'bidang' => [
                'type'       => 'ENUM',
                'constraint' => ['Yayasan', 'Pendidikan', 'Majelis_Talim'],
                'after'      => 'saldo_normal'
            ],
        ]);

        $this->forge->addColumn('transaksi', [
            'bidang' => [
                'type'       => 'ENUM',
                'constraint' => ['Yayasan', 'Pendidikan', 'Majelis_Talim'],
                'after'      => 'jenis_transaksi'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role');
        $this->forge->dropColumn('users', 'bidang');
        $this->forge->dropColumn('akun_3', 'bidang');
        $this->forge->dropColumn('transaksi', 'bidang');
    }
}
