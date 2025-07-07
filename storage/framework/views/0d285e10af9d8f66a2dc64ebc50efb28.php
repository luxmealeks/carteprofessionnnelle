

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
                <i class="bi bi-images me-2"></i>Validation des Photos d'Agents
                <span class="badge bg-white text-primary ms-2"><?php echo e($agents->total()); ?> en attente</span>
            </h2>
            <div class="d-flex align-items-center">
                <span class="me-3 small text-white-50">Dernière mise à jour : <?php echo e(now()->format('d/m/Y H:i')); ?></span>
                <button class="btn btn-light btn-sm" onclick="window.location.reload()">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Contraintes de validation -->
            <div class="alert alert-info mb-4">
                <h5 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Consignes de validation</h5>
                <ul class="mb-0">
                    <li>La photo doit être récente et ressemblante</li>
                    <li>Le visage doit être clairement visible (pas de lunettes foncées, pas de masque)</li>
                    <li>Photo en couleur sur fond neutre (blanc ou gris clair recommandé)</li>
                    <li>Format portrait (hauteur > largeur)</li>
                    <li>Taille minimale : 400x600 pixels</li>
                    <li>Format accepté : JPG/PNG (max 2MB)</li>
                </ul>
            </div>

            <?php if($agents->isEmpty()): ?>
                <div class="alert alert-success text-center py-4">
                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.5rem;"></i>
                    <span class="fs-5">Toutes les photos ont été validées !</span>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mb-4 py-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Vous avez <strong><?php echo e($agents->total()); ?> photos</strong> en attente de validation
                </div>

                <div class="table-responsive rounded">
                    <table class="table table-hover align-middle mb-0 bg-white">
                        <thead class="table-light">
                            <tr>
                                <th width="100" class="text-center">Photo</th>
                                <th>Informations Agent</th>
                                <th>Affectation</th>
                                <th width="300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($loop->odd ? 'bg-light' : ''); ?>">
                                <!-- Colonne Photo -->
                                <td class="text-center">
                                    <?php if($agent->photo): ?>
                                    <div class="photo-preview mx-auto position-relative">
                                        <img src="<?php echo e(Storage::url($agent->photo)); ?>"
                                             alt="Photo de <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?>"
                                             class="img-thumbnail rounded-circle border-primary"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal<?php echo e($agent->id); ?>">
                                        <!-- Badge d'alerte si photo non conforme -->
                                        <?php if($agent->photo_issues): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                            <span class="visually-hidden">Problèmes détectés</span>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php else: ?>
                                    <div class="photo-preview bg-light d-flex align-items-center justify-content-center mx-auto rounded-circle" 
                                         style="width:80px;height:80px;">
                                        <i class="bi bi-person text-muted" style="font-size:2rem;"></i>
                                    </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Colonne Informations -->
                                <td>
                                    <h5 class="mb-1 fw-bold"><?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?></h5>
                                    <div class="text-muted small">
                                        <div><i class="bi bi-person-badge me-1"></i> <?php echo e($agent->matricule); ?></div>
                                        <div><i class="bi bi-telephone me-1"></i> <?php echo e($agent->telephone ?? 'Non renseigné'); ?></div>
                                        <?php if($agent->email): ?>
                                            <div><i class="bi bi-envelope me-1"></i> <?php echo e($agent->email); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Affichage des problèmes détectés -->
                                    <?php if($agent->photo_issues): ?>
                                    <div class="mt-2">
                                        <?php $__currentLoopData = $agent->photo_issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-warning text-dark mb-1">
                                            <i class="bi bi-exclamation-triangle me-1"></i><?php echo e($issue); ?>

                                        </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Colonne Affectation -->
                                <td>
                                    <div class="fw-medium">
                                        <i class="bi bi-building me-1"></i> <?php echo e($agent->etablissement->nom ?? 'Non affecté'); ?>

                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i> <?php echo e($agent->inspectionAcademique->nom ?? ''); ?>

                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-briefcase me-1"></i> <?php echo e($agent->grade->libelle ?? ''); ?>

                                    </div>
                                </td>

                                <!-- Colonne Actions -->
                                <td>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        <form action="<?php echo e(route('photos.valider', $agent)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm px-3">
                                                <i class="bi bi-check-circle me-1"></i> Valider
                                            </button>
                                        </form>

                                        <button class="btn btn-outline-danger btn-sm px-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejetModal<?php echo e($agent->id); ?>">
                                            <i class="bi bi-x-circle me-1"></i> Rejeter
                                        </button>

                                        <a href="<?php echo e(route('photos.recadrer', $agent->id)); ?>" 
                                           class="btn btn-outline-primary btn-sm px-3"
                                           data-bs-toggle="tooltip"
                                           title="Recadrer la photo">
                                            <i class="bi bi-crop me-1"></i> Recadrer
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal pour la photo en grand -->
                            <?php if($agent->photo): ?>
                            <div class="modal fade" id="photoModal<?php echo e($agent->id); ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-person-badge me-2"></i>
                                                <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?> - <?php echo e($agent->matricule); ?>

                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center p-0">
                                            <img src="<?php echo e(Storage::url($agent->photo)); ?>" 
                                                 class="img-fluid" 
                                                 alt="Photo de <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?>"
                                                 style="max-height: 70vh;">
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <div class="d-flex justify-content-between w-100">
                                                <small class="text-muted">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Soumise le <?php echo e($agent->updated_at->format('d/m/Y à H:i')); ?>

                                                </small>
                                                <small class="text-muted">
                                                    <i class="bi bi-file-earmark-image me-1"></i>
                                                    <?php echo e($agent->photo_dimensions ?? 'Dimensions inconnues'); ?>

                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Modal pour le rejet -->
                            <div class="modal fade" id="rejetModal<?php echo e($agent->id); ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="<?php echo e(route('photos.rejeter', $agent)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-x-circle me-2"></i>
                                                    Rejeter la photo
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <p class="mb-3">Vous êtes sur le point de rejeter la photo de <strong><?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?></strong> (<?php echo e($agent->matricule); ?>).</p>
                                                    
                                                    <!-- Sélection rapide des motifs courants -->
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Motifs courants :</label>
                                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                                            <?php $__currentLoopData = ['Visage non visible', 'Photo floue', 'Mauvais format', 'Fond non conforme', 'Photo trop ancienne']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                                    onclick="document.getElementById('motif<?php echo e($agent->id); ?>').value += '<?php echo e($motif); ?>.\n'">
                                                                <?php echo e($motif); ?>

                                                            </button>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <label for="motif<?php echo e($agent->id); ?>" class="form-label fw-bold">Motif du rejet :</label>
                                                    <textarea class="form-control" id="motif<?php echo e($agent->id); ?>"
                                                              name="motif_rejet_photo" rows="3" 
                                                              placeholder="Décrivez précisément le problème..."
                                                              required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="bi bi-arrow-left me-1"></i> Annuler
                                                </button>
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
                
                <!-- Pagination et statistiques -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Affichage de <strong><?php echo e($agents->firstItem()); ?></strong> à <strong><?php echo e($agents->lastItem()); ?></strong> 
                        sur <strong><?php echo e($agents->total()); ?></strong> agents en attente
                    </div>
                    <div>
                        <?php echo e($agents->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .photo-preview {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        position: relative;
    }
    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .photo-preview img:hover {
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .table th {
        white-space: nowrap;
        vertical-align: middle;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
    }
    .modal-body img {
        max-width: 100%;
        height: auto;
        border-radius: 0.3rem;
    }
    .bg-light {
        background-color: #f8f9fa!important;
    }
    .photo-issues-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 0.6rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Activer les tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Pré-remplissage des motifs de rejet
        document.querySelectorAll('[data-bs-target^="#rejetModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const agentId = this.getAttribute('data-bs-target').replace('#rejetModal', '');
                const textarea = document.getElementById(`motif${agentId}`);
                
                // Réinitialiser le textarea
                textarea.value = '';
                
                // Optionnel: Ajouter des motifs pré-détectés
                <?php if(isset($agent) && $agent->photo_issues): ?>
                    textarea.value = "Problèmes détectés :\n";
                    <?php $__currentLoopData = $agent->photo_issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        textarea.value += "- <?php echo e($issue); ?>\n";
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/photos/validation.blade.php ENDPATH**/ ?>