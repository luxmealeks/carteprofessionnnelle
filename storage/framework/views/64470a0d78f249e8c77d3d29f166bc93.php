<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <!-- En-tête -->
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-boxes me-2"></i>
                        <h4 class="mb-0 d-inline">Gestion des Lots</h4>
                    </div>
                    <a href="<?php echo e(route('lots.create')); ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Nouveau Lot
                    </a>
                </div>

                <div class="card-body p-4">
                    <!-- Messages de statut -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Tableau des lots -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Numéro</th>
                                    <th>Inspection Académique</th>
                                    <th>Date Création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-bold"><?php echo e($lot->numero); ?></td>
                                    <td><?php echo e($lot->inspectionAcademique->nom ?? 'N/A'); ?></td>
                                    <td><?php echo e($lot->created_at->format('d/m/Y H:i')); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                          

                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?php echo e($lot->id); ?>">
                                                Supprimer
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">Aucun lot enregistré</p>
                                        <a href="<?php echo e(route('lots.create')); ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i> Créer un lot
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if($lots->hasPages()): ?>
                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($lots->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals de confirmation de suppression -->
<?php $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="deleteModal<?php echo e($lot->id); ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo e($lot->id); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel<?php echo e($lot->id); ?>">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer définitivement le lot <strong><?php echo e($lot->numero); ?></strong> ?</p>
                <p class="text-danger"><small>Cette action est irréversible et supprimera toutes les données associées.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Annuler
                </button>
                <form action="<?php echo e(route('lots.destroy', $lot->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Confirmer la suppression
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
        padding: 1rem 1.5rem;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        background-color: #f8f9fa;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 4px;
    }
    .modal-content {
        border-radius: 8px;
        overflow: hidden;
    }
    .gap-2 {
        gap: 0.5rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des boutons d'action
    const actionButtons = document.querySelectorAll('.btn');

    actionButtons.forEach(button => {
        // Effet au survol
        button.addEventListener('mouseenter', function() {
            this.classList.add('shadow-sm');
            this.style.transform = 'translateY(-1px)';
        });

        button.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-sm');
            this.style.transform = '';
        });

        // Effet au clic
        button.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(1px)';
        });

        button.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-1px)';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/lots/index.blade.php ENDPATH**/ ?>