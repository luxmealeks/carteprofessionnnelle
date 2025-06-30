<div class="col-md-2 p-0 sidebar d-none d-md-block">
    <div class="p-3 h-100 d-flex flex-column">
        <div class="sidebar-header mb-3 text-center">
            <img src="{{ asset('images/mfpt-logo.png') }}" alt="Logo MFPT" class="img-fluid mb-2" style="max-height: 40px;">
            <h6 class="text-muted">Administration</h6>
        </div>

        <ul class="nav flex-column flex-grow-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Tableau de bord</span>
                    <span class="badge bg-primary float-end">3</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('agents.*') ? 'active' : '' }}" href="{{ route('agents.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Agents</span>
                    @isset($pending_agents)
                        <span class="badge bg-danger float-end">{{ $pending_agents }}</span>
                    @endisset
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('photos.*') ? 'active' : '' }}" href="{{ route('photos.index') }}">
                    <i class="bi bi-camera-fill"></i>
                    <span>Photos</span>
                    @isset($pending_photos)
                        <span class="badge bg-warning float-end">{{ $pending_photos }}</span>
                    @endisset
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('lots.*') ? 'active' : '' }}" href="{{ route('lots.generer') }}">
                    <i class="bi bi-collection-fill"></i>
                    <span>Lots</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ias.*') ? 'active' : '' }}" href="{{ route('ias.create') }}">
                    <i class="bi bi-robot"></i>
                    <span>IA</span>
                </a>
            </li>

            <div class="mt-auto">
                <li class="nav-item mt-3">
                    <div class="nav-link text-muted small text-uppercase">
                        <i class="bi bi-gear-fill"></i> Administration
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-sliders"></i>
                        <span>Paramètres</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-shield-lock"></i>
                        <span>Sécurité</span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <div class="px-3 py-2 small text-muted">
                        <div>Version 1.2.0</div>
                        <div class="text-truncate">
                            @auth
                                Connecté en tant que {{ Auth::user()->name }}
                            @else
                                Visiteur non connecté
                            @endauth
                        </div>
                    </div>
                </li>
            </div>
        </ul>
    </div>
</div>

<style>
    :root {
        --mfpt-primary: #0c4b8e;
        --mfpt-secondary: #1a73e8;
        --sidebar-width: 250px;
    }

    .sidebar {
        background: linear-gradient(to bottom, #ffffff, #f8fafc);
        width: var(--sidebar-width);
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .sidebar .nav-link {
        color: #4a5568;
        border-radius: 6px;
        margin-bottom: 4px;
        padding: 10px 15px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        transition: all 0.2s ease;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(12, 75, 142, 0.08);
        color: var(--mfpt-primary);
        transform: translateX(3px);
    }

    .sidebar .nav-link.active {
        background-color: rgba(12, 75, 142, 0.1);
        color: var(--mfpt-primary);
        font-weight: 500;
    }

    .sidebar .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--mfpt-primary);
        border-radius: 0 3px 3px 0;
    }

    .sidebar .nav-link i {
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    .sidebar .badge {
        font-size: 0.65rem;
        padding: 3px 6px;
        margin-top: 2px;
    }

    .sidebar-header {
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
            position: fixed;
            z-index: 1000;
            top: 56px;
            bottom: 0;
        }

        .sidebar.show {
            transform: translateX(0);
        }
    }
</style>
