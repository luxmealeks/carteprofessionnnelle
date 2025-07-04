<nav class="navbar navbar-expand-lg navbar-mfpt fixed-top">
    <div class="container-fluid px-3">
        <!-- Brand/Logo avec alignement parfait avec le sidebar -->
        <div class="d-flex align-items-center">
            <button class="sidebar-toggle btn btn-link text-white me-2 d-lg-none" aria-label="Toggle sidebar">
                <i class="bi bi-list" style="font-size: 1.5rem;"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('dashboard')); ?>">
                <div class="brand-icon bg-white bg-opacity-10 p-2 rounded me-2">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div>
                    <div class="brand-title text-white">MFPT Admin</div>
                    <div class="brand-subtitle small text-white opacity-75">Tableau de bord</div>
                </div>
            </a>
        </div>

        <!-- Mobile Toggle Button amélioré -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-three-dots-vertical text-white"></i>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Notification Bell -->
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link position-relative text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bell-fill"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-notifications p-0">
                        <li class="dropdown-header bg-light py-2 px-3">
                            <strong>Notifications</strong>
                        </li>
                        <li><hr class="dropdown-divider my-0"></li>
                        <!-- Notification items would go here -->
                    </ul>
                </li>

                <!-- User Dropdown amélioré -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center py-1 text-white"
                       href="#" role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="userDropdown">
                        <div class="avatar-container me-2">
                            <img src="<?php echo e(Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Admin').'&background=fff&color=0c4b8e'); ?>"
                                 class="rounded-circle"
                                 width="32"
                                 alt="Profile">
                        </div>
                        <div class="d-none d-lg-flex flex-column">
                            <span class="user-name"><?php echo e(Auth::user()->name ?? 'Admin'); ?></span>
                            <small class="user-role text-white opacity-75">Administrateur</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('profile.show')); ?>">
                                <i class="bi bi-person me-2"></i>
                                <span>Mon profil</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-gear me-2"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger"
                               href="<?php echo e(route('logout')); ?>"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               <i class="bi bi-box-arrow-right me-2"></i>
                               <span>Déconnexion</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Espacement après la navbar fixe -->
<div class="navbar-spacer" style="height: 72px;"></div>

<!-- Logout Form -->
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
    <?php echo csrf_field(); ?>
</form>

<style>
    /* Styles de base pour la navbar */
    .navbar-mfpt {
        background: linear-gradient(135deg, rgba(12, 75, 142, 0.98) 0%, rgba(26, 115, 232, 0.98) 100%);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        height: 72px;
    }

    /* Amélioration de la visibilité du texte */
    .navbar-mfpt .text-white {
        color: white !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand {
        padding: 0.5rem 0;
    }

    .brand-icon {
        transition: all 0.3s ease;
    }

    .brand-title {
        font-weight: 600;
        line-height: 1.2;
        font-size: 1.1rem;
    }

    .brand-subtitle {
        font-size: 0.75rem;
        line-height: 1;
    }

    .navbar-nav .nav-link {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown-menu {
        border: none;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        margin-top: 5px;
    }

    .dropdown-item {
        padding: 0.5rem 1.25rem;
        border-radius: 4px;
        margin: 0.15rem 0.5rem;
        width: auto;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(12, 75, 142, 0.08);
    }

    .dropdown-divider {
        border-color: rgba(0, 0, 0, 0.05);
    }

    .dropdown-notifications {
        min-width: 320px;
        max-height: 400px;
        overflow-y: auto;
    }

    .avatar-container {
        width: 32px;
        height: 32px;
    }

    .user-name {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .user-role {
        font-size: 0.75rem;
    }

    .sidebar-toggle {
        color: white;
        font-size: 1.25rem;
        padding: 0.25rem;
        margin-left: -0.5rem;
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: linear-gradient(135deg, rgba(12, 75, 142, 0.98) 0%, rgba(26, 115, 232, 0.98) 100%);
            padding: 0.5rem 1rem;
            margin-top: 0.5rem;
            border-radius: 8px;
        }

        .navbar-mfpt {
            height: auto;
        }

        .navbar-spacer {
            height: 56px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    document.querySelector('.sidebar-toggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('show');
    });

    // Ajustement dynamique de l'espacement si nécessaire
    const navbar = document.querySelector('.navbar-mfpt');
    const spacer = document.querySelector('.navbar-spacer');
    if (navbar && spacer) {
        spacer.style.height = navbar.offsetHeight + 'px';
    }
});
</script>
<?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/partials/navbar.blade.php ENDPATH**/ ?>