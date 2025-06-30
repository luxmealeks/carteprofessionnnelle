<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/mfpt-logo-white.png') }}" alt="Logo" height="40" class="me-2">
            <span>MFPT - Cartes Professionnelles</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Paramétrage
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                            <li><a class="dropdown-item" href="{{ route('etablissements.index') }}">Établissements</a></li>
                            <li><a class="dropdown-item" href="{{ route('inspection-academiques.index') }}">Inspections académiques</a></li>
                            <li><a class="dropdown-item" href="{{ route('directions.index') }}">Directions</a></li>
                            <li><a class="dropdown-item" href="{{ route('corps.index') }}">Corps</a></li>
                            <li><a class="dropdown-item" href="{{ route('grades.index') }}">Grades</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="border: none;">
                                <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Connexion
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
