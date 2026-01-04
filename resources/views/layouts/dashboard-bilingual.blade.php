<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Gym System') }}</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Vite Assets --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        :root {
            --bg-deep: #050505;
            --gold-primary: #FFD700;
            --gold-accent: #D4AF37;
            --text-main: #FFFFFF;
            --text-muted: #A3A3A3;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-blur: blur(20px);
            --sidebar-width: 280px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background-image: 
                linear-gradient(to bottom, rgba(5,5,5,0.92), rgba(5,5,5,0.96)),
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        [lang="ar"] body { font-family: 'Cairo', sans-serif; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 2rem 1.5rem;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
        }

        [dir="rtl"] .sidebar {
            left: auto;
            right: 0;
            border-right: none;
            border-left: 1px solid var(--glass-border);
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--gold-primary);
            text-transform: uppercase;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .nav-link.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-primary);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        [dir="rtl"] .main-content {
            margin-left: 0;
            margin-right: var(--sidebar-width);
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--glass-border);
        }

        .lang-btn {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--gold-accent);
            color: var(--gold-primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        /* Dashboard specific styles */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            padding: 1.5rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold-accent);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.2);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .stat-info span {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--gold-primary);
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Form & Logout */
        .logout-form {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--glass-border);
        }

        .btn-logout {
            width: 100%;
            background: rgba(255, 77, 77, 0.1);
            color: #ff4d4d;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: rgba(255, 77, 77, 0.2);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            [dir="rtl"] .sidebar {
                transform: translateX(100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                margin-right: 0 !important; /* Reset RTL margin */
            }
            
            .mobile-toggle {
                display: block; 
            }
        }
    </style>
</head>
<body>
    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-dumbbell"></i> GYM SYSTEM
        </div>
        
        <div class="nav-links">
            @yield('sidebar')
        </div>

        @php
            $logoutRoute = '#';
            if(auth('gym')->check()) $logoutRoute = route('gym.logout');
            elseif(auth('trainer')->check()) $logoutRoute = route('trainer.logout');
            elseif(auth('member')->check()) $logoutRoute = route('member.logout');
        @endphp

        <form action="{{ $logoutRoute }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> 
                <span data-en="Logout" data-ar="تسجيل الخروج">Logout</span>
            </button>
        </form>
    </nav>

    <main class="main-content">
        <div class="top-bar">
            {{-- Mobile Toggle could go here --}}
            <button class="lang-btn" id="lang-toggle-btn">
                <i class="fas fa-globe"></i>
                <span id="lang-text">العربية</span>
            </button>
        </div>

        @yield('content')
        
        @include('components.dev-footer')
    </main>

    <script src="{{ asset('js/bilingual.js') }}"></script>
</body>
</html>
