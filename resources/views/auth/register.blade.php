@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- En-tête avec icône -->
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus me-2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y1="11"></line>
                        </svg>
                        <h3 class="my-2 text-center">Créer un compte</h3>
                    </div>
                </div>

                <div class="card-body p-5">
                    <!-- Formulaire -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Champ Nom complet -->
                        <div class="mb-4">
                            <label class="form-label">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" name="name" class="form-control form-control-lg"
                                       placeholder="Votre nom complet" required autofocus>
                            </div>
                        </div>

                        <!-- Champ Email -->
                        <div class="mb-4">
                            <label class="form-label">Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="email" name="email" class="form-control form-control-lg"
                                       placeholder="votre@email.com" required>
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
                            <small class="form-text text-muted">Minimum 8 caractères</small>
                        </div>

                        <!-- Champ Confirmation mot de passe -->
                        <div class="mb-4">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control form-control-lg" placeholder="••••••••" required>
                                <button class="input-group-text bg-light toggle-confirmation" type="button">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Conditions d'utilisation -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                J'accepte les <a href="#" class="text-decoration-none">conditions d'utilisation</a>
                            </label>
                        </div>

                        <!-- Bouton d'inscription -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 mb-3">
                            <i class="fas fa-user-plus me-2"></i> S'inscrire
                        </button>

                        <!-- Séparateur -->
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0 text-muted">OU</p>
                        </div>

                        <!-- Boutons d'inscription sociale -->
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

                <!-- Lien vers connexion -->
                <div class="card-footer text-center py-3">
                    <p class="mb-0">Déjà un compte ?
                        <a href="{{ route('login') }}" class="text-decoration-none">Se connecter</a>
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
    .toggle-password, .toggle-confirmation {
        cursor: pointer;
    }
    .form-text {
        font-size: 0.85rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = (button, fieldId) => {
            const field = document.querySelector(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
            button.innerHTML = type === 'password'
                ? '<i class="fas fa-eye text-primary"></i>'
                : '<i class="fas fa-eye-slash text-primary"></i>';
        };

        document.querySelector('.toggle-password').addEventListener('click', function() {
            togglePassword(this, '#password');
        });

        document.querySelector('.toggle-confirmation').addEventListener('click', function() {
            togglePassword(this, '#password_confirmation');
        });
    });
</script>
@endsection
