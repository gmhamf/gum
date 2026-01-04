<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-en="Gym Management System" data-ar="نظام إدارة القاعات الرياضية">Gym Management System</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif

    <style>
        /* -----------------------------------------------------------
           1. MODERN GYM THEME CONFIGURATION
        ----------------------------------------------------------- */
        :root {
            /* Colors: Deep Black & Neon Gold */
            --bg-deep: #050505;
            --gold-primary: #FFD700;       /* Brighter Gold */
            --gold-accent: #D4AF37;        /* Classic Gold */
            --text-main: #FFFFFF;
            --text-muted: #A3A3A3;
            
            /* Glassmorphism Variables */
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-blur: blur(20px);
            
            /* Transitions */
            --ease-elastic: cubic-bezier(0.34, 1.56, 0.64, 1); /* Bouncy effect */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            /* Background Image Setup */
            background-image: 
                linear-gradient(to bottom, rgba(5,5,5,0.8), rgba(5,5,5,0.95)),
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        [lang="ar"] body { font-family: 'Cairo', sans-serif; }
        a { text-decoration: none; color: inherit; transition: all 0.3s ease; }

        /* -----------------------------------------------------------
           2. HEADER & LANGUAGE TOGGLE
        ----------------------------------------------------------- */
        .nav-header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 2rem;
            display: flex;
            justify-content: flex-end;
            z-index: 100;
        }

        [dir="rtl"] .nav-header { justify-content: flex-end; }

        .lang-btn {
            background: rgba(0, 0, 0, 0.6);
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
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .lang-btn:hover {
            background: var(--gold-primary);
            color: #000;
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.4);
            transform: translateY(-2px);
        }

        /* -----------------------------------------------------------
           3. HERO SECTION (Dynamic & Bold)
        ----------------------------------------------------------- */
        .hero-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8rem 2rem 5rem;
            text-align: center;
        }

        .hero-content {
            max-width: 900px;
            margin-bottom: 5rem;
            position: relative;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 900;
            line-height: 1;
            text-transform: uppercase;
            letter-spacing: -2px;
            margin-bottom: 1.5rem;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .hero-title span {
            display: block;
        }

        .hero-title .highlight {
            color: transparent;
            -webkit-text-stroke: 1px rgba(255,255,255,0.3); /* Outline text effect */
        }

        .hero-title .gold-text {
            color: var(--gold-primary);
            background: linear-gradient(180deg, #FFD700 0%, #B8860B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 20px rgba(212, 175, 55, 0.3));
        }

        .hero-subtitle {
            color: var(--text-muted);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 400;
            border-left: 3px solid var(--gold-accent);
            padding-left: 1.5rem;
            text-align: left;
        }

        [dir="rtl"] .hero-subtitle {
            border-left: none;
            border-right: 3px solid var(--gold-accent);
            padding-left: 0;
            padding-right: 1.5rem;
            text-align: right;
        }

        /* -----------------------------------------------------------
           4. GLASS CARDS (The Modern Gym Look)
        ----------------------------------------------------------- */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            width: 100%;
            max-width: 1200px;
            perspective: 1000px; /* For 3D effect */
        }

        .role-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            padding: 3.5rem 2rem;
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.4s var(--ease-elastic);
            group: role;
        }

        /* Hover Effect: The "Lift" */
        .role-card:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: var(--gold-accent);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        /* Inner Glow Circle */
        .role-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, transparent 60%);
            opacity: 0;
            transition: 0.5s;
            transform: scale(0.5);
        }

        .role-card:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(0,0,0,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            border: 1px solid var(--glass-border);
            transition: 0.4s;
        }

        .role-card:hover .icon-box {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
            transform: rotateY(180deg);
        }

        .role-card i {
            font-size: 2rem;
            color: var(--text-main);
            transition: 0.4s;
        }

        .role-card:hover i {
            color: #000;
            transform: rotateY(-180deg); /* Counter rotation to keep icon upright */
        }

        .role-card h3 {
            font-size: 1.5rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .role-card p {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* -----------------------------------------------------------
           5. FOOTER
        ----------------------------------------------------------- */
        .app-footer {
            padding: 2rem;
            margin-top: auto;
            text-align: center;
            border-top: 1px solid var(--glass-border);
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(10px);
        }

        .dev-badge {
            display: inline-flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .dev-label {
            font-size: 0.7rem;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .dev-details {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem 1.5rem;
            background: rgba(255,255,255,0.05);
            border-radius: 50px;
            border: 1px solid var(--glass-border);
            transition: 0.3s;
        }

        .dev-details:hover {
            border-color: var(--gold-accent);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }

        .social-link {
            color: var(--gold-primary);
            font-size: 1.2rem;
        }

        .social-link:hover { color: #fff; transform: scale(1.2); }

        /* -----------------------------------------------------------
           6. RESPONSIVE
        ----------------------------------------------------------- */
        @media (max-width: 992px) {
            .hero-title { font-size: 3rem; }
            .roles-grid { grid-template-columns: 1fr; max-width: 400px; }
            .hero-subtitle { text-align: center; border: none; padding: 0; }
            [dir="rtl"] .hero-subtitle { text-align: center; border: none; }
        }
    </style>
</head>
<body>

    <nav class="nav-header">
        <button class="lang-btn" onclick="toggleLanguage()">
            <i class="fas fa-globe"></i>
            <span id="lang-text">العربية</span>
        </button>
    </nav>

    <section class="hero-section">
        
        <div class="hero-content">
            <h1 class="hero-title">
                <span class="highlight" data-en="Professional" data-ar="نظام إدارة">Professional</span> 
                <span class="gold-text" data-en="Gym System" data-ar="القاعات الرياضية">Gym System</span>
            </h1>
            <p class="hero-subtitle" 
               data-en="Streamline operations, track progress, and dominate your fitness business."
               data-ar="تحكم كامل في القاعة، متابعة دقيقة للاعبين، وإدارة اشتراكات احترافية.">
               Streamline operations, track progress, and dominate your fitness business.
            </p>
        </div>

        <div class="roles-grid">
            
            <a href="{{ route('gym.login') }}" class="role-card">
                <div class="icon-box"><i class="fas fa-building"></i></div>
                <h3 data-en="Owner" data-ar="المالك">Owner</h3>
                <p data-en="Admin Dashboard" data-ar="لوحة التحكم">Admin Dashboard</p>
            </a>

            <a href="{{ route('trainer.login') }}" class="role-card">
                <div class="icon-box"><i class="fas fa-stopwatch"></i></div>
                <h3 data-en="Trainer" data-ar="المدرب">Trainer</h3>
                <p data-en="Client Manager" data-ar="إدارة اللاعبين">Client Manager</p>
            </a>

            <a href="{{ route('member.login') }}" class="role-card">
                <div class="icon-box"><i class="fas fa-dumbbell"></i></div>
                <h3 data-en="Member" data-ar="اللاعب">Member</h3>
                <p data-en="Workout Tracker" data-ar="متابعة التمارين">Workout Tracker</p>
            </a>

        </div>

    </section>

    <footer class="app-footer">
        <div class="dev-badge">
            <span class="dev-label" data-en="Designed & Developed By" data-ar="تصميم وتطوير">Designed & Developed By</span>
            <div class="dev-details">
                <span class="dev-name" data-en="Mohammed Sadeq Zuhair" data-ar="محمد صادق زهير">Mohammed Sadeq Zuhair</span>
                <div style="width:1px; height:15px; background:var(--glass-border);"></div>
                <a href="https://instagram.com/0_9vz" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/in/mohammed-sadeq-zuhair-sadeq-1aa6112b7/" target="_blank" class="social-link"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script>
        const LANG_STORAGE_KEY = 'gym_lang_pref';
        
        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem(LANG_STORAGE_KEY) || 'en';
            applyLanguage(savedLang);
        });

        function toggleLanguage() {
            const currentLang = document.documentElement.getAttribute('lang');
            const newLang = currentLang === 'en' ? 'ar' : 'en';
            applyLanguage(newLang);
        }

        function applyLanguage(lang) {
            document.documentElement.setAttribute('lang', lang);
            document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
            document.querySelectorAll('[data-en]').forEach(el => {
                const text = el.getAttribute(`data-${lang}`);
                if (text) el.innerHTML = text; // Changed to innerHTML to support spans if needed
            });
            const btnText = document.getElementById('lang-text');
            if (btnText) btnText.textContent = lang === 'en' ? 'العربية' : 'English';
            localStorage.setItem(LANG_STORAGE_KEY, lang);
        }
    </script>
</body>
</html>