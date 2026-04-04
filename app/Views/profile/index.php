<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Profil Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pt-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Profil Pengguna</h3>
        <a href="/dashboard" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if (session()->has('message')): ?>
    <?php endif; ?>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-exclamation-circle me-2"></i>Validasi Gagal</strong>
            <ul class="mb-0 mt-2">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="bi bi-person-circle me-2 text-success"></i>Informasi Akun
                        </h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnEditProfile" onclick="toggleEditMode()">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                    </div>

                    <!-- Avatar/Profile Illustration -->
                    <div class="text-center mb-4">
                        <div class="avatar-placeholder bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>

                    <!-- View Mode (Default) -->
                    <div id="viewMode">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Username</label>
                            <p class="form-control-plaintext fw-medium"><?= esc($user['nama_pengguna']) ?></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                            <p class="form-control-plaintext fw-medium"><?= esc($user['nama_lengkap']) ?></p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Email</label>
                            <p class="form-control-plaintext fw-medium"><?= esc($user['email']) ?></p>
                        </div>

                        <hr class="my-3">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted d-flex align-items-center">
                                <i class="bi bi-lock-fill me-2 text-warning"></i> Role
                            </label>
                            <div class="badge bg-success fs-6 py-2 px-3">
                                <?= esc($user['role']) ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted d-flex align-items-center">
                                <i class="bi bi-lock-fill me-2 text-warning"></i> Bidang
                            </label>
                            <div class="badge bg-info fs-6 py-2 px-3">
                                <?= esc($user['bidang'] ?? '-') ?>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold text-muted d-flex align-items-center">
                                <i class="bi bi-lock-fill me-2 text-warning"></i> Divisi
                            </label>
                            <div class="badge bg-secondary fs-6 py-2 px-3">
                                <?= esc($user['nama_divisi'] ?? '-') ?>
                            </div>
                        </div>
                    </div>

                    <div id="editMode" style="display: none;">
                        <form action="/profile/update" method="POST">
                            <?= csrf_field() ?>
                             
                            <div class="mb-3">
                                <label for="nama_pengguna" class="form-label fw-semibold">Username</label>
                                <input type="text" class="form-control <?= session('errors.nama_pengguna') ? 'is-invalid' : '' ?>" id="nama_pengguna" name="nama_pengguna" value="<?= esc(old('nama_pengguna', $user['nama_pengguna'])) ?>" required>
                                <?php if (session('errors.nama_pengguna')): ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.nama_pengguna') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control <?= session('errors.nama_lengkap') ? 'is-invalid' : '' ?>" id="nama_lengkap" name="nama_lengkap" value="<?= esc(old('nama_lengkap', $user['nama_lengkap'])) ?>" required>
                                <?php if (session('errors.nama_lengkap')): ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.nama_lengkap') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= esc(old('email', $user['email'])) ?>" required>
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <hr class="my-3">

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted d-flex align-items-center">
                                    <i class="bi bi-lock-fill me-2 text-warning"></i> Role
                                </label>
                                <div class="badge bg-success fs-6 py-2 px-3">
                                    <?= esc($user['role']) ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted d-flex align-items-center">
                                    <i class="bi bi-lock-fill me-2 text-warning"></i> Bidang
                                </label>
                                <div class="badge bg-info fs-6 py-2 px-3">
                                    <?= esc($user['bidang'] ?? '-') ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted d-flex align-items-center">
                                    <i class="bi bi-lock-fill me-2 text-warning"></i> Divisi
                                </label>
                                <div class="badge bg-secondary fs-6 py-2 px-3">
                                    <?= esc($user['nama_divisi'] ?? '-') ?>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success w-100 fw-semibold shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                            </button>

                            <button type="button" class="btn btn-outline-secondary w-100 fw-semibold mt-2" onclick="toggleEditMode()">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="bi bi-lock me-2 text-success"></i>Ubah Password
                        </h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnEditPassword" onclick="togglePasswordMode()">
                            <i class="bi bi-lock-fill me-1"></i> Ubah
                        </button>
                    </div>

                    <div id="passwordViewMode">
                        <div class="text-center py-4">
                            <i class="bi bi-shield-lock text-success" style="font-size: 2.5rem; display: block; margin-bottom: 1rem;"></i>
                            <p class="text-muted mb-3">Keamanan akun Anda terjamin dengan password yang kuat.</p>
                            <small class="text-muted d-block">Klik tombol "Ubah" di atas untuk mengganti password Anda.</small>
                        </div>
                    </div>

                    <div id="passwordEditMode" style="display: none;">
                        <form action="/profile/update-password" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="password_lama" class="form-label fw-semibold">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?= session('errors.password_lama') ? 'is-invalid' : '' ?>" id="password_lama" name="password_lama" placeholder="Masukkan password lama Anda" required value="<?= old('password_lama') ?>">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_lama">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <?php if (session('errors.password_lama')): ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.password_lama') ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted d-block mt-1">Minimal 6 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_baru" class="form-label fw-semibold">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?= session('errors.password_baru') ? 'is-invalid' : '' ?>" id="password_baru" name="password_baru" placeholder="Masukkan password baru Anda" required value="<?= old('password_baru') ?>">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_baru">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <?php if (session('errors.password_baru')): ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.password_baru') ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted d-block mt-1">Minimal 6 karakter, berbeda dengan password lama</small>
                            </div>

                            <div class="mb-4">
                                <label for="konfirmasi_password" class="form-label fw-semibold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?= session('errors.konfirmasi_password') ? 'is-invalid' : '' ?>" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukkan kembali password baru Anda" required value="<?= old('konfirmasi_password') ?>">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="konfirmasi_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <?php if (session('errors.konfirmasi_password')): ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.konfirmasi_password') ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted d-block mt-1">Pastikan sama dengan Password Baru</small>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success w-100 fw-semibold shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Simpan Password
                            </button>

                            <button type="button" class="btn btn-outline-secondary w-100 fw-semibold mt-2" onclick="togglePasswordMode()">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function toggleEditMode() {
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');
        const btnEditProfile = document.getElementById('btnEditProfile');
        
        if (viewMode.style.display === 'none') {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
            btnEditProfile.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Edit';
            btnEditProfile.classList.remove('btn-danger');
            btnEditProfile.classList.add('btn-outline-primary');
        } else {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            btnEditProfile.innerHTML = '<i class="bi bi-x-circle me-1"></i> Tutup';
            btnEditProfile.classList.add('btn-danger');
            btnEditProfile.classList.remove('btn-outline-primary');
        }
    }

    function togglePasswordMode() {
        const viewMode = document.getElementById('passwordViewMode');
        const editMode = document.getElementById('passwordEditMode');
        const btnEditPassword = document.getElementById('btnEditPassword');
        
        if (viewMode.style.display === 'none') {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
            btnEditPassword.innerHTML = '<i class="bi bi-lock-fill me-1"></i> Ubah';
            btnEditPassword.classList.remove('btn-danger');
            btnEditPassword.classList.add('btn-outline-primary');
        } else {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            btnEditPassword.innerHTML = '<i class="bi bi-x-circle me-1"></i> Tutup';
            btnEditPassword.classList.add('btn-danger');
            btnEditPassword.classList.remove('btn-outline-primary');
        }
    }

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>
<?= $this->endSection() ?>
