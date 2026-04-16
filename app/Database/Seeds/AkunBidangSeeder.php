<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AkunBidangSeeder extends Seeder
{
    public function run()
    {
        // 1. Pastikan ada data Master Akun 1 (Aset)
        $this->db->table('akun_1')->ignore(true)->insert([
            'kode_akun_1' => '1',
            'nama_akun_1' => 'Aset'
        ]);
        $id_aset = $this->db->table('akun_1')->where('kode_akun_1', '1')->get()->getRow()->id;

        // 2. Pastikan ada data Master Akun 2 (Kas & Bank)
        $this->db->table('akun_2')->ignore(true)->insert([
            'id_akun_1'   => $id_aset,
            'kode_akun_2' => '11',
            'nama_akun_2' => 'Kas dan Bank'
        ]);
        $id_kas_bank = $this->db->table('akun_2')->where('kode_akun_2', '11')->get()->getRow()->id;

        // 3. Masukkan data Akun 3 (Detail) yang dibedakan per Bidang
        $data_akun_3 = [
            // --- BIDANG YAYASAN ---
            [
                'id_akun_2'    => $id_kas_bank,
                'kode_akun_3'  => '1101',
                'nama_akun_3'  => 'Kas Utama Yayasan',
                'saldo_normal' => 'Debit',
                'bidang'       => 'Yayasan'
            ],
            [
                'id_akun_2'    => $id_kas_bank,
                'kode_akun_3'  => '1102',
                'nama_akun_3'  => 'Bank BRI Yayasan',
                'saldo_normal' => 'Debit',
                'bidang'       => 'Yayasan'
            ],

            // --- BIDANG PENDIDIKAN ---
            [
                'id_akun_2'    => $id_kas_bank,
                'kode_akun_3'  => '1111',
                'nama_akun_3'  => 'Kas Sekolah (Operasional)',
                'saldo_normal' => 'Debit',
                'bidang'       => 'Pendidikan'
            ],
            [
                'id_akun_2'    => $id_kas_bank,
                'kode_akun_3'  => '1112',
                'nama_akun_3'  => 'Bank BNI Pendidikan (SPP)',
                'saldo_normal' => 'Debit',
                'bidang'       => 'Pendidikan'
            ],

            // --- BIDANG MAJELIS TALIM ---
            [
                'id_akun_2'    => $id_kas_bank,
                'kode_akun_3'  => '1121',
                'nama_akun_3'  => 'Kas Infaq Majelis Talim',
                'saldo_normal' => 'Debit',
                'bidang'       => 'Majelis_Talim'
            ],
        ];

        // Insert Batch ke table akun_3 (Gunakan ignore agar tidak error jika dijalankan ulang)
        foreach ($data_akun_3 as $row) {
            $this->db->table('akun_3')->ignore(true)->insert($row);
        }
    }
}
