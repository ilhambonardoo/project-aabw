<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Akun 2
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Edit Akun 2</h3>
    <a href="/akun2" class="btn btn-secondary shadow-sm">
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
        <form action="/akun2/update/<?= esc($akun2['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="id_akun_1" class="form-label fw-semibold">Pilih Induk Klasifikasi (Akun 1)</label>
                <select class="form-select <?= session('errors.id_akun_1') ? 'is-invalid' : '' ?>" id="id_akun_1" name="id_akun_1" required>
                    <option value="" disabled>-- Pilih Akun 1 --</option>
                    <?php foreach($akun1 as $row): ?>
                        <option value="<?= esc($row['id']) ?>" <?= old('id_akun_1', $akun2['id_akun_1']) == $row['id'] ? 'selected' : '' ?>>
                            <?= esc($row['kode_akun_1']) ?> - <?= esc($row['nama_akun_1']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Jika anda mengubah Induk Klasifikasi, Kode Akun 2 akan otomatis dihasilkan ulang.</small>
                <?php if (session('errors.id_akun_1')): ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.id_akun_1') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="nama_akun_2" class="form-label fw-semibold">Nama Golongan</label>
                <input type="text" class="form-control <?= session('errors.nama_akun_2') ? 'is-invalid' : '' ?>" id="nama_akun_2" name="nama_akun_2" placeholder="Contoh: Aset Lancar" value="<?= old('nama_akun_2', $akun2['nama_akun_2']) ?>" required>
                <?php if (session('errors.nama_akun_2')): ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.nama_akun_2') ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success flex-grow-1">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="/akun2" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
