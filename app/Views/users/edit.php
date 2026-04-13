<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pt-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Edit User</h3>
        <a href="/users" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Validation Errors -->
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

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-3" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="/users/update/<?= $user['id'] ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Username -->
                <div class="mb-3">
                    <label for="nama_pengguna" class="form-label fw-semibold">Username</label>
                    <input type="text" class="form-control <?= session('errors.nama_pengguna') ? 'is-invalid' : '' ?>" id="nama_pengguna" name="nama_pengguna" placeholder="Contoh: antariksa" value="<?= esc(old('nama_pengguna', $user['nama_pengguna'])) ?>" required>
                    <?php if (session('errors.nama_pengguna')): ?>
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.nama_pengguna') ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Minimal 3 karakter, maksimal 50 karakter</small>
                </div>

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" class="form-control <?= session('errors.nama_lengkap') ? 'is-invalid' : '' ?>" id="nama_lengkap" name="nama_lengkap" placeholder="Contoh: Antariksa Mail" value="<?= esc(old('nama_lengkap', $user['nama_lengkap'])) ?>" required>
                    <?php if (session('errors.nama_lengkap')): ?>
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.nama_lengkap') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="Contoh: antariksa@example.com" value="<?= esc(old('email', $user['email'])) ?>" required>
                    <?php if (session('errors.email')): ?>
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.email') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password <span class="text-muted">(Kosongkan jika tidak ingin diubah)</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Masukkan password baru (opsional)" value="<?= old('password') ?>">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <?php if (session('errors.password')): ?>
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.password') ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Jika diisi, minimal 6 karakter</small>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Role</label>
                    <select class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>" id="role" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin" <?= (old('role', $user['role']) === 'Admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="Ketua Yayasan" <?= (old('role', $user['role']) === 'Ketua Yayasan') ? 'selected' : '' ?>>Ketua Yayasan</option>
                        <option value="Bendahara Yayasan" <?= (old('role', $user['role']) === 'Bendahara Yayasan') ? 'selected' : '' ?>>Bendahara Yayasan</option>
                        <option value="Kepala Sekolah" <?= (old('role', $user['role']) === 'Kepala Sekolah') ? 'selected' : '' ?>>Kepala Sekolah</option>
                        <option value="Bendahara Pendidikan" <?= (old('role', $user['role']) === 'Bendahara Pendidikan') ? 'selected' : '' ?>>Bendahara Pendidikan</option>
                        <option value="Ketua Majelis Talim" <?= (old('role', $user['role']) === 'Ketua Majelis Talim') ? 'selected' : '' ?>>Ketua Majelis Talim</option>
                        <option value="Bendahara Majelis Talim" <?= (old('role', $user['role']) === 'Bendahara Majelis Talim') ? 'selected' : '' ?>>Bendahara Majelis Talim</option>
                    </select>
                    <?php if (session('errors.role')): ?>
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.role') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Bidang -->
                <div class="mb-4">
                    <label for="bidang" class="form-label fw-semibold">Bidang</label>
                    <select class="form-select <?= session('errors.bidang') ? 'is-invalid' : '' ?>" id="bidang" name="bidang" required>
                        <option value="">-- Pilih Bidang --</option>
                        <option value="Semua" <?= (old('bidang', $user['bidang']) === 'Semua') ? 'selected' : '' ?>>Semua</option>
                        <option value="Yayasan" <?= (old('bidang', $user['bidang']) === 'Yayasan') ? 'selected' : '' ?>>Yayasan</option>
                        <option value="Pendidikan" <?= (old('bidang', $user['bidang']) === 'Pendidikan') ? 'selected' : '' ?>>Pendidikan</option>
                        <option value="Majelis_Talim" <?= (old('bidang', $user['bidang']) === 'Majelis_Talim') ? 'selected' : '' ?>>Majelis Talim</option>
                    </select>
                    <?php if (session('errors.bidang')): ?>
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-1"></i><?= session('errors.bidang') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Buttons -->
                <button type="submit" class="btn btn-success w-100 fw-semibold">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="/users" class="btn btn-outline-secondary w-100 fw-semibold mt-2">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
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
