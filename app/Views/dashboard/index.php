<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column justify-content-center align-items-center h-100" style="min-height: 60vh;">
    <h1 class="fw-bold text-success mb-2 text-center">Sistem Informasi Akuntansi - AKN</h1>
    <h3 class="text-secondary text-center mb-4">Sekolah Vokasi IPB</h3>
    
    <div class="alert alert-success shadow-sm text-center" style="max-width: 500px;">
        Halo, <strong><?= session()->get('nama_pengguna') ?></strong>!<br> 
        Selamat datang di Sistem Informasi Akuntansi Yayasan Al-Istianah.
    </div>
</div>
<?= $this->endSection() ?>