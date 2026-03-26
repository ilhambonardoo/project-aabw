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

        <!-- Right Side - Login Form -->
        <div class="auth-right">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Masuk ke Akun Anda</h2>
                    <p>Silakan login untuk melanjutkan</p>
                </div>

                <!-- Alert Messages -->
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('message')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <?= session('message') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login/process') ?>" method="POST" class="auth-form">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="nama_pengguna" class="form-label">
                            <i class="bi bi-person"></i> Username atau Email
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg <?= isset($errors['nama_pengguna']) ? 'is-invalid' : '' ?>" 
                               id="nama_pengguna" 
                               name="nama_pengguna" 
                               placeholder="Masukkan username atau email Anda"
                               value="<?= old('nama_pengguna') ?>" 
                               required>
                        <?php if (isset($errors['nama_pengguna'])): ?>
                            <div class="invalid-feedback"><?= $errors['nama_pengguna'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <input type="password" 
                               class="form-control form-control-lg <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan password Anda"
                               required>
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-footer">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>
                        <a href="<?= base_url('auth/forgot-password') ?>" class="forgot-link">
                            Lupa Password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                <div class="auth-divider">
                    <span>Belum punya akun?</span>
                </div>

                <a href="<?= base_url('register') ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-person-plus me-2"></i>Buat Akun Baru
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>