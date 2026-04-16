<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AkunSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Bersihkan data lama agar tidak terjadi duplicate entry
        $db->table('akun_3')->where('id >', 0)->delete();
        $db->table('akun_2')->where('id >', 0)->delete();
        $db->table('akun_1')->where('id >', 0)->delete();

        // Reset auto increment (khusus MySQL/MariaDB)
        $db->query("ALTER TABLE akun_1 AUTO_INCREMENT = 1");
        $db->query("ALTER TABLE akun_2 AUTO_INCREMENT = 1");
        $db->query("ALTER TABLE akun_3 AUTO_INCREMENT = 1");

        // --- AKUN 1 (KLASIFIKASI UTAMA) ---
        $akun1 = [
            ['kode_akun_1' => '1', 'nama_akun_1' => 'Aset'],
            ['kode_akun_1' => '2', 'nama_akun_1' => 'Liabilitas'],
            ['kode_akun_1' => '3', 'nama_akun_1' => 'Ekuitas'],
            ['kode_akun_1' => '4', 'nama_akun_1' => 'Pendapatan'],
            ['kode_akun_1' => '5', 'nama_akun_1' => 'Beban'],
        ];
        $db->table('akun_1')->insertBatch($akun1);

        // Map ID Akun 1 (Mapping by Kode)
        $a1_rows = $db->table('akun_1')->get()->getResultArray();
        $a1 = [];
        foreach ($a1_rows as $row) { $a1[$row['kode_akun_1']] = $row['id']; }

        // --- AKUN 2 (GOLONGAN) ---
        $akun2 = [
            // Aset (1)
            ['id_akun_1' => $a1['1'], 'kode_akun_2' => '11', 'nama_akun_2' => 'Aset Lancar'],
            ['id_akun_1' => $a1['1'], 'kode_akun_2' => '12', 'nama_akun_2' => 'Aset Tetap'],
            // Liabilitas (2)
            ['id_akun_1' => $a1['2'], 'kode_akun_2' => '21', 'nama_akun_2' => 'Utang Jangka Pendek'],
            // Ekuitas (3)
            ['id_akun_1' => $a1['3'], 'kode_akun_2' => '31', 'nama_akun_2' => 'Aset Neto Tanpa Pembatasan'],
            ['id_akun_1' => $a1['3'], 'kode_akun_2' => '32', 'nama_akun_2' => 'Aset Neto Dengan Pembatasan'],
            // Pendapatan (4)
            ['id_akun_1' => $a1['4'], 'kode_akun_2' => '41', 'nama_akun_2' => 'Pendapatan Tanpa Pembatasan'],
            ['id_akun_1' => $a1['4'], 'kode_akun_2' => '42', 'nama_akun_2' => 'Pendapatan Dengan Pembatasan'],
            // Beban (5)
            ['id_akun_1' => $a1['5'], 'kode_akun_2' => '51', 'nama_akun_2' => 'Beban Program'],
            ['id_akun_1' => $a1['5'], 'kode_akun_2' => '52', 'nama_akun_2' => 'Beban Administrasi & Umum'],
            ['id_akun_1' => $a1['5'], 'kode_akun_2' => '53', 'nama_akun_2' => 'Beban Akademik & Pembelajaran'],
        ];
        $db->table('akun_2')->insertBatch($akun2);

        // Map ID Akun 2
        $a2_rows = $db->table('akun_2')->get()->getResultArray();
        $a2 = [];
        foreach ($a2_rows as $row) { $a2[$row['kode_akun_2']] = $row['id']; }

        // --- AKUN 3 (DETAIL) ---
        $akun3 = [
            // --- YAYASAN ---
            ['id_akun_2' => $a2['11'], 'kode_akun_3' => '1101', 'nama_akun_3' => 'Kas Yayasan', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['11'], 'kode_akun_3' => '1102', 'nama_akun_3' => 'Bank Yayasan', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['11'], 'kode_akun_3' => '1103', 'nama_akun_3' => 'Perlengkapan Yayasan', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['12'], 'kode_akun_3' => '1201', 'nama_akun_3' => 'Peralatan Yayasan (Meja, Kursi, Papan Tulis)', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['12'], 'kode_akun_3' => '1202', 'nama_akun_3' => 'Akumulasi Penyusutan Peralatan Yayasan', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],
            
            ['id_akun_2' => $a2['21'], 'kode_akun_3' => '2101', 'nama_akun_3' => 'Utang Usaha Yayasan', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['21'], 'kode_akun_3' => '2102', 'nama_akun_3' => 'Utang Gaji Yayasan', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],

            ['id_akun_2' => $a2['31'], 'kode_akun_3' => '3101', 'nama_akun_3' => 'Aset Neto Tanpa Pembatasan - Yayasan', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['32'], 'kode_akun_3' => '3201', 'nama_akun_3' => 'Aset Neto Dengan Pembatasan - Yayasan', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],

            ['id_akun_2' => $a2['41'], 'kode_akun_3' => '4101', 'nama_akun_3' => 'Pendapatan SPP TK (Tanpa Pembatasan)', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['41'], 'kode_akun_3' => '4102', 'nama_akun_3' => 'Pendapatan SPP Madrasah Diniyah (Tanpa Pembatasan)', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['41'], 'kode_akun_3' => '4103', 'nama_akun_3' => 'Infaq (Tanpa Pembatasan)', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['42'], 'kode_akun_3' => '4201', 'nama_akun_3' => 'Pendapatan Dengan Pembatasan (Khusus)', 'saldo_normal' => 'Kredit', 'bidang' => 'Yayasan'],

            ['id_akun_2' => $a2['51'], 'kode_akun_3' => '5101', 'nama_akun_3' => 'Beban Penyusutan Peralatan Yayasan', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['52'], 'kode_akun_3' => '5201', 'nama_akun_3' => 'Beban Gaji Yayasan', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['52'], 'kode_akun_3' => '5202', 'nama_akun_3' => 'Beban Gaji OB', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['52'], 'kode_akun_3' => '5203', 'nama_akun_3' => 'Beban Listrik dan Internet', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['52'], 'kode_akun_3' => '5204', 'nama_akun_3' => 'Beban Alat Kebersihan & Sampah', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['52'], 'kode_akun_3' => '5205', 'nama_akun_3' => 'Beban Perlengkapan (Bendera, dll)', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],
            ['id_akun_2' => $a2['52'], 'kode_akun_3' => '5206', 'nama_akun_3' => 'Beban Konsumsi (Galon, dll)', 'saldo_normal' => 'Debit', 'bidang' => 'Yayasan'],

            // --- PENDIDIKAN ---
            ['id_akun_2' => $a2['11'], 'kode_akun_3' => '1104', 'nama_akun_3' => 'Kas Pendidikan', 'saldo_normal' => 'Debit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['11'], 'kode_akun_3' => '1105', 'nama_akun_3' => 'Bank Pendidikan', 'saldo_normal' => 'Debit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['11'], 'kode_akun_3' => '1106', 'nama_akun_3' => 'Perlengkapan ATK Pendidikan', 'saldo_normal' => 'Debit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['12'], 'kode_akun_3' => '1203', 'nama_akun_3' => 'Inventaris Peralatan Kantor (Pendidikan)', 'saldo_normal' => 'Debit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['12'], 'kode_akun_3' => '1204', 'nama_akun_3' => 'Akumulasi Penyusutan Peralatan Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],

            ['id_akun_2' => $a2['21'], 'kode_akun_3' => '2103', 'nama_akun_3' => 'Utang Usaha Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['21'], 'kode_akun_3' => '2104', 'nama_akun_3' => 'Utang Gaji Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],

            ['id_akun_2' => $a2['31'], 'kode_akun_3' => '3102', 'nama_akun_3' => 'Aset Neto Tanpa Pembatasan - Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['32'], 'kode_akun_3' => '3202', 'nama_akun_3' => 'Aset Neto Dengan Pembatasan - Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],

            ['id_akun_2' => $a2['41'], 'kode_akun_3' => '4104', 'nama_akun_3' => 'Pendapatan SPP TK Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['41'], 'kode_akun_3' => '4105', 'nama_akun_3' => 'Pendapatan SPP Madrasah Diniyah Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],
            ['id_akun_2' => $a2['41'], 'kode_akun_3' => '4106', 'nama_akun_3' => 'Pendapatan BOP Pendidikan', 'saldo_normal' => 'Kredit', 'bidang' => 'Pendidikan'],

            ['id_akun_2' => $a2['53'], 'kode_akun_3' => '5301', 'nama_akun_3' => 'Beban Akademik & Pembelajaran (Rapot, Majalah, Alat Peraga)', 'saldo_normal' => 'Debit', 'bidang' => 'Pendidikan'],
        ];
        $db->table('akun_3')->insertBatch($akun3);
    }
}
