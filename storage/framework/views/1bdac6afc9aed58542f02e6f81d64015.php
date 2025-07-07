

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>Liste des établissements
        </h1>
        <a href="<?php echo e(route('etablissements.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Ajouter
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('etablissements.index')); ?>" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="inspection_academique_id" class="form-label">Inspection Académique</label>
                        <select name="inspection_academique_id" id="inspection_academique_id" class="form-select">
                            <option value="">Toutes les IA</option>
                            <?php $__currentLoopData = $ias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ia->id); ?>"
                                    <?php echo e(request('inspection_academique_id') == $ia->id ? 'selected' : ''); ?>>
                                    <?php echo e($ia->nom); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="ief_id" class="form-label">IEF</label>
                        <select name="ief_id" id="ief_id" class="form-select">
                            <option value="">Tous les IEF</option>
                            <?php if(request('inspection_academique_id')): ?>
                                <?php $__currentLoopData = $iefs->where('inspection_academique_id', request('inspection_academique_id')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ief->id); ?>"
                                        <?php echo e(request('ief_id') == $ief->id ? 'selected' : ''); ?>>
                                        <?php echo e($ief->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                        <a href="<?php echo e(route('etablissements.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Inspection Académique</th>
                            <th>IEF</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $etablissements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($etab->nom); ?></td>
                            <td>
                                <?php if($etab->inspectionAcademique): ?>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <?php echo e($etab->inspectionAcademique->nom); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">Non affecté</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($etab->ief): ?>
                                    <span class="badge bg-light text-dark">
                                        <?php echo e($etab->ief->nom); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">Non affecté</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('etablissements.edit', $etab->id)); ?>"
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('etablissements.destroy', $etab->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="tooltip"
                                                title="Supprimer"
                                                onclick="return confirm('Confirmer la suppression ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-building text-muted" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">Aucun établissement trouvé</p>
                                <?php if(request()->any()): ?>
                                    <a href="<?php echo e(route('etablissements.index')); ?>" class="btn btn-sm btn-outline-primary mt-2">
                                        Réinitialiser les filtres
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($etablissements->hasPages()): ?>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            Affichage de <?php echo e($etablissements->firstItem()); ?> à <?php echo e($etablissements->lastItem()); ?> sur <?php echo e($etablissements->total()); ?>

                        </div>
                        <div>
                            <?php echo e($etablissements->withQueryString()->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamique des IEF en fonction de l'IA sélectionnée
    const iaSelect = document.getElementById('inspection_academique_id');
    const iefSelect = document.getElementById('ief_id');

    iaSelect.addEventListener('change', function() {
        const iaId = this.value;
        iefSelect.innerHTML = '<option value="">Tous les IEF</option>';

        if(iaId) {
            fetch(`/api/iefs-by-ia/${iaId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(ief => {
                        const option = document.createElement('option');
                        option.value = ief.id;
                        option.textContent = ief.nom;
                        iefSelect.appendChild(option);
                    });
                });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/parametrage/etablissements/index.blade.php ENDPATH**/ ?>