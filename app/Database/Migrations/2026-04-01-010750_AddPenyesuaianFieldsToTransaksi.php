<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPenyesuaianFieldsToTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaksi', [
            'nilai_perolehan' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
                'comment'    => 'Nilai/Harga awal aset atau beban'
            ],
            'masa_manfaat' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'comment'    => 'Masa manfaat dalam hitungan bulan'
            ],
            'nilai_penyesuaian' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
                'comment'    => 'Hasil perhitungan nilai_perolehan / masa_manfaat'
            ]
        ]);
    }

    public function down()
    {
        // Drop the added columns
        $this->forge->dropColumn('transaksi', ['nilai_perolehan', 'masa_manfaat', 'nilai_penyesuaian']);
    }
}
