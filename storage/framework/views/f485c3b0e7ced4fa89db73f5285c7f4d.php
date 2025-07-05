<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><i class="bi bi-person-gear me-2"></i>Modification de l'Agent</h2>
        </div>

        <div class="card-body">
            <form action="<?php echo e(route('agents.update', $agent->id)); ?>" method="POST" enctype="multipart/form-data" id="agent-form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row g-3">
                    <!-- Section 1: Informations de base -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Informations Personnelles</h5>

                        <div class="mb-3">
                            <label class="form-label">Matricule</label>
                            <input type="text" name="matricule" class="form-control" value="<?php echo e(old('matricule', $agent->matricule)); ?>" maxlength="20">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">CIN</label>
                            <input type="text" name="cin" class="form-control" value="<?php echo e(old('cin', $agent->cin)); ?>" maxlength="20">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control" value="<?php echo e(old('nom', $agent->nom)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom" class="form-control" value="<?php echo e(old('prenom', $agent->prenom)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date de Naissance</label>
                            <input type="date" name="date_naissance" class="form-control" value="<?php echo e(old('date_naissance', $agent->date_naissance)); ?>">
                        </div>
                    </div>

                    <!-- Section 2: Photo et contacts -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Photo & Contacts</h5>

                        <div class="mb-3">
                            <label class="form-label">Photo actuelle</label>
                            <?php if($agent->photo): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(asset('storage/' . $agent->photo)); ?>" alt="Photo de l'agent" style="max-width: 150px; max-height: 150px;" class="img-thumbnail">
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Aucune photo disponible</p>
                            <?php endif; ?>
                            
                            <label class="form-label">Remplacer la photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png">
                            <small class="text-muted">Format: JPEG ou PNG (max 2MB)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $agent->email)); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="tel" name="telephone" class="form-control" value="<?php echo e(old('telephone', $agent->telephone)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="adresse" class="form-control" rows="2"><?php echo e(old('adresse', $agent->adresse)); ?></textarea>
                        </div>
                    </div>

                    <!-- Section 3: Informations professionnelles -->
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Informations Professionnelles</h5>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Fonction <span class="text-danger">*</span></label>
                                <input type="text" name="fonction" class="form-control" value="<?php echo e(old('fonction', $agent->fonction)); ?>" required>
                            </div>

                            <!-- Corps -->
    <div class="col-md-4">
        <label class="form-label">Corps</label>
        <select name="corps_id" class="form-select select-enhanced">
            <option value="">Sélectionner un corps</option>
            <?php $__currentLoopData = $corps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corpsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($corpsItem->id); ?>" <?php echo e(old('corps_id', $agent->corps_id) == $corpsItem->id ? 'selected' : ''); ?>>
                    <?php echo e($corpsItem->libelle); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <!-- Grade -->
    <div class="col-md-4">
        <label class="form-label">Grade</label>
        <select name="grade_id" class="form-select select-enhanced">
            <option value="">Sélectionner un grade</option>
            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($grade->id); ?>" <?php echo e(old('grade_id', $agent->grade_id) == $grade->id ? 'selected' : ''); ?>>
                    <?php echo e($grade->libelle); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>

                        <div class="row g-3 mt-2">
                            <!-- Structure -->
                            <div class="col-md-4">
                                <label for="structure_id" class="form-label">Structure</label>
                                <select name="structure_id" class="form-select" id="structure-select">
                                    <option value="">-- Aucune structure --</option>
                                    <?php $__currentLoopData = $structures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $structure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($structure->id); ?>" <?php echo e(old('structure_id', $agent->structure_id) == $structure->id ? 'selected' : ''); ?>>
                                            <?php echo e($structure->nom); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Inspection Académique -->
                            <div class="col-md-4" id="inspection-wrapper">
                                <label class="form-label">Inspection Académique</label>
                                <select name="inspection_academique_id" id="inspection-select" class="form-select">
                                    <option value="">Sélectionner une IA</option>
                                    <?php $__currentLoopData = $inspectionAcademiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ia->id); ?>" <?php echo e(old('inspection_academique_id', $agent->inspection_academique_id) == $ia->id ? 'selected' : ''); ?>>
                                            <?php echo e($ia->nom); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Établissement -->
                            <div class="col-md-4" id="etablissement-wrapper">
                                <label class="form-label">Établissement</label>
                                <select name="etablissement_id" id="etablissement-select" class="form-select">
                                    <option value="">Sélectionner un établissement</option>
                                    <?php $__currentLoopData = $etablissements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etablissement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($etablissement->id); ?>" <?php echo e(old('etablissement_id', $agent->etablissement_id) == $etablissement->id ? 'selected' : ''); ?>>
                                            <?php echo e($etablissement->nom); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Service central</label>
                                <input type="text" name="iden" class="form-control" value="<?php echo e(old('iden', $agent->iden)); ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Statut Photo</label>
                                <select name="statut_photo" class="form-select">
                                    <option value="en_attente" <?php echo e(old('statut_photo', $agent->statut_photo) === 'en_attente' ? 'selected' : ''); ?>>En attente</option>
                                    <option value="validee" <?php echo e(old('statut_photo', $agent->statut_photo) === 'validee' ? 'selected' : ''); ?>>Validée</option>
                                    <option value="rejetee" <?php echo e(old('statut_photo', $agent->statut_photo) === 'rejetee' ? 'selected' : ''); ?>>Rejetée</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Motif de rejet photo (si applicable)</label>
                                <input type="text" name="motif_rejet_photo" class="form-control" value="<?php echo e(old('motif_rejet_photo', $agent->motif_rejet_photo)); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Champ pour transmettre l'image recadrée en base64 -->
                <input type="hidden" name="cropped_photo" id="cropped_photo">

                <!-- Conteneur pour le recadrage d'image -->
                <div id="crop-container" class="mb-3 mt-3" style="display: none;">
                    <p class="text-muted">Recadrez la photo avant de sauvegarder :</p>
                    <div style="max-width: 100%;">
                        <img id="preview-image" style="max-width: 100%;">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo e(route('agents.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    .form-label {
        font-weight: 500;
    }
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    .is-invalid {
        border-color: #dc3545;
    }
    #preview-image {
        max-height: 400px;
    }
    
    /* Styles pour les selects */
    select.form-select, 
    select.form-select option {
        background-color: #fff !important;
        color: #212529 !important;
    }
    
    select.form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ----- Gestion du crop d'image -----
    const inputPhoto = document.querySelector('input[name="photo"]');
    const previewImage = document.getElementById('preview-image');
    const cropContainer = document.getElementById('crop-container');
    const croppedPhotoInput = document.getElementById('cropped_photo');
    let cropper;

    if (inputPhoto) {
        inputPhoto.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024 || !['image/jpeg', 'image/png'].includes(file.type)) {
                alert('Seuls les fichiers JPEG ou PNG de moins de 2 Mo sont autorisés.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                cropContainer.style.display = 'block';

                previewImage.onload = function () {
                    if (cropper) cropper.destroy();

                    cropper = new Cropper(previewImage, {
                        aspectRatio: NaN,
                        viewMode: 1,
                        autoCropArea: 0.8,
                        movable: true,
                        zoomable: true,
                        scalable: true,
                        cropBoxResizable: true,
                        cropBoxMovable: true,
                        cropend() {
                            cropper.getCroppedCanvas().toBlob(blob => {
                                const reader = new FileReader();
                                reader.onloadend = () => {
                                    croppedPhotoInput.value = reader.result;
                                };
                                reader.readAsDataURL(blob);
                            }, 'image/jpeg');
                        }
                    });
                };
            };
            reader.readAsDataURL(file);
        });
    }

    // ----- Validation des champs obligatoires -----
    document.getElementById('agent-form').addEventListener('submit', function (e) {
        let isValid = true;
        this.querySelectorAll('[required]').forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    });

    // ----- Masquer IA + établissement si structure sélectionnée -----
    const structureSelect = document.getElementById('structure-select');
    const inspectionWrapper = document.getElementById('inspection-wrapper');
    const etablissementWrapper = document.getElementById('etablissement-wrapper');

    function toggleVisibility() {
        const hasStructure = structureSelect && structureSelect.value;
        inspectionWrapper.style.display = hasStructure ? 'none' : 'block';
        etablissementWrapper.style.display = hasStructure ? 'none' : 'block';

        const inspectionSelect = inspectionWrapper.querySelector('select');
        const etablissementSelect = etablissementWrapper.querySelector('select');

        if (hasStructure) {
            inspectionSelect.removeAttribute('required');
            etablissementSelect.removeAttribute('required');
        } else {
            inspectionSelect.setAttribute('required', 'required');
            etablissementSelect.setAttribute('required', 'required');
        }
    }

    if (structureSelect) {
        structureSelect.addEventListener('change', toggleVisibility);
        toggleVisibility(); // appel initial
    }

    // ----- Chargement dynamique des établissements selon IA -----
    const inspectionSelect = document.getElementById('inspection-select');
    const etablissementSelect = document.getElementById('etablissement-select');

    if (inspectionSelect && etablissementSelect) {
        inspectionSelect.addEventListener('change', function() {
            const iaId = this.value;
            etablissementSelect.innerHTML = '<option value="">Chargement...</option>';
            etablissementSelect.disabled = true;

            if (!iaId) {
                etablissementSelect.innerHTML = '<option value="">Sélectionnez une IA</option>';
                etablissementSelect.disabled = false;
                return;
            }

            const iaData = <?php echo json_encode($inspectionAcademiques, 15, 512) ?>;
            const selectedIa = iaData.find(ia => ia.id == iaId);
            
            if (selectedIa && selectedIa.etablissements) {
                etablissementSelect.innerHTML = '<option value="">Sélectionner un établissement</option>';
                selectedIa.etablissements.forEach(etab => {
                    const option = new Option(etab.nom, etab.id);
                    etablissementSelect.add(option);
                });

                const prevValue = "<?php echo e(old('etablissement_id', $agent->etablissement_id)); ?>";
                if (prevValue) etablissementSelect.value = prevValue;

                etablissementSelect.disabled = false;
            } else {
                fetch(`/api/etablissements?inspection_academique_id=${iaId}`, {
                    headers: { 
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(data => {
                    etablissementSelect.innerHTML = '<option value="">Sélectionner un établissement</option>';
                    if (data.data && data.data.length) {
                        data.data.forEach(etab => {
                            const option = new Option(etab.nom, etab.id);
                            etablissementSelect.add(option);
                        });
                    }

                    const prevValue = "<?php echo e(old('etablissement_id', $agent->etablissement_id)); ?>";
                    if (prevValue) etablissementSelect.value = prevValue;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    etablissementSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                })
                .finally(() => {
                    etablissementSelect.disabled = false;
                });
            }
        });

        if (inspectionSelect.value) {
            inspectionSelect.dispatchEvent(new Event('change'));
        }
    }
});
// Ajoutez cette fonction pour réinitialiser les champs
function resetDependentFields() {
    const structureSelect = document.getElementById('structure-select');
    const inspectionSelect = document.getElementById('inspection-select');
    const etablissementSelect = document.getElementById('etablissement-select');
    
    if (structureSelect.value) {
        inspectionSelect.value = '';
        etablissementSelect.value = '';
    }
}

// Modifiez la fonction toggleVisibility
function toggleVisibility() {
    const hasStructure = structureSelect && structureSelect.value;
    inspectionWrapper.style.display = hasStructure ? 'none' : 'block';
    etablissementWrapper.style.display = hasStructure ? 'none' : 'block';

    if (hasStructure) {
        inspectionSelect.value = '';
        etablissementSelect.value = '';
    }
    
    // Appel initial et écouteur d'événement
    if (structureSelect) {
        structureSelect.addEventListener('change', function() {
            toggleVisibility();
            resetDependentFields();
        });
    }
}
// Ajoutez ceci à la fin de votre script
document.getElementById('agent-form').addEventListener('submit', function(e) {
    const structureId = document.getElementById('structure-select').value;
    const inspectionId = document.getElementById('inspection-select').value;
    
    // Validation supplémentaire côté client
    if (!structureId && !inspectionId) {
        e.preventDefault();
        alert('Vous devez sélectionner soit une Structure, soit une Inspection Académique');
        return false;
    }
    
    // Nettoyage des champs avant soumission
    if (structureId) {
        document.getElementById('inspection-select').disabled = true;
        document.getElementById('etablissement-select').disabled = true;
    }
});
</script>




<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/agents/edit.blade.php ENDPATH**/ ?>