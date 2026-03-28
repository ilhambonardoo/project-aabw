<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - App</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('/css/main.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/css/sidebar.css'); ?>">


</head>
<body>
    <div class="main-wrapper">
        <?= $this->include('/layouts/sidebar'); ?>
        
        <!-- Top Navbar -->
        <div style="width: 100%; display: flex; flex-direction: column;">

            <!-- Main Content -->
            <main id="mainContent">
                <div class="py-4 px-4">
                    <?= $this->include('/layouts/navbar'); ?>
                    <!-- Flash Messages -->
                    <?php if (session()->has('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= session('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                <!-- Page Content -->
                <?= $this->renderSection('content'); ?>
                </div>
            </main>
        </div>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebarNav');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('hide');
                mainContent.classList.toggle('sidebar-hidden');
                
                localStorage.setItem('sidebarHidden', sidebar.classList.contains('hide'));
            });
        }

        window.addEventListener('DOMContentLoaded', function() {
            const isHidden = localStorage.getItem('sidebarHidden') === 'true';
            if (isHidden) {
                sidebar.classList.add('hide');
                mainContent.classList.add('sidebar-hidden');
            }
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth < 768 && !sidebar.classList.contains('hide')) {
                    sidebar.classList.add('hide');
                    mainContent.classList.add('sidebar-hidden');
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>