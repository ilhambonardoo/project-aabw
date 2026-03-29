<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Akun 3
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Tambah Akun 3</h3>
    <a href="/akun3" class="btn btn-secondary shadow-sm">
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
        <form action="/akun3/store" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="id_akun_2" class="form-label fw-semibold">Pilih Induk Golongan (Akun 2)</label>
                <select class="form-select <?= session('errors.id_akun_2') ? 'is-invalid' : '' ?>" id="id_akun_2" name="id_akun_2" required>
                    <option value="" selected disabled>-- Pilih Akun 2 --</option>
                    <?php foreach($akun2 as $row): ?>
                        <option value="<?= esc($row['id']) ?>" <?= old('id_akun_2') == $row['id'] ? 'selected' : '' ?>>
                            <?= esc($row['nama_akun_1']) ?> &raquo; <?= esc($row['kode_akun_2']) ?> - <?= esc($row['nama_akun_2']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('errors.id_akun_2')): ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.id_akun_2') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode_akun_3" class="form-label fw-semibold">Kode Akun 3</label>
                    <input type="number" class="form-control <?= session('errors.kode_akun_3') ? 'is-invalid' : '' ?>" id="kode_akun_3" name="kode_akun_3" placeholder="Contoh: 1110" value="<?= old('kode_akun_3') ?>" required>
                    <small class="text-muted">Awali dengan kode Akun 2</small>
                    <?php if (session('errors.kode_akun_3')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.kode_akun_3') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="saldo_normal" class="form-label fw-semibold">Saldo Normal</label>
                    <select class="form-select <?= session('errors.saldo_normal') ? 'is-invalid' : '' ?>" id="saldo_normal" name="saldo_normal" required>
                        <option value="" selected disabled>-- Pilih Saldo --</option>
                        <option value="Debit" <?= old('saldo_normal') === 'Debit' ? 'selected' : '' ?>>Debit</option>
                        <option value="Kredit" <?= old('saldo_normal') === 'Kredit' ? 'selected' : '' ?>>Kredit</option>
                    </select>
                    <?php if (session('errors.saldo_normal')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.saldo_normal') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="nama_akun_3" class="form-label fw-semibold">Nama Akun (Detail)</label>
                <input type="text" class="form-control <?= session('errors.nama_akun_3') ? 'is-invalid' : '' ?>" id="nama_akun_3" name="nama_akun_3" placeholder="Contoh: Kas Yayasan, Pendapatan SPP" value="<?= old('nama_akun_3') ?>" required>
                <?php if (session('errors.nama_akun_3')): ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.nama_akun_3') ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-save me-1"></i> Simpan Data
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>