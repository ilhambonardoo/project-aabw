<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Akun 1
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Edit Akun 1</h3>
    <a href="/akun1" class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="bi bi-exclamation-circle me-2"></i>Validasi Gagal</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="/akun1/update/<?= esc($akun1['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="kode_akun_1" class="form-label fw-semibold">Kode Akun 1</label>
                <input type="number" class="form-control <?= session('errors.kode_akun_1') ? 'is-invalid' : '' ?>" id="kode_akun_1" name="kode_akun_1" placeholder="Contoh: 1" value="<?= old('kode_akun_1', $akun1['kode_akun_1']) ?>" required autofocus>
                <small class="text-muted">Gunakan angka tunggal (1, 2, 3, 4, 5)</small>
                <?php if (session('errors.kode_akun_1')): ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.kode_akun_1') ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <label for="nama_akun_1" class="form-label fw-semibold">Nama Klasifikasi</label>
                <input type="text" class="form-control <?= session('errors.nama_akun_1') ? 'is-invalid' : '' ?>" id="nama_akun_1" name="nama_akun_1" placeholder="Contoh: Aset" value="<?= old('nama_akun_1', $akun1['nama_akun_1']) ?>" required>
                <?php if (session('errors.nama_akun_1')): ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.nama_akun_1') ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success flex-grow-1">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="/akun1" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
