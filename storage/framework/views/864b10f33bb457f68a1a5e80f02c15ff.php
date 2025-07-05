<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MFPT Admin</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0c4b8e;
            --secondary-color: #1a73e8;
            --navbar-height: 72px;
            --mobile-navbar-height: 56px;
            --transition-speed: 0.3s;
        }

        /* Navbar Styles */
        .navbar-mfpt {
            background: #0c4b8e; /* Fond bleu uni */
            height: var(--navbar-height);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: height var(--transition-speed) ease;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        /* Branding */
        .navbar-brand {
            padding: 0.5rem 0;
            transition: all var(--transition-speed) ease;
        }

        .brand-icon {
            background: rgba(255, 255, 255, 0.1);
            transition: all var(--transition-speed) ease;
        }

        .brand-icon:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .brand-title {
            font-weight: 600;
            line-height: 1.2;
            font-size: 1.1rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .brand-subtitle {
            font-size: 0.75rem;
            line-height: 1;
            opacity: 0.75;
        }

        /* Navigation Items */
        .navbar-nav .nav-link {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            transition: all var(--transition-speed) ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link .badge {
            transition: transform var(--transition-speed) ease;
        }

        .nav-link:hover .badge {
            transform: scale(1.1);
        }

        /* Dropdowns */
        .dropdown-menu {
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            margin-top: 5px;
            animation: fadeIn var(--transition-speed) ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            padding: 0.5rem 1.25rem;
            border-radius: 4px;
            margin: 0.15rem 0.5rem;
            transition: all var(--transition-speed) ease;
        }

        .dropdown-item:hover {
            background-color: rgba(12, 75, 142, 0.08);
        }

        /* User Profile */
        .avatar-container {
            width: 32px;
            height: 32px;
            transition: all var(--transition-speed) ease;
        }

        .user-name {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.75;
        }

        /* Sidebar Toggle */
        .sidebar-toggle {
            color: white;
            font-size: 1.25rem;
            padding: 0.25rem;
            margin-left: -0.5rem;
            transition: all var(--transition-speed) ease;
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .navbar-mfpt {
                height: var(--mobile-navbar-height);
            }

            .navbar-collapse {
                background: #0c4b8e; /* Même fond bleu pour mobile */
                padding: 0.5rem 1rem;
                margin-top: 0.5rem;
                border-radius: 8px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .dropdown-menu {
                background-color: rgba(255, 255, 255, 0.95);
            }
        }

        /* Navbar Spacer */
        .navbar-spacer {
            height: var(--navbar-height);
            transition: height var(--transition-speed) ease;
        }

        @media (max-width: 991.98px) {
            .navbar-spacer {
                height: var(--mobile-navbar-height);
            }
        }

        /* Notification badge */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-mfpt fixed-top">
        <div class="container-fluid px-3">
            <!-- Brand/Logo with Sidebar Toggle -->
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle btn btn-link text-white me-2 d-lg-none" aria-label="Toggle sidebar" id="mobileSidebarToggle">
                    <i class="bi bi-list" style="font-size: 1.5rem;"></i>
                </button>
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <div class="brand-icon bg-white bg-opacity-10 p-2 rounded me-2">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <div class="brand-title text-white">MFPT Admin</div>
                        <div class="brand-subtitle text-white">Tableau de bord</div>
                    </div>
                </a>
            </div>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-three-dots-vertical text-white"></i>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Notification Bell with Counter -->
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link position-relative text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="notificationsDropdown">
                            <i class="bi bi-bell-fill"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger pulse">
                                3
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-notifications p-0" aria-labelledby="notificationsDropdown">
                            <li class="dropdown-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                                <strong>Notifications</strong>
                                <span class="badge bg-primary rounded-pill">3 non lues</span>
                            </li>
                            <li><hr class="dropdown-divider my-0"></li>
                            <!-- Notification Items -->
                            <li>
                                <a class="dropdown-item d-flex py-2 px-3" href="#">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bi bi-exclamation-circle text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Il y a 5 min</div>
                                        <span class="fw-semibold">Nouvelle demande de validation</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- User Dropdown with Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center py-1 text-white"
                           href="#" role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                           id="userDropdown">
                            <div class="avatar-container me-2">
                                <img src="https://ui-avatars.com/api/?name=Admin&background=fff&color=0c4b8e"
                                     class="rounded-circle"
                                     width="32"
                                     alt="Profile">
                            </div>
                            <div class="d-none d-lg-flex flex-column">
                                <span class="user-name">Admin</span>
                                <small class="user-role text-white">Administrateur</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
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
                                <a class="dropdown-item d-flex align-items-center text-danger" href="#">
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

    <!-- Navbar Spacer -->
    <div class="navbar-spacer"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dynamic navbar spacer height
        function updateNavbarSpacer() {
            const navbar = document.querySelector('.navbar-mfpt');
            const spacer = document.querySelector('.navbar-spacer');
            if (navbar && spacer) {
                spacer.style.height = navbar.offsetHeight + 'px';
            }
        }

        // Initialize
        updateNavbarSpacer();
        
        // Update on resize
        window.addEventListener('resize', updateNavbarSpacer);

        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('mobileSidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                console.log('Sidebar toggle clicked');
            });
        }
    });
    </script>
</body>
</html><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/partials/navbar.blade.php ENDPATH**/ ?>