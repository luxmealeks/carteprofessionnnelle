

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">
                    <i class="bi bi-printer me-2"></i>Gestion des lots d'impression
                </h2>
                <a href="<?php echo e(route('lots.create')); ?>" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Créer un lot
                </a>
            </div>
        </div>

        <div class="card-body">
            <?php if($lots->isEmpty()): ?>
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Aucun lot disponible pour impression.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nom du lot</th>
                                <th>Statut</th>
                                <th>Agents</th>
                                <th>Création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-bold"><?php echo e($loop->iteration); ?></td>
                                <td>
                                    <span class="badge bg-primary rounded-pill fs-6 px-3 py-1">
                                        <?php echo e($lot->numero); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($lot->statut === 'complet' ? 'success' : 'warning'); ?> rounded-pill">
                                        <?php echo e(ucfirst($lot->statut)); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary rounded-pill">
                                        <?php echo e($lot->agents_count); ?> agents
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo e($lot->created_at->format('d/m/Y H:i')); ?>

                                        <br>
                                        <span class="fst-italic">par <?php echo e($lot->creator->name ?? 'Système'); ?></span>
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="<?php echo e(route('lots.imprimer', $lot->id)); ?>" method="POST" target="_blank" class="print-form">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-success"
                                                    data-bs-toggle="tooltip" title="Imprimer le lot"
                                                    <?php if($lot->agents_count === 0): ?> disabled <?php endif; ?>>
                                                <i class="bi bi-printer-fill me-1"></i> Imprimer
                                            </button>
                                            <?php if($lot->agents_count === 0): ?>
                                            <small class="text-danger d-block mt-1">Aucun agent dans ce lot</small>
                                            <?php endif; ?>
                                        </form>

                                        <a href="<?php echo e(route('lots.show', $lot->id)); ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" title="Voir détails">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <button class="btn btn-sm btn-outline-danger delete-lot"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-lot-id="<?php echo e($lot->id); ?>"
                                                data-lot-name="<?php echo e($lot->numero); ?>"
                                                title="Supprimer le lot">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Affichage de <?php echo e($lots->firstItem()); ?> à <?php echo e($lots->lastItem()); ?> sur <?php echo e($lots->total()); ?> lots
                    </div>
                    <div>
                        <?php echo e($lots->links()); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer le lot <strong id="lotName"></strong> ?</p>
                    <p class="text-danger">Cette action est irréversible et supprimera également toutes les cartes associées.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i> Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .badge {
        font-weight: 500;
    }
    .btn-sm {
        padding: 0.375rem 0.75rem;
        transition: all 0.2s ease;
    }
    .print-form {
        display: inline-block;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enable tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Button animations
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'translateY(-2px)';
            button.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });
        button.addEventListener('mouseleave', () => {
            button.style.transform = '';
            button.style.boxShadow = '';
        });
    });

    // Delete modal handling
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const lotId = button.getAttribute('data-lot-id');
            const lotName = button.getAttribute('data-lot-name');

            document.getElementById('lotName').textContent = lotName;
            document.getElementById('deleteForm').action = `/lots/${lotId}`;
        });
    }

    // Print form handling with feedback
    const printForms = document.querySelectorAll('.print-form');
    printForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Impression...';
            btn.disabled = true;

            // Re-enable button after 3 seconds in case the print window is blocked
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-printer-fill me-1"></i> Imprimer';
                btn.disabled = false;
            }, 3000);
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/lots/choisir.blade.php ENDPATH**/ ?>