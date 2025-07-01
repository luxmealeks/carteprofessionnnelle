@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <!-- Hero Section -->
    <div class="welcome-hero bg-mfpt-gradient py-6 position-relative overflow-hidden">
        <div class="container text-center text-white position-relative z-index-1">
            <div class="welcome-logo mb-4">
                <img src="{{ asset('images/mfpt-logo-white.png') }}" alt="Logo MFPT" class="img-fluid" style="max-height: 100px;">
            </div>
            <h1 class="display-4 fw-bold mb-3">SAMACARTE : Système d’Administration et de Management Avancé des Cartes des Agents, avec Référencement et Traçabilité Électronique</h1>
            <p class="lead mb-4">Plateforme officielle du Ministère pour la gestion des cartes d'identification du personnel</p>

            <div class="welcome-badge mb-4">
                <img src="{{ asset('images/pro-badge.svg') }}" alt="Carte Professionnelle" class="img-fluid" style="max-height: 180px;">
            </div>

            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                <span class="badge bg-light text-primary fs-6 py-2 px-3">
                    <i class="fas fa-id-card me-2"></i> Demande en ligne
                </span>
                <span class="badge bg-light text-primary fs-6 py-2 px-3">
                    <i class="fas fa-sync-alt me-2"></i> Renouvellement
                </span>
                <span class="badge bg-light text-primary fs-6 py-2 px-3">
                    <i class="fas fa-search me-2"></i> Suivi de dossier
                </span>
            </div>
        </div>

        <!-- Waves decoration -->
        <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <!-- Main Content -->
    <div class="welcome-content py-5">
        <div class="container">
            @guest
            <!-- Authentication Section for Guests -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="h3 mb-4 text-center text-primary">Accès à la plateforme</h2>
                            <p class="text-muted mb-4 text-center">Cette plateforme est réservée aux personnels du MFPT pour la gestion de leur carte professionnelle.</p>

                            <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mt-4">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 py-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> Connexion personnel
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4 py-3">
                                    <i class="fas fa-user-plus me-2"></i> Première connexion
                                </a>
                            </div>

                            <div class="mt-4 pt-3 text-center border-top">
                                <a href="#" class="text-muted small"><i class="fas fa-question-circle me-1"></i> Aide à la connexion</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endguest

            @auth
            <!-- Welcome Section for Authenticated Users -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 bg-light-primary">
                        <div class="card-body p-5 text-center">
                            <div class="welcome-avatar mb-4">
                                @if(Auth::user()->photo)
                                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Photo profil" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                <div class="avatar bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                @endif
                            </div>
                            <h2 class="h3 mb-3">Bienvenue, {{ Auth::user()->name }}</h2>
                            <p class="text-muted mb-4">Vous êtes connecté à la plateforme de gestion des cartes professionnelles</p>

                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 py-2">
                                    <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                                </a>
                                <a href="{{ route('card.request') }}" class="btn btn-success btn-lg px-4 py-2">
                                    <i class="fas fa-id-card me-2"></i> Ma carte
                                </a>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-lg px-4 py-2">
                                    <i class="fas fa-cog me-2"></i> Administration
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            @guest
            <!-- Features Section -->
            <div class="row mt-6">
                <div class="col-12">
                    <h2 class="h3 text-center mb-5">Services disponibles</h2>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm hvr-grow">
                        <div class="card-body text-center p-4">
                            <div class="icon-container bg-primary-soft text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                                <i class="fas fa-id-card fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">Demande de carte</h3>
                            <p class="text-muted">Effectuez votre demande de carte professionnelle en ligne en quelques étapes simples.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm hvr-grow">
                        <div class="card-body text-center p-4">
                            <div class="icon-container bg-primary-soft text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">Renouvellement</h3>
                            <p class="text-muted">Renouvelez votre carte professionnelle avant son expiration sans vous déplacer.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm hvr-grow">
                        <div class="card-body text-center p-4">
                            <div class="icon-container bg-primary-soft text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                                <i class="fas fa-search-location fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">Suivi de dossier</h3>
                            <p class="text-muted">Consultez en temps réel l'état d'avancement de votre demande.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Info Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="h5 mb-2">Vous avez des questions ?</h4>
                                    <p class="mb-md-0 text-muted">Consultez notre centre d'aide ou contactez le service des cartes professionnelles.</p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="#" class="btn btn-outline-primary">
                                        <i class="fas fa-info-circle me-2"></i> Centre d'aide
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endguest
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-uppercase mb-4">Ministère de la Formation Professionnelle et Technique</h5>
                <p>Plateforme officielle de gestion des cartes professionnelles du personnel du MFPT.</p>
                <div class="mt-4">
                    <a href="#" class="text-white me-3"><i class="fas fa-map-marker-alt me-2"></i> Adresse</a>
                    <a href="#" class="text-white"><i class="fas fa-phone me-2"></i> Contact</a>
                </div>
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-uppercase mb-4">Liens utiles</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-chevron-right me-2"></i> Site officiel du MFPT</a></li>
                    <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-chevron-right me-2"></i> Textes réglementaires</a></li>
                    <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-chevron-right me-2"></i> FAQ</a></li>
                    <li><a href="#" class="text-white"><i class="fas fa-chevron-right me-2"></i> Mentions légales</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h5 class="text-uppercase mb-4">Suivez-nous</h5>
                <div class="social-icons mb-4">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-whatsapp fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
                <div class="mb-3">
                    <a href="#" class="btn btn-outline-light btn-sm me-2">Espace presse</a>
                    <a href="#" class="btn btn-outline-light btn-sm">Recrutement</a>
                </div>
            </div>
        </div>

        <hr class="my-4 bg-light">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 small">&copy; 2025 Cellule Informatique du MFPT. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 small">Version 2.1.0</p>
            </div>
        </div>
    </div>
</footer>

<style>
    .welcome-hero {
        background: linear-gradient(135deg, #0c4b8e 0%, #1a73e8 100%);
        border-radius: 0 0 30px 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .bg-mfpt-gradient {
        background: linear-gradient(135deg, #0c4b8e 0%, #1a73e8 100%);
    }

    .bg-primary-soft {
        background-color: rgba(26, 115, 232, 0.1);
    }

    .bg-light-primary {
        background-color: rgba(26, 115, 232, 0.05);
    }

    .icon-container {
        transition: transform 0.3s ease;
    }

    .hvr-grow {
        transition: all 0.3s ease;
    }

    .hvr-grow:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .welcome-avatar {
        transition: transform 0.3s ease;
    }

    .welcome-avatar:hover {
        transform: scale(1.05);
    }

    .welcome-badge {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .mt-6 {
        margin-top: 5rem !important;
    }

    .z-index-1 {
        z-index: 1;
    }

    .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        background-color: rgba(255,255,255,0.2);
        transform: translateY(-3px);
    }

    footer {
        background: linear-gradient(135deg, #0a3a75 0%, #0c4b8e 100%);
    }

    footer a {
        text-decoration: none;
        transition: color 0.3s ease;
    }

    footer a:hover {
        color: #a0c4ff !important;
    }
</style>
@endsection
