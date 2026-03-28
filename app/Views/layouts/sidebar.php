<nav class="sidebar bg-white" id="sidebarNav" style="width: 280px; height: 100vh; position: fixed; left: 0; top: 0; box-shadow: 2px 0 10px rgba(0,0,0,0.05); overflow-y: auto; z-index: 1000;">
    <div class="d-flex flex-column p-3">
        <div class="mb-4">
            <a href="/" class="d-flex align-items-center text-decoration-none">
                <div class="icon-circle bg-success bg-opacity-10 rounded-3 p-2 me-3">
                    <i class="bi bi-building text-success fs-5"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold text-dark">Yayasan</h6>
                    <small class="text-muted">Al-Istianah</small>
                </div>
            </a>
        </div>

        <hr class="my-2">

        <ul class="nav nav-pills flex-column gap-1 flex-grow-1">
            <?php 
            $currentUri = uri_string();
            $dashboardActive = (strpos($currentUri, 'dashboard') !== false || $currentUri === '');
            ?>
            <li class="nav-item">
                <a href="/dashboard" class="nav-link <?php echo $dashboardActive ? 'active' : 'link-dark'; ?> rounded-3 d-flex align-items-center gap-3 px-3 py-2 fw-500" style="transition: all 0.3s ease;">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php 
            $akun1Active = strpos($currentUri, 'akun1') !== false;
            $akun2Active = strpos($currentUri, 'akun2') !== false;
            $akun3Active = strpos($currentUri, 'akun3') !== false;
            $daftarAkunActive = $akun1Active || $akun2Active || $akun3Active;
            ?>
            <li class="nav-item">
                <a href="#daftarAkunMenu" class="nav-link <?php echo $daftarAkunActive ? 'active' : 'link-dark'; ?> rounded-3 d-flex align-items-center gap-3 px-3 py-2 submenu-toggle" style="transition: all 0.3s ease;" data-bs-toggle="collapse">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Daftar Akun</span>
                    <i class="bi bi-chevron-up ms-auto"></i>
                </a>
                <div class="collapse <?php echo $daftarAkunActive ? 'show' : ''; ?>" id="daftarAkunMenu">
                    <ul class="nav flex-column ms-3 mt-1 gap-1">
                        <li class="nav-item">
                            <a href="/akun1" class="nav-link <?php echo $akun1Active ? 'active' : 'link-dark'; ?> rounded-2 d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Akun 1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/akun2" class="nav-link <?php echo $akun2Active ? 'active' : 'link-dark'; ?> rounded-2 d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Akun 2</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/akun3" class="nav-link <?php echo $akun3Active ? 'active' : 'link-dark'; ?> rounded-2 d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Akun 3</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mt-3">
                <span class="text-muted small fw-bold text-uppercase px-3">Siklus Akuntansi</span>
            </li>

            <?php 
            $transaksiUmum = strpos($currentUri, 'transaksi-umum') !== false;
            $transaksiPenyesuaian = strpos($currentUri, 'transaksi-penyesuaian') !== false;
            $daftarTransaksiActive = $transaksiUmum || $transaksiPenyesuaian
            ?>

            <li class="nav-item">
                <a href="#daftarTransaksiMenu" class="nav-link link-dark rounded-3 d-flex align-items-center <?php echo $daftarTransaksiActive ? 'active' : 'link-dark'; ?> gap-3 px-3 py-2 submenu-toggle" style="transition: all 0.3s ease;" data-bs-toggle="collapse">
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Transaksi</span>
                    <i class="bi bi-chevron-up ms-auto"></i>
                </a>
                <div class="collapse  <?php echo $daftarTransaksiActive ? 'show' : ''; ?>" id="daftarTransaksiMenu">
                    <ul class="nav flex-column ms-3 mt-1 gap-1">
                        <li class="nav-item">
                            <a href="/transaksi-umum" class="nav-link rounded-2 d-flex <?php echo $transaksiUmum ? 'active' : 'link-dark' ?>  align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Transaksi Umum</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link rounded-2 d-flex <?php echo $transaksiPenyesuaian ? 'active' : 'link-dark' ?> align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Transaksi Penyesuaian</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link link-dark rounded-3 d-flex align-items-center gap-3 px-3 py-2" style="transition: all 0.3s ease;">
                    <i class="bi bi-journal-text"></i>
                    <span>Jurnal Umum</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link link-dark rounded-3 d-flex align-items-center gap-3 px-3 py-2" style="transition: all 0.3s ease;">
                    <i class="bi bi-book"></i>
                    <span>Buku Besar</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link link-dark rounded-3 d-flex align-items-center gap-3 px-3 py-2" style="transition: all 0.3s ease;">
                    <i class="bi bi-graph-up"></i>
                    <span>Neraca Saldo</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link link-dark rounded-3 d-flex align-items-center gap-3 px-3 py-2" style="transition: all 0.3s ease;">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Transaksi Penyesuaian</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link link-dark rounded-3 d-flex align-items-center gap-3 px-3 py-2" style="transition: all 0.3s ease;">
                    <i class="bi bi-journal-check"></i>
                    <span>Jurnal Penyesuaian</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link link-dark rounded-3 d-flex align-items-center gap-3 px-3 py-2" style="transition: all 0.3s ease;">
                    <i class="bi bi-graph-down"></i>
                    <span>Neraca Saldo Disesuaikan</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#laporanKeuanganMenu" class="nav-link link-dark rounded-3 d-flex align-items-center gap-3 px-3 py-2 submenu-toggle" style="transition: all 0.3s ease;" data-bs-toggle="collapse">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Laporan Keuangan</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="laporanKeuanganMenu">
                    <ul class="nav flex-column ms-3 mt-1 gap-1">
                        <li class="nav-item">
                            <a href="#" class="nav-link link-dark rounded-2 d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Laporan Posisi Keuangan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link link-dark rounded-2 d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Laporan Penghasilan Komprehensif</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link link-dark rounded-2 d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Laporan Perubahan Aset Neto</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link link-dark rounded-2 d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                <i class="bi bi-record2-fill"></i>
                                <span>Laporan Arus Kas</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


        </ul>

        <hr class="my-2">

        <div class="dropdown">
            <button class="btn btn-light w-100 d-flex align-items-center gap-3 px-3 py-2 rounded-3 text-start" type="button" data-bs-toggle="dropdown" style="transition: all 0.3s ease;">
                <div class="avatar-sm bg-success bg-opacity-10 rounded-3 p-2">
                    <i class="bi bi-person-circle text-success"></i>
                </div>
                <div class="flex-grow-1 min-w-0">
                    <div class="text-dark fw-600 small text-truncate">Bendahara</div>
                    <div class="text-muted small text-truncate">Yayasan</div>
                </div>
                <i class="bi bi-chevron-down text-muted small"></i>
            </button>
            <ul class="dropdown-menu w-100" style="min-width: 200px;">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                        <i class="bi bi-person"></i> Profil
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                        <i class="bi bi-box-arrow-right text-danger"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
            }
        });
    });
</script>