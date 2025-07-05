<div class="sidebar-container">
    <!-- Logo et branding -->
    <div class="sidebar-brand text-center py-4">
        <div class="brand-icon bg-primary rounded-circle p-3 d-inline-block mb-2">
            <i class="bi bi-shield-lock text-white fs-4"></i>
        </div>
        <h5 class="brand-name text-dark mb-0">MFPT Admin</h5>
        <small class="text-muted">Gestion des agents</small>
    </div>

    <!-- Navigation principale -->
    <ul class="nav flex-column px-3">
        <!-- Section principale -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-3 {{ request()->routeIs('home') ? 'active' : '' }}"
               href="{{ route('home') }}">
                <div class="icon-container bg-primary bg-opacity-10 p-2 rounded me-3">
                    <i class="bi bi-speedometer2 text-primary"></i>
                </div>
                <span class="position-relative">
                    Tableau de bord
                    <span class="active-indicator"></span>
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center justify-content-between py-3 {{ request()->is('agents*') ? 'active' : '' }}"
               data-bs-toggle="collapse"
               href="#agentsMenu"
               role="button"
               aria-expanded="{{ request()->is('agents*') ? 'true' : 'false' }}"
               aria-controls="agentsMenu">
                <div class="d-flex align-items-center">
                    <div class="icon-container bg-primary bg-opacity-10 p-2 rounded me-3">
                        <i class="bi bi-people-fill text-primary"></i>
                    </div>
                    <span>Gestion des agents</span>
                </div>
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse {{ request()->is('agents*') ? 'show' : '' }}" id="agentsMenu">
                <ul class="nav flex-column ms-4">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->routeIs('agents.index') ? 'active' : '' }}"
                           href="{{ route('agents.index') }}">
                            <i class="bi bi-card-list me-2"></i> Liste des agents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->routeIs('agents.create') ? 'active' : '' }}"
                           href="{{ route('agents.create') }}">
                            <i class="bi bi-person-plus-fill me-2"></i> Nouvel agent
                        </a>
                    </li>
                   {{--  <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('agents/*/edit') ? 'active' : '' }}">
                            <i class="bi bi-pencil-square me-2"></i> Modifier un agent
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->routeIs('agents.carte') ? 'active' : '' }}">
                            <i class="bi bi-credit-card-2-front-fill me-2"></i> Générer carte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->routeIs('agents.verify') ? 'active' : '' }}">
                            <i class="bi bi-shield-check me-2"></i> Vérification carte
                        </a>
                    </li> --}}
                </ul>
            </div>
        </li>


     <!-- Menu déroulant : Gestion des photos -->
     <!-- Menu déroulant : Gestion des photos -->
<li class="nav-item">
    <a class="nav-link d-flex align-items-center justify-content-between py-3 {{ request()->is('photos*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#photosMenu"
       role="button"
       aria-expanded="{{ request()->is('photos*') ? 'true' : 'false' }}"
       aria-controls="photosMenu">
        <div class="d-flex align-items-center">
            <div class="icon-container bg-warning bg-opacity-10 p-2 rounded me-3">
                <i class="bi bi-camera-fill text-warning"></i>
            </div>
            <span>Gestion des photos</span>
        </div>
        @if(isset($pending_agents) && $pending_agents > 0)
            <span class="badge bg-warning rounded-pill">{{ $pending_agents }}</span>
        @endif
    </a>

    <div class="collapse {{ request()->is('photos*') ? 'show' : '' }}" id="photosMenu">
        <ul class="nav flex-column ms-4">
            <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('photos.index') ? 'active' : '' }}"
                   href="{{ route('photos.index') }}">
                    <i class="bi bi-clock-history me-2 text-warning"></i>
                    En attente
                    @if(isset($pending_agents) && $pending_agents > 0)
                        <span class="badge bg-warning rounded-pill ms-2">{{ $pending_agents }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('photos.validees') ? 'active' : '' }}"
                   href="{{ route('photos.validees') }}">
                    <i class="bi bi-check-circle-fill me-2 text-success"></i>
                    Validées
                    @if(isset($validated_agents) && $validated_agents > 0)
                        <span class="badge bg-success rounded-pill ms-2">{{ $validated_agents }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('photos.rejetees') ? 'active' : '' }}"
                   href="{{ route('photos.rejetees') }}">
                    <i class="bi bi-x-circle-fill me-2 text-danger"></i>
                    Rejetées
                    @if(isset($rejected_agents) && $rejected_agents > 0)
                        <span class="badge bg-danger rounded-pill ms-2">{{ $rejected_agents }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</li>


        <!-- Menu déroulant : Gestion des lots -->
<li class="nav-item">
    <a class="nav-link d-flex align-items-center justify-content-between py-3 {{ request()->is('lots*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#lotsMenu"
       role="button"
       aria-expanded="{{ request()->is('lots*') ? 'true' : 'false' }}"
       aria-controls="lotsMenu">
        <div class="d-flex align-items-center">
            <div class="icon-container bg-success bg-opacity-10 p-2 rounded me-3">
                <i class="bi bi-archive text-success"></i>
            </div>
            <span>Gestion des lots</span>
        </div>
        <i class="bi bi-chevron-down small text-muted"></i>
    </a>

    <div class="collapse {{ request()->is('lots*') ? 'show' : '' }}" id="lotsMenu">
        <ul class="nav flex-column ms-4">
            <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('lots.index') ? 'active' : '' }}"
                   href="{{ route('lots.index') }}">
                    <i class="bi bi-list-ul me-2 text-success"></i>
                    Liste des lots
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('lots.create') ? 'active' : '' }}"
                   href="{{ route('lots.create') }}">
                    <i class="bi bi-folder-plus me-2 text-success"></i>
                    Générer un lot
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('lots.generer') ? 'active' : '' }}"
                   href="{{ route('lots.generer') }}">
                    <i class="bi bi-lightning-charge me-2 text-success"></i>
                    Imprimer lot
                </a>
            </li>
           {{--  <a class="nav-link py-2 {{ request()->routeIs('lots.choisir') ? 'active' : '' }}"
                href="{{ route('lots.choisir') }}">
                <i class="bi bi-printer-fill me-2 text-success"></i>
                Imprimer des cartes
             </a> --}}

        </ul>
    </div>
