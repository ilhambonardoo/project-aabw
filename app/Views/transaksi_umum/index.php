<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Transaksi Umum
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Data Transaksi Umum</h3>
    <a href="/transaksi-umum/create" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Add New
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="/transaksi-umum" method="GET" class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="tgl_awal" class="col-form-label fw-semibold">Dari Tanggal:</label>
            </div>
            <div class="col-auto">
                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="<?= esc($tgl_awal ?? '') ?>" required>
            </div>
            <div class="col-auto">
                <label for="tgl_akhir" class="col-form-label fw-semibold">Sampai:</label>
            </div>
            <div class="col-auto">
                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" value="<?= esc($tgl_akhir ?? '') ?>" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary shadow-sm"><i class="bi bi-funnel"></i> Filter</button>
                <a href="/transaksi-umum" class="btn btn-secondary shadow-sm"><i class="bi bi-arrow-clockwise"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0" id="tabelTransaksi">
                <thead class="table-success" style="border-bottom: 2px solid #198754;">
                    <tr>
                        <th class="py-3 text-center" style="width: 5%;">No</th>
                        <th class="py-3">Nomor Transaksi</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Deskripsi</th>
                        <th class="py-3 text-center" style="width: 20%;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php $no = 1; foreach ($transaksi as $row) : ?>
                        <tr>
                            <td class="text-center py-3 align-middle"><?= $no++ ?></td>
                            <td class="py-3 align-middle fw-bold text-dark"><?= esc($row['no_transaksi']) ?></td>
                            <td class="py-3 align-middle"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                            <td class="py-3 align-middle"><?= esc($row['deskripsi']) ?></td>
                            <td class="text-center py-3 align-middle">
                                <a href="/transaksi-umum/detail/<?= $row['id'] ?>" class="btn btn-sm btn-info text-white me-1" title="Detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="/transaksi-umum/edit/<?= $row['id'] ?>" class="btn btn-sm btn-warning text-dark me-1" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal(<?= $row['id'] ?>)" title="Delete">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="deleteModalLabel">Hapus Data?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        Apakah anda yakin untuk menghapus data?
      </div>
      <div class="modal-footer border-0 pt-0">
        <form id="formDelete" method="GET" action="">
            <button type="submit" class="btn btn-danger px-4">Yes</button>
        </form>
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function showDeleteModal(id) {
        document.getElementById('formDelete').action = "/transaksi-umum/delete/" + id;
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }

    $(document).ready(function() {
        $('#tabelTransaksi').DataTable({
            "searching": false, 
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10 
        });
    });
</script>
<?= $this->endSection() ?>