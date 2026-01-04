<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-en="@yield('title', 'Gym System')" data-ar="@yield('title-ar', 'نظام القاعة')">@yield('title', 'Gym System')</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Vite Assets --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        /* Modern Gym Theme - Based on welcome.blade.php */
        :root {
            --bg-deep: #050505;
            --gold-primary: #FFD700;
            --gold-accent: #D4AF37;
            --text-main: #FFFFFF;
            --text-muted: #A3A3A3;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-blur: blur(20px);
            --ease-elastic: cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                linear-gradient(to bottom, rgba(5,5,5,0.88), rgba(5,5,5,0.94)),
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        [lang="ar"] body { font-family: 'Cairo', sans-serif; }
        
        /* Language Toggle Button */
        .lang-toggle-fixed {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--gold-accent);
            color: var(--gold-primary);
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 700;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        
        [dir="rtl"] .lang-toggle-fixed {
            right: auto;
            left: 2rem;
        }
        
        .lang-toggle-fixed:hover {
            background: var(--gold-primary);
            color: #000;
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.4);
            transform: translateY(-2px);
        }
        
        /* Main Content Area */
        .main-wrapper {
            flex: 1;
            padding: 7rem 2rem 2rem;
        }
        
        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .page-title {
            font-size: 3rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
           background: linear-gradient(180deg, #FFD700 0%, #B8860B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
        }
        
        /* Content Container */
        .content-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .lang-toggle-fixed {
                top: 1rem;
                right: 1rem;
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
            
            [dir="rtl"] .lang-toggle-fixed {
                right: auto;
                left: 1rem;
            }
            
            .main-wrapper {
                padding: 5rem 1rem 1rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .glass-card {
                padding: 1.5rem;
            }
        }
        
        @yield('styles')
    </style>
</head>
<body>
    {{-- Language Toggle Button --}}
    <button class="lang-toggle-fixed" id="lang-toggle-btn">
        <i class="fas fa-globe"></i>
        <span id="lang-text">العربية</span>
    </button>

    {{-- Main Content --}}
    <main class="main-wrapper">
        @yield('content')
    </main>

    {{-- Developer Footer --}}
    @include('components.dev-footer')

    {{-- Bilingual JavaScript --}}
    <script src="{{ asset('js/bilingual.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
