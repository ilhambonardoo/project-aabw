<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center mb-4">
        <a href="/transaksi-penyesuaian" class="btn btn-secondary btn-sm" style="margin-right: 15px;">
            &larr; Back
        </a>
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/transaksi-penyesuaian/store" method="POST" id="formTransaksi">
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>No. Transaksi</label>
                        <input type="text" class="form-control" name="no_transaksi" value="<?= $no_transaksi ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                    <div class="col-md-4">
                        <label>Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="deskripsi" rows="1" required></textarea>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="m-0 font-weight-bold text-primary">Rincian Penyesuaian</h5>
                    <button type="button" class="btn btn-success btn-sm" id="btnAddBaris">
                        <i class="fas fa-plus"></i> Add baris
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="tabelRincian">
                        <thead class="bg-light">
                            <tr>
                                <th width="25%">Kode Akun</th>
                                <th width="20%">Debit</th>
                                <th width="20%">Kredit</th>
                                <th width="25%">Status</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control select2" name="id_akun_3[]" required>
                                        <option value="">-- Pilih Akun --</option>
                                        <?php foreach($akun3 as $a): ?>
                                            <option value="<?= $a['id'] ?>"><?= $a['kode_akun_3'] ?> - <?= $a['nama_akun_3'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control text-end debit-input format-rupiah" name="debit[]" value="0" required></td>
                                <td><input type="text" class="form-control text-end kredit-input format-rupiah" name="kredit[]" value="0" required></td>
                                <td>
                                    <select class="form-control" name="status[]" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Penerimaan">Penerimaan</option>
                                        <option value="Pengeluaran">Pengeluaran</option>
                                        <option value="Investasi Masuk">Investasi Masuk</option>
                                        <option value="Investasi Keluar">Investasi Keluar</option>
                                        <option value="Pendanaan Masuk">Pendanaan Masuk</option>
                                        <option value="Pendanaan Keluar">Pendanaan Keluar</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <td class="text-end">TOTAL</td>
                                <td class="text-end" id="totalDebit">Rp 0</td>
                                <td class="text-end" id="totalKredit">Rp 0</td>
                                <td colspan="2" class="text-center" id="statusBalance">
                                    <span class="badge badge-danger">Belum Seimbang</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-right mt-3">
                    
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan Transaksi</button>
                </div>

            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.querySelector('#tabelRincian tbody');
        const btnAddBaris = document.getElementById('btnAddBaris');
        const btnSimpan = document.getElementById('btnSimpan');

        const akunOptions = `
            <option value="">-- Pilih Akun --</option>
            <?php foreach($akun3 as $a): ?>
                <option value="<?= $a['id'] ?>"><?= $a['kode_akun_3'] ?> - <?= $a['nama_akun_3'] ?></option>
            <?php endforeach; ?>
        `;

        const statusOptions = `
            <option value="">-- Pilih Status --</option>
            <option value="Penerimaan">Penerimaan</option>
            <option value="Pengeluaran">Pengeluaran</option>
            <option value="Investasi Masuk">Investasi Masuk</option>
            <option value="Investasi Keluar">Investasi Keluar</option>
            <option value="Pendanaan Masuk">Pendanaan Masuk</option>
            <option value="Pendanaan Keluar">Pendanaan Keluar</option>
        `;

        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        function parseRupiah(rupiahString) {
            if (!rupiahString) return 0;
            let cleanString = rupiahString.replace(/\./g, '').replace(/Rp\s?/g, '').replace(/,/g, '.');
            let val = parseFloat(cleanString);
            return isNaN(val) ? 0 : val;
        }

        function hitungTotal() {
            let totalDebit = 0;
            let totalKredit = 0;

            document.querySelectorAll('.debit-input').forEach(input => {
                totalDebit += parseRupiah(input.value);
            });

            document.querySelectorAll('.kredit-input').forEach(input => {
                totalKredit += parseRupiah(input.value);
            });

            document.getElementById('totalDebit').innerText = 'Rp ' + formatRupiah(totalDebit.toString());
            document.getElementById('totalKredit').innerText = 'Rp ' + formatRupiah(totalKredit.toString());

            const statusBalance = document.getElementById('statusBalance');
            if (totalDebit > 0 && totalKredit > 0 && totalDebit === totalKredit) {
                statusBalance.innerHTML = '<span class="badge badge-success px-3 py-2">Seimbang (Balance)</span>';
            } else {
                statusBalance.innerHTML = '<span class="badge badge-danger px-3 py-2">Belum Seimbang</span>';
            }
        }

        function attachEvents(row) {
            const debitInput = row.querySelector('.debit-input');
            const kreditInput = row.querySelector('.kredit-input');
            const btnHapus = row.querySelector('.btn-hapus');

            [debitInput, kreditInput].forEach(input => {
                input.addEventListener('keyup', function(e) {
                    if(this.value === '') this.value = '0';
                    this.value = formatRupiah(this.value);
                    
                    if (parseFloat(parseRupiah(this.value)) > 0) {
                        if (this.classList.contains('debit-input')) {
                            kreditInput.value = '0';
                        } else {
                            debitInput.value = '0';
                        }
                    }
                    hitungTotal();
                });
            });

            btnHapus.addEventListener('click', function() {
                if (tbody.rows.length > 1) {
                    row.remove();
                    hitungTotal();
                } else {
                    alert('Minimal harus ada 1 baris rincian!');
                }
            });
        }

        Array.from(tbody.rows).forEach(row => attachEvents(row));

        btnAddBaris.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><select class="form-control" name="id_akun_3[]" required>${akunOptions}</select></td>
                <td><input type="text" class="form-control text-end debit-input format-rupiah" name="debit[]" value="0" required></td>
                <td><input type="text" class="form-control text-end kredit-input format-rupiah" name="kredit[]" value="0" required></td>
                <td><select class="form-control" name="status[]" required>${statusOptions}</select></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-hapus"><i class="fas fa-trash"></i></button></td>
            `;
            tbody.appendChild(tr);
            attachEvents(tr);
        });

        document.getElementById('formTransaksi').addEventListener('submit', function(e) {
            let totalDebitSubmit = 0;
            let totalKreditSubmit = 0;

            document.querySelectorAll('.debit-input').forEach(input => {
                totalDebitSubmit += parseRupiah(input.value);
            });

            document.querySelectorAll('.kredit-input').forEach(input => {
                totalKreditSubmit += parseRupiah(input.value);
            });
            
            if (totalDebitSubmit === 0 && totalKreditSubmit === 0) {
                e.preventDefault();
                alert('Gagal: Nominal transaksi masih kosong! Silakan isi Debit/Kredit.');
            } 

        });
    });
</script>
<?= $this->endSection() ?>