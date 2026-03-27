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

<div class="card shadow-sm border-0 rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="/akun3/store" method="POST">
            
            <div class="mb-3">
                <label for="id_akun_2" class="form-label fw-semibold">Pilih Induk Golongan (Akun 2)</label>
                <select class="form-select" id="id_akun_2" name="id_akun_2" required>
                    <option value="" selected disabled>-- Pilih Akun 2 --</option>
                    <?php foreach($akun2 as $row): ?>
                        <option value="<?= $row['id'] ?>">
                            <?= $row['nama_akun_1'] ?> &raquo; <?= $row['kode_akun_2'] ?> - <?= $row['nama_akun_2'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode_akun_3" class="form-label fw-semibold">Kode Akun 3</label>
                    <input type="number" class="form-control" id="kode_akun_3" name="kode_akun_3" placeholder="Contoh: 1110" required>
                    <small class="text-muted">Awali dengan kode Akun 2</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="saldo_normal" class="form-label fw-semibold">Saldo Normal</label>
                    <select class="form-select" id="saldo_normal" name="saldo_normal" required>
                        <option value="" selected disabled>-- Pilih Saldo --</option>
                        <option value="Debit">Debit</option>
                        <option value="Kredit">Kredit</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="nama_akun_3" class="form-label fw-semibold">Nama Akun (Detail)</label>
                <input type="text" class="form-control" id="nama_akun_3" name="nama_akun_3" placeholder="Contoh: Kas Yayasan, Pendapatan SPP" required>
            </div>
            
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-save me-1"></i> Simpan Data
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>