

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2>Structures (Directions & Services)</h2>

    <a href="<?php echo e(route('structures.create')); ?>" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter une structure
    </a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $structures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $structure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($structure->nom); ?></td>
                    <td><?php echo e(ucfirst($structure->type)); ?></td>
                    <td>
                        <a href="<?php echo e(route('structures.edit', $structure)); ?>" class="btn btn-sm btn-warning">
                            Modifier
                        </a>
                        <form action="<?php echo e(route('structures.destroy', $structure)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3">Aucune structure enregistrée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/structures/index.blade.php ENDPATH**/ ?>