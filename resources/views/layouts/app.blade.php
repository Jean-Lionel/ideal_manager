<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Finances Manager') }} - @yield('title', 'Tableau de bord')</title>

    <!-- Bootstrap CSS 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: #e7f1ff;
            color: #0d6efd;
            border-left-color: #0d6efd;
            font-weight: 500;
        }

        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        /* Header Styles */
        .top-header {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #dee2e6;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .main-content {
            min-height: calc(100vh - 60px);
        }

        /* Mobile Sidebar */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1045;
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Cards and components */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.75rem;
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
        }

        /* Dropdown customization */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-lg-2 col-xl-2 px-0 sidebar bg-white" id="sidebar">
                <!-- Brand -->
                <div class="sidebar-brand">
                    <i class="bi bi-graph-up me-2"></i>
                    Finances Manager
                </div>

                <!-- Navigation Menu -->
                <div class="px-3 pt-4">
                    <ul class="nav nav-pills flex-column">
                        <!-- Tableau de bord -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                               href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i>
                                Tableau de bord
                            </a>
                        </li>

                        <!-- Entrées -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('entrees.*') ? 'active' : '' }}"
                               href="{{ route('entrees.index') }}">
                                <i class="bi bi-plus-circle text-success"></i>
                                Entrées
                            </a>
                        </li>

                        <!-- Sorties -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sorties.*') ? 'active' : '' }}"
                               href="{{ route('sorties.index') }}">
                                <i class="bi bi-dash-circle text-danger"></i>
                                Sorties
                            </a>
                        </li>

                        <!-- Versements -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('versements.*') ? 'active' : '' }}"
                               href="{{ route('versements.index') }}">
                                <i class="bi bi-arrow-left-right text-purple"></i>
                                Versements
                            </a>
                        </li>

                        <!-- Paiements -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('paiements.*') ? 'active' : '' }}"
                               href="{{ route('paiements.index') }}">
                                <i class="bi bi-credit-card text-warning"></i>
                                Paiements
                            </a>
                        </li>

                        <!-- Catégories -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                               href="{{ route('categories.index') }}">
                                <i class="bi bi-tags text-info"></i>
                                Catégories
                            </a>
                        </li>

                        <!-- Utilisateurs (Admin uniquement) -->
                        @if(auth()->user() && auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}">
                                <i class="bi bi-people text-secondary"></i>
                                Utilisateurs
                            </a>
                        </li>
                        @endif
                    </ul>

                    <!-- Section Paramètres -->
                    <hr class="mt-4">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                               href="{{ route('profile.edit') }}">
                                <i class="bi bi-gear"></i>
                                Paramètres
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenu principal -->
            <main class="col-lg-2 col-xl-10 ms-auto">
                <!-- Header/Topbar -->
                <header class="top-header py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Bouton menu mobile et titre -->
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-secondary d-lg-none me-3"
                                    type="button"
                                    id="sidebarToggle">
                                <i class="bi bi-list"></i>
                            </button>
                            <h1 class="h3 mb-0 text-gray-800">
                                @yield('page-title', 'Tableau de bord')
                            </h1>
                        </div>

                        <!-- Section utilisateur -->
                        <div class="d-flex align-items-center">
                            <!-- Notifications (optionnel) -->
                            <div class="me-3">
                                <button class="btn btn-outline-secondary position-relative">
                                    <i class="bi bi-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">
                                        3
                                    </span>
                                </button>
                            </div>

                            <!-- Dropdown utilisateur -->
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none d-flex align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <div class="user-avatar me-2">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="d-none d-md-block text-start">
                                        <div class="fw-semibold text-dark">{{ auth()->user()->name }}</div>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
                                    </div>
                                    <i class="bi bi-chevron-down ms-2 text-muted"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person me-2"></i>
                                            Mon Profil
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>
                                                Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Messages Flash -->
                <div class="px-4 pt-3">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Erreurs détectées :</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>

                <!-- Contenu de la page -->
                <div class="main-content p-4">
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="footer py-3 px-4 mt-auto">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>© {{ date('Y') }} <a href="https://advanceditb.com/">Advanced IT And Research Burundi </a>
                                . Tous droits réservés.</small>
                        </div>
                        <div>
                            <small class="text-muted">Version 1.0</small>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Initialisation des composants Bootstrap -->
    <script>
        // Initialisation des tooltips et popovers
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar pour mobile
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }

            // Fermer la sidebar quand on clique sur un lien (mobile)
            const sidebarLinks = sidebar.querySelectorAll('.nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        toggleSidebar();
                    }
                });
            });

            // Auto-hide alerts après 5 secondes
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
