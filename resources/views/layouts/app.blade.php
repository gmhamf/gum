<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - نظام إدارة القاعات الرياضية</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts - Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-black: #0a0a0a;
            --dark-bg: #1a1a1a;
            --card-bg: #2d2d2d;
            --gold: #D4AF37;
            --dark-gold: #B8860B;
            --light-gold: #F4D03F;
            --text-light: #f8f9fa;
            --text-muted: #adb5bd;
            --border-color: #444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--primary-black) 0%, var(--dark-bg) 100%);
            color: var(--text-light);
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Navbar Styles */
        .navbar-main {
            background: rgba(10, 10, 10, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 2px solid var(--gold);
            padding: 0.8rem 0;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--gold), var(--light-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(180deg, var(--dark-bg) 0%, rgba(45, 45, 45, 0.95) 100%);
            min-height: calc(100vh - 70px);
            border-left: 1px solid var(--border-color);
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 70px;
        }

        .nav-link {
            color: var(--text-muted);
            padding: 1rem 1.5rem;
            margin: 0.2rem 0.5rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            right: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.1), transparent);
            transition: right 0.6s ease;
        }

        .nav-link:hover {
            color: var(--gold);
            background: rgba(212, 175, 55, 0.08);
            transform: translateX(-5px);
        }

        .nav-link:hover::before {
            right: 100%;
        }

        .nav-link.active {
            color: var(--gold);
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(184, 134, 11, 0.1));
            border-right: 3px solid var(--gold);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        }

        .nav-link i {
            width: 20px;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.2);
        }

        /* Main Content */
        .main-content {
            background: transparent;
            min-height: calc(100vh - 70px);
            padding: 2rem 0;
        }

        /* Card Styles */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.15);
            border-color: var(--gold);
        }

        .card-header {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(184, 134, 11, 0.05));
            border-bottom: 1px solid var(--border-color);
            border-radius: 16px 16px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        /* Button Styles */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--dark-gold));
            border: none;
            color: #000;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
            color: #000;
        }

        .btn-gold:hover::before {
            left: 100%;
        }

        .btn-outline-gold {
            border: 2px solid var(--gold);
            color: var(--gold);
            background: transparent;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-outline-gold:hover {
            background: var(--gold);
            color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        /* Table Styles */
        .table {
            color: var(--text-light);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-dark {
            background: var(--card-bg);
        }

        .table-hover tbody tr:hover {
            background: rgba(212, 175, 55, 0.1);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Badge Styles */
        .badge {
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        /* Form Styles */
        .form-control {
            background: rgba(45, 45, 45, 0.8);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(45, 45, 45, 0.9);
            border-color: var(--gold);
            color: var(--text-light);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        /* Text Colors */
        .text-gold {
            color: var(--gold) !important;
            background: linear-gradient(135deg, var(--gold), var(--light-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gold {
            background: linear-gradient(135deg, var(--gold), var(--dark-gold)) !important;
        }

        .border-gold {
            border-color: var(--gold) !important;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--light-gold);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                position: static;
            }

            .main-content {
                padding: 1rem 0;
            }

            .nav-link {
                padding: 0.75rem 1rem;
                margin: 0.1rem 0.25rem;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logout Button */
        .btn-logout {
            background: transparent;
            border: 2px solid #dc3545;
            color: #dc3545;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    @if(!request()->routeIs(['gym.login', 'trainer.login', 'member.login', 'welcome']))
    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('gym.dashboard') }}">
                <i class="fas fa-dumbbell me-2"></i>
                نظام الجيم
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars text-gold"></i>
                </span>
            </button>

            <!-- Navbar Items -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>
                            {{ Auth::guard('gym')->user()->name ?? 'المستخدم' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('gym.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('gym.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>تسجيل خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar d-md-block">
                <div class="position-sticky pt-4">
                    @yield('sidebar')
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 main-content">
                <div class="container-fluid fade-in">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @else
        <!-- Authentication Pages -->
        <div class="auth-wrapper">
            @yield('auth-content')
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Add fade-in animation to all cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('fade-in');
            });

            // Add active class to current page link
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

@yield('scripts')
</body>
</html>
