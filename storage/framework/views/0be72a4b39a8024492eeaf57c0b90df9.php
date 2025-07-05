<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">
                <i class="bi bi-images me-2"></i>Validation des Photos d'Agents
            </h2>
        </div>

        <div class="card-body">
            <?php if($agents->isEmpty()): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Aucune photo en attente de validation
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="100">Photo</th>
                                <th>Informations Agent</th>
                                <th>Affectation</th>
                                <th width="250">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <!-- Colonne Photo -->
                                <td>
                                    <?php if($agent->photo): ?>
                                    <div class="photo-preview">
                                        <img src="<?php echo e(Storage::url($agent->photo)); ?>"
                                             alt="Photo de <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?>"
                                             class="img-thumbnail"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal<?php echo e($agent->id); ?>">
                                    </div>
                                    <?php else: ?>
                                    <div class="photo-preview bg-light d-flex align-items-center justify-content-center" style="width:80px;height:100px;">
                                        <i class="bi bi-person text-muted" style="font-size:2rem;"></i>
                                    </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Colonne Informations -->
                                <td>
                                    <h5 class="mb-1"><?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?></h5>
                                    <div class="text-muted small">
                                        <div><i class="bi bi-person-badge me-1"></i> <?php echo e($agent->matricule); ?></div>
                                        <div><i class="bi bi-telephone me-1"></i> <?php echo e($agent->telephone ?? 'Non renseigné'); ?></div>
                                        <?php if($agent->email): ?>
                                            <div><i class="bi bi-envelope me-1"></i> <?php echo e($agent->email); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Colonne Affectation -->
                                <td>
                                    <div class="fw-medium"><?php echo e($agent->etablissement->nom ?? 'Non affecté'); ?></div>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i> <?php echo e($agent->inspectionAcademique->nom ?? ''); ?>

                                    </div>
                                </td>

                                <!-- Colonne Actions -->
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="<?php echo e(route('photos.valider', $agent)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle me-1"></i> Valider
                                            </button>
                                        </form>

                                        <button class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejetModal<?php echo e($agent->id); ?>">
                                            <i class="bi bi-x-circle me-1"></i> Rejeter
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal pour la photo en grand -->
                            <?php if($agent->photo): ?>
                            <div class="modal fade" id="photoModal<?php echo e($agent->id); ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Photo de <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="<?php echo e(Storage::url($agent->photo)); ?>" class="img-fluid" alt="Photo agent">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Modal pour le rejet -->
                            <div class="modal fade" id="rejetModal<?php echo e($agent->id); ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?php echo e(route('photos.rejeter', $agent)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rejeter la photo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="motif<?php echo e($agent->id); ?>" class="form-label">Motif du rejet</label>
                                                    <textarea class="form-control" id="motif<?php echo e($agent->id); ?>"
                                                              name="motif_rejet_photo" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle me-1"></i> Confirmer le rejet
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($agents->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .photo-preview img {
        width: 80px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .photo-preview img:hover {
        transform: scale(1.05);
    }
    .table th {
        white-space: nowrap;
    }
    .photo-preview .bi-person {
        font-size: 2.5rem;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/photos/index.blade.php ENDPATH**/ ?>