</li>



<li class="nav-item">
    <a class="nav-link d-flex align-items-center justify-content-between py-3 {{ request()->is('ias*') || request()->is('iefs*') || request()->is('etablissements*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#localisationMenu"
       role="button"
       aria-expanded="{{ request()->is('ias*') || request()->is('iefs*') || request()->is('etablissements*') ? 'true' : 'false' }}"
       aria-controls="localisationMenu">
        <div class="d-flex align-items-center">
            <div class="icon-container bg-danger bg-opacity-10 p-2 rounded me-3">
                <i class="bi bi-geo-alt-fill text-danger"></i>
            </div>
            <span>Localisation</span>
        </div>
        <i class="bi bi-chevron-down small text-muted"></i>
    </a>

    <div class="collapse {{ request()->is('ias*') || request()->is('iefs*') || request()->is('etablissements*') ? 'show' : '' }}" id="localisationMenu">
        <ul class="nav flex-column ms-4">
            {{--<li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('ias.index') ? 'active' : '' }}" href="{{ route('ias.index') }}">
                    <i class="bi bi-diagram-3 me-2 text-danger"></i> Inspections académiques
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('iefs.index') ? 'active' : '' }}" href="{{ route('iefs.index') }}">
                    <i class="bi bi-diagram-3-fill me-2 text-danger"></i> IEF
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link py-2 {{ request()->routeIs('etablissements.index') ? 'active' : '' }}" href="{{ route('etablissements.index') }}">
                    <i class="bi bi-building me-2 text-danger"></i> Établissements
                </a>
            </li>
        </ul>
    </div>
</li>


    {{--     <!-- Section administration -->
        <li class="nav-item mt-4">
            <div class="section-label text-uppercase small text-muted px-3 mb-2 d-flex align-items-center">
                <i class="bi bi-gear-fill me-2"></i>
                <span>Administration</span>
            </div>
        </li>

        <a class="nav-link d-flex align-items-center py-3 {{ request()->routeIs('settings.*') ? 'active' : '' }}"
            href="{{ route('settings.index') }}">
             <div class="icon-container bg-secondary bg-opacity-10 p-2 rounded me-3">
                 <i class="bi bi-sliders text-secondary"></i>
             </div>
             <span>Paramètres</span>
         </a>


        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-3 {{ request()->is('security*') ? 'active' : '' }}"
               href="#">
                <div class="icon-container bg-dark bg-opacity-10 p-2 rounded me-3">
                    <i class="bi bi-shield-lock text-dark"></i>
                </div>
                <span>Sécurité</span>
            </a>
        </li>
    </ul> --}}

    <!-- User profile & logout -->
    {{-- <div class="sidebar-footer px-3 py-4">
        <div class="d-flex align-items-center">
            <div class="user-avatar me-3">
                <img src="https://ui-avatars.com/api/?name=Admin&background=0c4b8e&color=fff"
                     class="rounded-circle"
                     width="40"
                     alt="Admin">
            </div>
            <div class="user-info">
                <h6 class="mb-0">Administrateur</h6>
                <small class="text-muted">Super Admin</small>
            </div>
            <a href="{{ route('logout') }}"
               class="logout-btn ms-auto"
               title="Déconnexion"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right text-muted"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div> --}}
</div>

<style>
    .sidebar-container {
        height: 100vh;
        background: white;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }

    .sidebar-brand {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .brand-icon {
        transition: all 0.3s ease;
    }

    .nav-link {
        color: #495057;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        background-color: rgba(12, 75, 142, 0.05);
        transform: translateX(3px);
    }

    .nav-link.active {
        background-color: rgba(12, 75, 142, 0.1);
        color: #0c4b8e;
        font-weight: 500;
    }

    .nav-link.active .icon-container {
        background-color: rgba(12, 75, 142, 0.2) !important;
    }

    .active-indicator {
        position: absolute;
        left: -20px;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background: #0c4b8e;
        border-radius: 0 4px 4px 0;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .nav-link.active .active-indicator {
        opacity: 1;
    }

    .section-label {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .sidebar-footer {
        margin-top: auto;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .logout-btn {
        opacity: 0.5;
        transition: opacity 0.3s;
    }

    .logout-btn:hover {
        opacity: 1;
        color: #dc3545 !important;
    }

    .badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.4rem;
    }
</style>
