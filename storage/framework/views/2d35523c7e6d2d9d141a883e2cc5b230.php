<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="Tableau de bord d'administration MFPT">
    <title><?php echo $__env->yieldContent('title', 'MFPT Admin'); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon" sizes="any">
    <link rel="icon" href="<?php echo e(asset('icon.svg')); ?>" type="image/svg+xml" sizes="any">
    <link rel="apple-touch-icon" href="<?php echo e(asset('apple-touch-icon.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('site.webmanifest')); ?>">

    <!-- Preload critical resources -->
    <link rel="preload" href="<?php echo e(asset('css/app.css')); ?>" as="style">
    <link rel="preload" href="<?php echo e(asset('js/app.js')); ?>" as="script">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <head>
        <link rel="manifest" href="<?php echo e(asset('site.webmanifest')); ?>">
    </head>

    <!-- Styles -->
    <?php echo $__env->renderWhen(config('app.env') !== 'testing', 'partials.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>

    <!-- Scripts head -->
    <?php echo $__env->renderWhen(config('app.debug'), 'partials.scripts-head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Skip to main content -->
    <a href="#main-content" class="visually-hidden-focusable position-absolute top-0 start-0 p-2 bg-dark text-white">Aller au contenu principal</a>

    <!-- Barre de navigation -->
    <?php echo $__env->renderWhen(auth()->check(), 'partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

    <!-- Contenu principal -->
    <main id="main-content" class="flex-shrink-0" role="main">
        <div class="container-fluid px-3 px-md-4">
            <div class="row g-0">
                <!-- Sidebar -->
                <?php if(auth()->guard()->check()): ?>
                    <?php if (! (request()->is('/'))): ?>
                        <aside class="col-md-3 col-lg-2 d-none d-md-block sidebar-container" aria-label="Menu principal">
                            <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </aside>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Contenu dynamique -->
                <div class="<?php if(auth()->guard()->check()): ?> <?php if (! (request()->is('/'))): ?> col-md-9 col-lg-10 <?php else: ?> col-12 <?php endif; ?> <?php else: ?> col-12 <?php endif; ?> main-content-container">
                    <div class="container-fluid py-3 py-md-4">
                        <?php echo $__env->make('partials.flash-messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Pied de page -->
    <?php echo $__env->renderWhen(config('app.show_footer', true), 'partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

    <!-- Scripts -->
    <?php echo $__env->make('partials.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/layouts/app.blade.php ENDPATH**/ ?>