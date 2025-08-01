

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-people-fill me-2 text-primary"></i>Gestion des Agents
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agents</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2">
            <a href="<?php echo e(route('agents.create')); ?>" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Nouvel Agent
            </a>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload me-1"></i> Importer
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(request()->anyFilled(['search', 'statut', 'affectation', 'sort'])): ?>
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <strong>Filtres actifs :</strong>
        <?php $__currentLoopData = request()->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(in_array($key, ['search', 'statut', 'affectation', 'sort']) && !empty($value)): ?>
                <span class="badge bg-primary me-1">
                    <?php if($key === 'affectation' && Str::startsWith($value, 'etablissement_')): ?>
                        <?php
                            $etablissementId = Str::after($value, 'etablissement_');
                            $etablissement = $etablissements->firstWhere('id', $etablissementId);
                            $displayValue = $etablissement ? 'Établissement: '.$etablissement->nom : $value;
                        ?>
                        <?php echo e($displayValue); ?>

                    <?php elseif($key === 'sort'): ?>
                        <?php
                            $sortOptions = [
                                'nom_asc' => 'Nom (A-Z)',
                                'nom_desc' => 'Nom (Z-A)',
                                'date_asc' => 'Plus anciens',
                                'date_desc' => 'Plus récents'
                            ];
                            $displayValue = $sortOptions[$value] ?? $value;
                        ?>
                        Trier par: <?php echo e($displayValue); ?>

                    <?php else: ?>
                        <?php echo e(ucfirst($key)); ?>: <?php echo e($value); ?>

                    <?php endif; ?>
                </span>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('agents.index')); ?>" class="btn btn-sm btn-outline-light ms-2">
            <i class="bi bi-x-lg"></i> Réinitialiser
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Filters Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-3">
            <form action="<?php echo e(route('agents.index')); ?>" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label small text-muted">Recherche</label>
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control form-control-sm"
                                   placeholder="Nom, matricule..." value="<?php echo e(request('search')); ?>">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="statut" class="form-label small text-muted">Statut</label>
                        <select name="statut" id="statut" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            <option value="validee" <?php echo e(request('statut') == 'validee' ? 'selected' : ''); ?>>Validés</option>
                            <option value="en_attente" <?php echo e(request('statut') == 'en_attente' ? 'selected' : ''); ?>>En attente</option>
                            <option value="rejetee" <?php echo e(request('statut') == 'rejetee' ? 'selected' : ''); ?>>Rejetés</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="affectation" class="form-label small text-muted">Affectation</label>
                        <select name="affectation" id="affectation" class="form-select form-select-sm">
                            <option value="">Toutes</option>
                            <?php $__currentLoopData = $etablissements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etablissement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="etablissement_<?php echo e($etablissement->id); ?>" <?php echo e(request('affectation') == 'etablissement_'.$etablissement->id ? 'selected' : ''); ?>>
                                    <?php echo e($etablissement->nom); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sort" class="form-label small text-muted">Trier par</label>
                        <select name="sort" id="sort" class="form-select form-select-sm">
                            <option value="nom_asc" <?php echo e(request('sort') == 'nom_asc' ? 'selected' : ''); ?>>Nom (A-Z)</option>
                            <option value="nom_desc" <?php echo e(request('sort') == 'nom_desc' ? 'selected' : ''); ?>>Nom (Z-A)</option>
                            <option value="date_asc" <?php echo e(request('sort') == 'date_asc' ? 'selected' : ''); ?>>Plus anciens</option>
                            <option value="date_desc" <?php echo e(request('sort') == 'date_desc' ? 'selected' : ''); ?>>Plus récents</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                        <a href="<?php echo e(route('agents.index')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body p-0">
            <?php if($agents->isEmpty() && request()->anyFilled(['search', 'statut', 'affectation'])): ?>
            <div class="alert alert-warning m-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Aucun agent ne correspond à vos critères de recherche.
                <a href="<?php echo e(route('agents.index')); ?>" class="alert-link">Réinitialiser les filtres</a>
            </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60" class="text-center">Photo</th>
                            <th width="120">Matricule</th>
                            <th>Nom Complet</th>
                            <th width="120">CIN</th>
                            <th width="180">Contact</th>
                            <th width="220">Fonction</th>
                            <th width="200">Affectation</th>
                            <th width="120">Statut</th>
                            <th width="140" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <!-- Photo -->
                            <td class="text-center" data-label="Photo">
                                <div class="avatar-wrapper">
                                    <?php if($agent->photo): ?>
                                        <img src="<?php echo e(asset('storage/'.$agent->photo)); ?>"
                                             alt="Photo de <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?>"
                                             class="avatar-img"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal"
                                             data-agent-name="<?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?>"
                                             data-photo-url="<?php echo e(asset('storage/'.$agent->photo)); ?>">
                                    <?php else: ?>
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Matricule -->
                            <td data-label="Matricule">
                                <span class="fw-semibold badge bg-light text-dark"><?php echo e($agent->matricule); ?></span>
                            </td>

                            <!-- Nom complet -->
                            <td data-label="Nom">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold"><?php echo e($agent->nom); ?></span>
                                    <small class="text-muted"><?php echo e($agent->prenom); ?></small>
                                </div>
                            </td>

                            <!-- CIN -->
                            <td data-label="CIN">
                                <span class="badge bg-light text-dark"><?php echo e($agent->cin ?? 'N/A'); ?></span>
                            </td>

                            <!-- Contact -->
                            <td data-label="Contact">
                                <div class="d-flex flex-column small">
                                    <?php if($agent->email): ?>
                                        <a href="mailto:<?php echo e($agent->email); ?>" class="text-truncate text-primary text-decoration-none" title="<?php echo e($agent->email); ?>">
                                            <i class="bi bi-envelope me-1"></i><?php echo e(Str::limit($agent->email, 15)); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if($agent->telephone): ?>
                                        <span class="text-truncate" title="<?php echo e($agent->telephone); ?>">
                                            <i class="bi bi-telephone me-1"></i><?php echo e($agent->telephone); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Fonction -->
                            <td data-label="Fonction">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold"><?php echo e($agent->fonction ?? 'N/A'); ?></span>
                                    <small class="text-muted">
                                        <?php echo e($agent->corps->nom ?? ''); ?> / <?php echo e($agent->grade->nom ?? ''); ?>

                                    </small>
                                </div>
                            </td>

                            <!-- Affectation -->
                            <td data-label="Affectation">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">
                                        <?php if($agent->structure_id && $agent->relationLoaded('structure') && $agent->structure): ?>
                                            Structure : <?php echo e($agent->structure->nom); ?>

                                        <?php elseif($agent->etablissement_id && $agent->relationLoaded('etablissement') && $agent->etablissement): ?>
                                            Établissement : <?php echo e($agent->etablissement->nom); ?>

                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </span>
                                    
                                    <small class="text-muted">
                                        <?php if($agent->relationLoaded('inspectionAcademique') && $agent->inspectionAcademique): ?>
                                            <?php echo e($agent->inspectionAcademique->nom); ?>

                                        <?php elseif($agent->relationLoaded('etablissement') && $agent->etablissement && $agent->etablissement->relationLoaded('inspectionAcademique') && $agent->etablissement->inspectionAcademique): ?>
                                            <?php echo e($agent->etablissement->inspectionAcademique->nom); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                            </td>
                            


                            <!-- Statut -->
                            <td data-label="Statut">
                                <?php if($agent->statut_photo === 'validee'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill me-1"></i> Validé
                                    </span>
                                <?php elseif($agent->statut_photo === 'rejetee'): ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger d-flex align-items-center">
                                        <i class="bi bi-x-circle-fill me-1"></i> Rejeté
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning d-flex align-items-center">
                                        <i class="bi bi-hourglass-split me-1"></i> En attente
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" data-label="Actions">
                                <div class="d-flex justify-content-end gap-1">
                                    <!-- Bouton Traiter -->
                                 
                                    
                                    <!-- Bouton Voir -->
                                    <a href="<?php echo e(route('agents.show', $agent->id)); ?>"
                                       class="btn btn-xs btn-icon btn-primary"
                                       data-bs-toggle="tooltip"
                                       title="Voir fiche">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    
                                    <!-- Bouton Modifier -->
                                    <a href="<?php echo e(route('agents.edit', $agent->id)); ?>"
                                       class="btn btn-xs btn-icon btn-secondary"
                                       data-bs-toggle="tooltip"
                                       title="Modifier">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    
                                    <!-- Bouton Carte (conditionnel) -->
                                    <?php if($agent->statut_photo === 'validee'): ?>
                                    <a href="<?php echo e(route('agents.generateCard', $agent->id)); ?>"
                                       class="btn btn-xs btn-icon btn-success"
                                       data-bs-toggle="tooltip"
                                       title="Générer carte">
                                        <i class="bi bi-person-badge-fill"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            
                            <style>
                                /* Boutons ultra-compacts */
                                .btn-xs {
                                    padding: 0.25rem 0.35rem;
                                    font-size: 0.75rem;
                                    line-height: 1;
                                    border-radius: 3px;
                                }
                                
                                /* Icônes légèrement plus petites */
                                .btn-icon i {
                                    font-size: 0.9em;
                                    vertical-align: middle;
                                }
                                
                                /* Effet hover discret */
                                .btn-icon:hover {
                                    transform: scale(1.1);
                                    transition: transform 0.15s ease;
                                }
                            </style>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">Aucun agent trouvé</h5>
                                    <a href="<?php echo e(route('agents.create')); ?>" class="btn btn-primary mt-2">
                                        <i class="bi bi-person-plus me-1"></i> Ajouter un agent
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($agents->total() > $agents->perPage()): ?>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-2">
                        <div class="mb-2 mb-md-0">
                            <p class="small text-muted mb-0">
                                Affichage de <span class="fw-semibold"><?php echo e($agents->firstItem()); ?></span> à
                                <span class="fw-semibold"><?php echo e($agents->lastItem()); ?></span> sur
                                <span class="fw-semibold"><?php echo e($agents->total()); ?></span> agents
                            </p>
                        </div>
                        <div>
                            <?php echo e($agents->onEachSide(1)->links('vendor.pagination.bootstrap-5')); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('agents.import')); ?>" method="POST" enctype="multipart/form-data" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="bi bi-upload me-2"></i> Importer des agents
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="fichier" class="form-label">Fichier Excel</label>
                    <input type="file" name="fichier" id="fichier" class="form-control" required
                           accept=".xlsx,.xls,.csv" data-accept=".xlsx,.xls,.csv">
                    <div class="form-text">Formats acceptés: .xlsx, .xls, .csv (Max 5MB)</div>
                </div>
                <div class="alert alert-info small mb-0">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Téléchargez notre <a href="<?php echo e(asset('templates/import_agents.xlsx')); ?>" class="alert-link">modèle Excel</a>
                    pour garantir un import correct.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cloud-arrow-up me-1"></i> Importer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Single Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalTitle">Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhotoImg" src="" class="img-fluid rounded" alt="">
            </div>
            <div class="modal-footer">
                <a id="modalDownloadLink" href="#" download class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-download me-1"></i> Télécharger
                </a>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Table styling */
    .table {
        --bs-table-hover-bg: rgba(13, 110, 253, 0.03);
        margin-bottom: 0;
    }

    .table th {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
        background-color: #f8fafc;
        border-bottom-width: 1px;
        padding: 0.75rem 0.5rem;
        position: relative;
    }

    .table td {
        font-size: 0.875rem;
        vertical-align: middle;
        padding: 0.75rem 0.5rem;
    }

    /* Avatar styling */
    .avatar-wrapper {
        width: 36px;
        height: 36px;
        margin: 0 auto;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .avatar-wrapper:hover {
        transform: scale(1.1);
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #dee2e6;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 50%;
        color: #6c757d;
        font-size: 1.25rem;
    }

    /* Badge styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }

    /* Action buttons */
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .table-responsive {
            border: 0;
        }

        .table thead {
            display: none;
        }

        .table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            border-bottom: 1px solid #f8f9fa;
        }

        .table td::before {
            content: attr(data-label);
            min-width: 120px;
            font-weight: 500;
            margin-right: 1rem;
            color: #495057;
            font-size: 0.8rem;
        }

        .table td:last-child {
            border-bottom: 0;
        }

        .avatar-wrapper {
            margin: 0;
        }

        .btn-group .btn {
            padding: 0.2rem 0.4rem;
            font-size: 0.875rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Activer les tooltips et gérer la modale photo
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Validation du fichier d'import
        document.getElementById('fichier').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const acceptedTypes = this.getAttribute('data-accept').split(',');
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (file) {
                // Vérifier le type
                if (!acceptedTypes.some(type => file.name.endsWith(type))) {
                    alert('Veuillez sélectionner un fichier Excel (.xlsx, .xls) ou CSV');
                    this.value = '';
                    return;
                }

                // Vérifier la taille
                if (file.size > maxSize) {
                    alert('Le fichier est trop volumineux (max 5MB)');
                    this.value = '';
                }
            }
        });

        // Gestion de la modale photo unique
        const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
        const modalTitle = document.getElementById('photoModalTitle');
        const modalImg = document.getElementById('modalPhotoImg');
        const downloadLink = document.getElementById('modalDownloadLink');
        
        document.querySelectorAll('[data-bs-target="#photoModal"]').forEach(trigger => {
            trigger.addEventListener('click', function() {
                const agentName = this.getAttribute('data-agent-name');
                const photoUrl = this.getAttribute('data-photo-url');
                
                modalTitle.textContent = `Photo de ${agentName}`;
                modalImg.src = photoUrl;
                modalImg.alt = `Photo de ${agentName}`;
                downloadLink.href = photoUrl;
                downloadLink.download = `photo_${agentName.replace(/\s+/g, '_')}.jpg`;
            });
        });

        // Confirmation pour les actions sensibles
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/agents/index.blade.php ENDPATH**/ ?>