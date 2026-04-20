<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Manajemen User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pt-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Manajemen User</h3>
        <a href="/users/create" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->has('message')): ?>

    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <?php if (empty($users)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                    <p class="text-muted mb-3">Belum ada data user. Silakan tambah user baru.</p>
                    <a href="/users/create" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah User Pertama
                    </a>
                </div>
            <?php else: ?>
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-success" style="border-bottom: 2px solid #198754;">
                        <tr>
                            <th class="px-4 py-3" style="width: 5%;">No</th>
                            <th class="py-3">Username</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Bidang</th>
                            <th class="px-4 py-3 text-center" style="width: 12%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="px-4 py-3 align-middle fw-bold text-success"><?= $no++; ?></td>
                                <td class="py-3 align-middle">
                                    <span class="badge bg-primary fw-normal"><?= esc($user['nama_pengguna']) ?></span>
                                </td>
                                <td class="py-3 align-middle fw-semibold"><?= esc($user['nama_lengkap']) ?></td>
                                <td class="py-3 align-middle text-muted"><?= esc($user['email']) ?></td>
                                <td class="py-3 align-middle">
                                    <span class="badge bg-info text-dark"><?= esc($user['role']) ?></span>
                                </td>
                                <td class="py-3 align-middle">
                                    <span class="badge bg-secondary"><?= esc($user['bidang'] ?? '-') ?></span>
                                </td>
                                <td class="px-4 py-3 text-center align-middle">
                                    <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteData(<?= $user['id'] ?>, '<?= esc($user['nama_pengguna']) ?>', '<?= esc($user['nama_lengkap']) ?>')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger bg-opacity-10 border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold text-danger mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Hapus User
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-left: 4px solid #ff6b6b;">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
                <p class="mb-3">Anda akan menghapus user berikut:</p>
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted d-block">Username:</small>
                            <span class="fw-semibold" id="deleteUsername"></span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Nama Lengkap:</small>
                            <span class="fw-semibold" id="deleteFullName"></span>
                        </div>
                    </div>
                </div>
                <p class="text-danger mb-0">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Semua data user ini akan dihapus dari sistem.
                </p>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i> Ya, Hapus User
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let deleteUserId = null;
    
    function setDeleteData(userId, username, fullname) {
        deleteUserId = userId;
        document.getElementById('deleteUsername').textContent = username;
        document.getElementById('deleteFullName').textContent = fullname;
        document.getElementById('confirmDeleteBtn').href = '/users/delete/' + userId;
    }
</script>
<?= $this->endSection() ?>
