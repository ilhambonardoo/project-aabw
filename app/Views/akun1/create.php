<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Akun 1
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Tambah Akun 1</h3>
    <a href="/akun1" class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="/akun1/store" method="POST">
            <div class="mb-3">
                <label for="kode_akun_1" class="form-label fw-semibold">Kode Akun 1</label>
                <input type="number" class="form-control" id="kode_akun_1" name="kode_akun_1" placeholder="Contoh: 1" required autofocus>
                <small class="text-muted">Gunakan angka tunggal (1, 2, 3, 4, 5)</small>
            </div>
            
            <div class="mb-4">
                <label for="nama_akun_1" class="form-label fw-semibold">Nama Klasifikasi</label>
                <input type="text" class="form-control" id="nama_akun_1" name="nama_akun_1" placeholder="Contoh: Aset" required>
            </div>
            
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-save me-1"></i> Simpan Data
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>