<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Akun 2
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Tambah Akun 2</h3>
    <a href="/akun2" class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="/akun2/store" method="POST">
            
            <div class="mb-3">
                <label for="id_akun_1" class="form-label fw-semibold">Pilih Induk Klasifikasi (Akun 1)</label>
                <select class="form-select" id="id_akun_1" name="id_akun_1" required>
                    <option value="" selected disabled>-- Pilih Akun 1 --</option>
                    <?php foreach($akun1 as $row): ?>
                        <option value="<?= $row['id'] ?>">
                            <?= $row['kode_akun_1'] ?> - <?= $row['nama_akun_1'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_akun_2" class="form-label fw-semibold">Kode Akun 2</label>
                <input type="number" class="form-control" id="kode_akun_2" name="kode_akun_2" placeholder="Contoh: 11" required>
                <small class="text-muted">Gunakan dua digit berawalan kode Akun 1 (misal: 11, 12, 21, 41)</small>
            </div>
            
            <div class="mb-4">
                <label for="nama_akun_2" class="form-label fw-semibold">Nama Golongan</label>
                <input type="text" class="form-control" id="nama_akun_2" name="nama_akun_2" placeholder="Contoh: Aset Lancar" required>
            </div>
            
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-save me-1"></i> Simpan Data
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>