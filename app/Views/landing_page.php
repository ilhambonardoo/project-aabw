<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayasan Al-Istianah | Sistem Informasi Akuntansi</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('/css/landing-page.css'); ?>">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-lg">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-building text-primary me-2"></i>Al-Istianah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('register') ?>">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-lg">
            <div class="row align-items-center py-5">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold mb-3">Selamat datang di sistem akuntansi - AKN</h1>
                    <p class="lead text-muted mb-4">
                        Design by Tasya Muthmainnah Suhendar
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?= base_url('register') ?>" class="btn btn-primary btn-lg">
                            Mulai Sekarang
                        </a>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-lg">
                            Masuk
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center d-none d-lg-block">
                    <div class="hero-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Description Section -->
    <section class="description-section py-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="bg-light p-5 rounded">
                        <h2 class="fw-bold mb-3">Tentang Sistem AKN</h2>
                        <p class="text-muted mb-3">
                            Sistem Informasi Akuntansi (AKN) adalah solusi manajemen keuangan terpadu yang dirancang khusus untuk membantu organisasi Yayasan Al-Istianah mengelola keuangan dengan lebih efisien dan transparan.
                        </p>
                        <div class="row g-4 mt-4">
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-shield-check text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Keamanan Data</h5>
                                        <p class="small text-muted">Enkripsi tingkat tinggi untuk menjaga privasi data Anda</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-speedometer2 text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Performa Cepat</h5>
                                        <p class="small text-muted">Interface responsif yang bekerja di semua perangkat</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-graph-up text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Laporan Real-time</h5>
                                        <p class="small text-muted">Data keuangan yang akurat dan selalu terkini</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-person-check text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Manajemen Pengguna</h5>
                                        <p class="small text-muted">Kontrol akses yang fleksibel sesuai peran</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>