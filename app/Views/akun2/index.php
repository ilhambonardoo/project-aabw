<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Akun 2 (Golongan)
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Master Akun 2 (Golongan)</h3>
    <a href="/akun2/create" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Golongan
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
                    <th class="px-4 py-3" style="width: 15%;">Kode Akun 2</th>
                    <th class="py-3">Nama Golongan (Akun 2)</th>
                    <th class="py-3">Induk Klasifikasi (Akun 1)</th>
                    <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($akun2)) : ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            Belum ada data. Silakan tambah data baru.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($akun2 as $row) : ?>
                        <tr>
                            <td class="px-4 py-3 align-middle fw-bold text-success"><?= esc($row['kode_akun_2']) ?></td>
                            <td class="py-3 align-middle text-dark fw-semibold"><?= esc($row['nama_akun_2']) ?></td>
                            <td class="py-3 align-middle text-muted">
                                <i class="bi bi-diagram-2 me-1"></i> <?= esc($row['nama_akun_1']) ?>
                            </td>
                            <td class="px-4 py-3 text-center align-middle">
                                <a href="/akun2/delete/<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini? Semua data Akun 3 di bawahnya juga akan ikut terhapus!');" title="Hapus">
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