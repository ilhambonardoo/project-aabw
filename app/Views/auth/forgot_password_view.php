<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Lupa Kata Sandi<?= $this->endSection() ?>

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
                <p>Sistem Akuntansi Terintegrasi</p>
            </div>
            
            <div class="brand-features">
                <div class="feature-item">
                    <i class="bi bi-shield-check"></i>
                    <span>Keamanan Terjamin</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-lightning-charge"></i>
                    <span>Proses Cepat & Aman</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-headset"></i>
                    <span>Dukungan 24/7</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-right">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Lupa Kata Sandi?</h2>
                    <p>Masukkan email Anda untuk menerima link pemulihan</p>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?= session('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('errors')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php foreach (session('errors') as $error) : ?>
                            <div><?= $error ?></div>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('auth/send-reset-link') ?>" class="auth-form" novalidate>
                    <?= csrf_field() ?>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input 
                            type="email" 
                            class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                            name="email" 
                            placeholder="Masukkan email Anda"
                            value="<?= old('email') ?>"
                            required
                        >
                        <?php if (session('errors.email')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        <i class="bi bi-send me-2"></i> Kirim Link Pemulihan
                    </button>
                </form>

                <div class="auth-divider">
                    <span>atau</span>
                </div>

                <!-- Links -->
                <div style="text-align: center;">
                    <p style="margin-bottom: 15px; color: #6c757d; font-size: 14px;">
                        Ingat kata sandinya?
                        <a href="<?= base_url('login') ?>" class="forgot-link" style="display: inline;">
                            Kembali ke Login
                        </a>
                    </p>

                    <p style="margin-bottom: 0; color: #6c757d; font-size: 14px;">
                        Belum punya akun?
                        <a href="<?= base_url('register') ?>" class="forgot-link" style="display: inline;">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Form validation feedback
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
<?= $this->endSection() ?>
