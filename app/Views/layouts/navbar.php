<nav class="navbar navbar-expand bg-white shadow-sm px-4 py-3 mb-4" style="border-bottom: 1px solid #e0e0e0;">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1 fs-5">Selamat Datang</span>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
                        <i class="bi bi-person"></i> </div>
                    <span class="fw-semibold"><?= session()->get('nama_lengkap'); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="/profile">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

