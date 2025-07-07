

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-crop me-2"></i>Recadrer la photo
                </h2>
                <a href="<?php echo e(route('photos.validation')); ?>" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Zone de recadrage -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ajustez le recadrage</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="img-container">
                                <img id="image-to-crop" src="<?php echo e(Storage::url($agent->photo)); ?>" 
                                     alt="Photo de <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?>"
                                     class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Options de recadrage -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Options</h5>
                        </div>
                        <div class="card-body">
                            <form id="crop-form" action="<?php echo e(route('photos.update-crop', $agent->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>

                                <!-- Dimensions recommandées -->
                                <div class="alert alert-info mb-4">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-info-circle-fill me-1"></i>Dimensions recommandées
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Format portrait (hauteur > largeur)</li>
                                        <li>Ratio idéal : 3/4 (ex: 600x800 px)</li>
                                        <li>Taille minimale : 400x600 px</li>
                                    </ul>
                                </div>

                                <!-- Paramètres de recadrage -->
                                <input type="hidden" id="x" name="x">
                                <input type="hidden" id="y" name="y">
                                <input type="hidden" id="width" name="width">
                                <input type="hidden" id="height" name="height">
                                <input type="hidden" id="rotate" name="rotate" value="0">

                                <!-- Actions -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Enregistrer le recadrage
                                    </button>
                                    <button type="button" id="reset-crop" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Réinitialiser
                                    </button>
                                    <a href="<?php echo e(route('photos.validation')); ?>" class="btn btn-outline-danger">
                                        <i class="bi bi-x-circle me-1"></i> Annuler
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .img-container {
        max-height: 70vh;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    
    #image-to-crop {
        max-width: 100%;
    }
    
    /* Style pour le cadre de recadrage */
/*     .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    } */
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Library Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du cropper
    const image = document.getElementById('image-to-crop');
    const cropper = new Cropper(image, {
        aspectRatio: 3 / 4,
        viewMode: 1,
        autoCropArea: 0.8,
        responsive: true,
        guides: false,
        center: false,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
        ready() {
            // Appliquer un cadre circulaire
            this.cropper.setCropBoxData({
                width: Math.min(this.cropper.getContainerData().width, 
                              this.cropper.getContainerData().height),
                height: Math.min(this.cropper.getContainerData().width, 
                               this.cropper.getContainerData().height)
            });
        },
        crop(event) {
            // Mettre à jour les champs cachés avec les coordonnées de recadrage
            document.getElementById('x').value = Math.round(event.detail.x);
            document.getElementById('y').value = Math.round(event.detail.y);
            document.getElementById('width').value = Math.round(event.detail.width);
            document.getElementById('height').value = Math.round(event.detail.height);
        }
    });

    // Réinitialiser le recadrage
    document.getElementById('reset-crop').addEventListener('click', function() {
        cropper.reset();
        document.getElementById('rotate').value = 0;
    });

    // Gestion de la soumission du formulaire
    document.getElementById('crop-form').addEventListener('submit', function(e) {
        if (!document.getElementById('width').value) {
            e.preventDefault();
            alert('Veuillez sélectionner une zone à recadrer');
            return false;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/photos/recadrer.blade.php ENDPATH**/ ?>