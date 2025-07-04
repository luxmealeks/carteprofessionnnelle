<?php $__env->startSection('content'); ?>
<div class="container-fluid admin-dashboard">
    <div class="row">
        <!-- Main Content -->
        <main class="col-md-10 p-4">
            <!-- Header Section -->
            <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h1 class="h3 mb-2">
                        <i class="bi bi-speedometer2 text-primary me-2"></i>Tableau de Bord
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Administration</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-calendar me-1"></i> <?php echo e(now()->format('d M Y')); ?>

                    </button>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-download me-1"></i> Exporter
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <!-- Total Agents Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statistic-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted mb-2">Total Agents</h6>
                                    <h2 class="mb-0"><?php echo e(number_format($total)); ?></h2>
                                </div>
                                <div class="icon-bg bg-primary">
                                    <i class="bi bi-people-fill text-white"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-success-subtle text-success">
                                    <i class="bi bi-arrow-up me-1"></i>5.2%
                                </span>
                                <small class="text-muted ms-2">vs mois dernier</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- En Attente Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statistic-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted mb-2">En Attente</h6>
                                    <h2 class="mb-0"><?php echo e(number_format($en_attente)); ?></h2>
                                </div>
                                <div class="icon-bg bg-warning">
                                    <i class="bi bi-hourglass-split text-white"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-danger-subtle text-danger">
                                    <i class="bi bi-arrow-down me-1"></i>2.1%
                                </span>
                                <small class="text-muted ms-2">vs mois dernier</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Validées Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statistic-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted mb-2">Validées</h6>
                                    <h2 class="mb-0"><?php echo e(number_format($validees)); ?></h2>
                                </div>
                                <div class="icon-bg bg-success">
                                    <i class="bi bi-check-circle-fill text-white"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-success-subtle text-success">
                                    <i class="bi bi-arrow-up me-1"></i>8.7%
                                </span>
                                <small class="text-muted ms-2">vs mois dernier</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejetées Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statistic-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted mb-2">Rejetées</h6>
                                    <h2 class="mb-0"><?php echo e(number_format($rejetees)); ?></h2>
                                </div>
                                <div class="icon-bg bg-danger">
                                    <i class="bi bi-x-circle-fill text-white"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-success-subtle text-success">
                                    <i class="bi bi-arrow-down me-1"></i>1.3%
                                </span>
                                <small class="text-muted ms-2">vs mois dernier</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <section class="quick-actions-section mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                            <h5 class="card-title mb-3 mb-md-0">
                                <i class="bi bi-lightning-fill text-warning me-2"></i>Actions Rapides
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-arrow-repeat me-1"></i> Actualiser
                                </button>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="<?php echo e(route('agents.create')); ?>" class="btn btn-action btn-primary">
                                <i class="bi bi-person-plus me-2"></i>Ajouter un Agent
                            </a>
                            <a href="<?php echo e(route('photos.index')); ?>" class="btn btn-action btn-warning">
                                <i class="bi bi-camera me-2"></i>Valider Photos
                            </a>
                            <a href="<?php echo e(route('lots.generer')); ?>" class="btn btn-action btn-success">
                                <i class="bi bi-files me-2"></i>Générer Lot
                            </a>
                            <a href="<?php echo e(route('ias.create')); ?>" class="btn btn-action btn-info">
                                <i class="bi bi-building me-2"></i>Ajouter IA
                            </a>
                            <a href="#" class="btn btn-action btn-dark">
                                <i class="bi bi-graph-up me-2"></i>Rapports
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recent Activity -->
            <section class="recent-activity mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="bi bi-clock-history text-primary me-2"></i>Activité Récente
                        </h5>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item border-0 px-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar bg-light-<?php echo e($activity['color']); ?> text-<?php echo e($activity['color']); ?>">
                                            <i class="bi bi-<?php echo e($activity['icon']); ?>"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1"><?php echo e($activity['title']); ?></h6>
                                        <p class="mb-0 text-muted small"><?php echo e($activity['description']); ?></p>
                                    </div>
                                    <small class="text-muted"><?php echo e($activity['time']); ?></small>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .admin-dashboard {
        background-color: #f8fafc;
        min-height: 100vh;
    }

    .dashboard-header {
        background-color: white;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .statistic-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        background-color: white;
    }

    .statistic-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .icon-bg {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .btn-action {
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
        border: none;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .bg-light-primary { background-color: rgba(13,110,253,0.1); }
    .bg-light-warning { background-color: rgba(255,193,7,0.1); }
    .bg-light-success { background-color: rgba(25,135,84,0.1); }
    .bg-light-danger { background-color: rgba(220,53,69,0.1); }
    .bg-light-info { background-color: rgba(13,202,240,0.1); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for cards
        const cards = document.querySelectorAll('.statistic-card, .btn-action');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });

        // Tooltip initialization
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>