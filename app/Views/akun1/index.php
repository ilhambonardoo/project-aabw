<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Akun 1 (Klasifikasi)
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Data Akun 1</h3>
    <a href="/akun1/create" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Klasifikasi
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-success" style="border-bottom: 2px solid #198754;">
                <tr>
                    <th class="px-4 py-3" style="width: 20%;">Kode Akun 1</th>
                    <th class="py-3">Akun 1</th>
                    <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($akun1)) : ?>
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            Belum ada data. Silakan tambah data baru.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($akun1 as $row) : ?>
                        <tr>
                            <td class="px-4 py-3 align-middle fw-bold text-success"><?= esc($row['kode_akun_1']) ?></td>
                            <td class="py-3 align-middle text-dark fw-semibold"><?= esc($row['nama_akun_1']) ?></td>
                            <td class="px-4 py-3 text-center align-middle">
                                <a href="/akun1/edit/<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/akun1/delete/<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini? Semua data Akun 2 dan 3 yang terhubung juga akan ikut terhapus!');" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>