<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="auth-container">
    <div class="auth-wrapper">
        <!-- Left Side - Branding -->
        <div class="auth-left">
            <div class="brand-section">
                <div class="brand-icon">
                    <i class="bi bi-building"></i>
                </div>
                <h1>Yayasan Al-Istianah</h1>
                <p>Sistem Informasi Akuntansi</p>
            </div>
            <div class="brand-features">
                <div class="feature-item">
                    <i class="bi bi-shield-check"></i>
                    <span>Keamanan Terjamin</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-speedometer2"></i>
                    <span>Akses Cepat</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-graph-up"></i>
                    <span>Laporan Real-time</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="auth-right">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Buat Akun Baru</h2>
                    <p>Lengkapi form di bawah untuk membuat akun</p>
                </div>

                <!-- Alert Messages -->
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('register/process') ?>" method="POST" class="auth-form">
                    <?= csrf_field() ?>

                    <!-- Row 1: Nama Pengguna (Username) -->
                    <div class="form-group">
                        <label for="nama_pengguna" class="form-label">
                            <i class="bi bi-person"></i> Username
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg <?= isset($errors['nama_pengguna']) ? 'is-invalid' : '' ?>" 
                               id="nama_pengguna" 
                               name="nama_pengguna" 
                               placeholder="Pilih username unik"
                               value="<?= old('nama_pengguna') ?>" 
                               required>
                        <?php if (isset($errors['nama_pengguna'])): ?>
                            <div class="invalid-feedback"><?= $errors['nama_pengguna'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Row 2: Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama_lengkap" class="form-label">
                            <i class="bi bi-person-badge"></i> Nama Lengkap
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg <?= isset($errors['nama_lengkap']) ? 'is-invalid' : '' ?>" 
                               id="nama_lengkap" 
                               name="nama_lengkap" 
                               placeholder="Contoh: Budi Santoso"
                               value="<?= old('nama_lengkap') ?>" 
                               required>
                        <?php if (isset($errors['nama_lengkap'])): ?>
                            <div class="invalid-feedback"><?= $errors['nama_lengkap'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Row 3: Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input type="email" 
                               class="form-control form-control-lg <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                               id="email" 
                               name="email" 
                               placeholder="contoh@email.com"
                               value="<?= old('email') ?>" 
                               required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Row 4: Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <input type="password" 
                               class="form-control form-control-lg <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="Minimal 6 karakter"
                               required>
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Row 5: Konfirmasi Password -->
                    <div class="form-group">
                        <label for="password_confirm" class="form-label">
                            <i class="bi bi-lock-check"></i> Konfirmasi Password
                        </label>
                        <input type="password" 
                               class="form-control form-control-lg <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                               id="password_confirm" 
                               name="password_confirm" 
                               placeholder="Ulangi password"
                               required>
                        <?php if (isset($errors['password_confirm'])): ?>
                            <div class="invalid-feedback"><?= $errors['password_confirm'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Row 6: Nama Divisi -->
                    <div class="form-group">
                        <label for="nama_divisi" class="form-label">
                            <i class="bi bi-diagram-3"></i> Divisi
                        </label>
                        <select class="form-control form-control-lg <?= isset($errors['nama_divisi']) ? 'is-invalid' : '' ?>" 
                                id="nama_divisi" 
                                name="nama_divisi" 
                                required>
                            <option value="">-- Pilih Divisi --</option>
                            <option value="Akuntansi" <?= old('nama_divisi') === 'Akuntansi' ? 'selected' : '' ?>>Divisi Akuntansi</option>
                            <option value="Keuangan" <?= old('nama_divisi') === 'Keuangan' ? 'selected' : '' ?>>Divisi Keuangan</option>
                            <option value="Audit" <?= old('nama_divisi') === 'Audit' ? 'selected' : '' ?>>Divisi Audit</option>
                            <option value="Administrasi" <?= old('nama_divisi') === 'Administrasi' ? 'selected' : '' ?>>Divisi Administrasi</option>
                        </select>
                        <?php if (isset($errors['nama_divisi'])): ?>
                            <div class="invalid-feedback d-block"><?= $errors['nama_divisi'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-footer mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                            <label class="form-check-label" for="agree">
                                Saya setuju dengan syarat dan ketentuan
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 btn-login mt-3">
                        <i class="bi bi-person-plus me-2"></i>Buat Akun
                    </button>
                </form>

                <div class="auth-divider">
                    <span>Sudah punya akun?</span>
                </div>

                <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>