<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <a href="/transaksi-penyesuaian/create" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/transaksi-penyesuaian" method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <label for="tgl_awal">Tanggal Awal</label>
                    <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" value="<?= $tgl_awal ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="tgl_akhir">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" value="<?= $tgl_akhir ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="/transaksi-penyesuaian" class="btn btn-secondary"><i class="fas fa-sync"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabelPenyesuaian" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Nilai</th>
                            <th>Waktu</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $db = \Config\Database::connect();
                        $no = 1; 
                        foreach($transaksi as $t): 
                            $total = $db->table('detail_transaksi')
                                        ->selectSum('debit')
                                        ->where('id_transaksi', $t['id'])
                                        ->get()->getRow()->debit;
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
                            <td><?= esc($t['deskripsi']) ?></td>
                            <td>Rp <?= number_format($total ?? 0, 0, ',', '.') ?></td>
                            <td><?= date('H:i:s', strtotime($t['created_at'])) ?></td>
                            <td class="text-center">
                                <a href="/transaksi-penyesuaian/detail/<?= $t['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                                <a href="/transaksi-penyesuaian/edit/<?= $t['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="<?= $t['id'] ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#tabelPenyesuaian').DataTable({
            "searching": false,
            "language": {
                "emptyTable": "Tidak ada data transaksi penyesuaian pada tanggal tersebut",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Data?',
                text: "Apakah anda yakin untuk menghapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/transaksi-penyesuaian/delete/" + id;
                }
            })
        });
    });
</script>
<?= $this->endSection() ?>