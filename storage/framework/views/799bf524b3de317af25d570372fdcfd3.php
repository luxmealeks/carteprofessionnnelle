<?php $__env->startPush('styles'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Rogner la photo de <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?></h2>

    <div class="text-center mb-3">
        <img id="photo-to-crop" src="<?php echo e(Storage::url($agent->photo)); ?>" class="img-fluid" style="max-width: 300px;">
    </div>

    <div class="text-center">
        <button id="cropButton" class="btn btn-success">Rogner et sauvegarder</button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
let cropper; // rendre global

document.addEventListener("DOMContentLoaded", function () {
    const image = document.getElementById('photo-to-crop');

    // S'assurer que l'image est bien chargée avant de créer le cropper
    if (image.complete) {
        initializeCropper();
    } else {
        image.addEventListener('load', initializeCropper);
    }

    function initializeCropper() {
        cropper = new Cropper(image, {
            aspectRatio: 3 / 4,
            viewMode: 1
        });
    }

    document.getElementById('cropAndRemoveBgBtn').addEventListener('click', function () {
        if (!cropper) {
            alert("Rogneur non initialisé");
            return;
        }

        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 400
        });

        if (!canvas) {
            alert("Canvas non généré");
            return;
        }

        canvas.toBlob(function (blob) {
            const formData = new FormData();
            formData.append('photo', blob, 'photo.jpg');
            formData.append('_token', '<?php echo e(csrf_token()); ?>');

            fetch("<?php echo e(route('photos.rogner.removebg', $agent)); ?>", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Photo rognée avec succès !");
                    window.location.href = "<?php echo e(route('photos.index')); ?>";
                } else {
                    alert("Erreur Laravel : " + (data.error || "inconnue"));
                }
            })
            .catch(err => {
                console.error(err);
                alert("Erreur : " + err.message);
            });
        }, 'image/jpeg');
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/photos/traiter.blade.php ENDPATH**/ ?>