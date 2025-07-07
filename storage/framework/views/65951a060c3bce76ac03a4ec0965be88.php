

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Ajouter un établissement</h1>

    <form action="<?php echo e(route('etablissements.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l’établissement</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ia_id" class="form-label">Inspection Académique (IA)</label>
            <select name="ia_id" id="ia_id" class="form-select" required>
                <option value="">-- Sélectionnez --</option>
                <?php $__currentLoopData = $ias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ia->id); ?>"><?php echo e($ia->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="ief_id" class="form-label">Inspection de l’Éducation et de la Formation (IEF) (optionnel)</label>
            <select name="ief_id" id="ief_id" class="form-select">
                <option value="">-- Aucun --</option>
                <?php $__currentLoopData = $iefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ief->id); ?>"><?php echo e($ief->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="<?php echo e(route('etablissements.index')); ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\carteprofessionnelles\carteprofessionnnelle\resources\views/parametrage/etablissements/create.blade.php ENDPATH**/ ?>