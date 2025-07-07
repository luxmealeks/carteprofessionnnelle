

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2>Détails du Lot #<?php echo e($lot->id); ?></h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Inspection Académique:</strong> <?php echo e($lot->inspectionAcademique->nom); ?></p>
                    <p><strong>Date création:</strong> <?php echo e($lot->created_at->format('d/m/Y H:i')); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nombre d'agents:</strong> <?php echo e($lot->agents->count()); ?></p>
                </div>
            </div>

            <a href="<?php echo e(route('lots.index')); ?>" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/lots/show.blade.php ENDPATH**/ ?>