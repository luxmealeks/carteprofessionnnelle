<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- Header avec logo -->
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock me-2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <h3 class="my-2 text-center">Connexion à votre compte</h3>
                    </div>
                </div>

                <div class="card-body p-5">
                    <!-- Messages d'erreur -->
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong><i class="fas fa-exclamation-circle me-2"></i> <?php echo e($errors->first()); ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire -->
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Champ Email -->
                        <div class="mb-4">
                            <label class="form-label">Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="email" name="email" class="form-control form-control-lg"
                                       placeholder="votre@email.com" required autofocus>
                            </div>
                        </div>

                        <!-- Champ Mot de passe -->
                        <div class="mb-4">
                            <label class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                       class="form-control form-control-lg" placeholder="••••••••" required>
                                <button class="input-group-text bg-light toggle-password" type="button">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember me & Mot de passe oublié -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Se souvenir de moi</label>
                            </div>
                            <?php if(Route::has('password.request')): ?>
                                <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none">
                                    Mot de passe oublié ?
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Bouton de connexion -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i> Se connecter
                        </button>

                        <!-- Séparateur -->
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0 text-muted">OU</p>
                        </div>

                        <!-- Boutons de connexion sociale -->
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="#" class="btn btn-outline-primary w-100">
                                    <i class="fab fa-google me-2"></i> Google
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="#" class="btn btn-outline-primary w-100">
                                    <i class="fab fa-facebook-f me-2"></i> Facebook
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Lien vers inscription -->
                <div class="card-footer text-center py-3">
                    <p class="mb-0">Pas encore de compte ?
                        <a href="<?php echo e(route('register')); ?>" class="text-decoration-none">S'inscrire</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    .divider {
        color: #6c757d;
    }
    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #dee2e6;
    }
    .toggle-password {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.querySelector('.toggle-password');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye text-primary"></i>' : '<i class="fas fa-eye-slash text-primary"></i>';
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/auth/login.blade.php ENDPATH**/ ?>