

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2>Ajouter une structure</h2>

    <form action="<?php echo e(route('structures.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type (ex: direction, service)</label>
            <input type="text" name="type" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="<?php echo e(route('structures.index')); ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/structures/create.blade.php ENDPATH**/ ?>