

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Ajouter une Inspection Académique</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success mt-2">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('ias.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="form-group mt-3">
            <label for="nom">Nom de l'IA</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/ias/create.blade.php ENDPATH**/ ?>