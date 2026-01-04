@extends('layouts.bilingual')

@section('title', 'Gym Owner Login')
@section('title-ar', 'تسجيل دخول مالك القاعة')

@section('styles')
<style>
    .auth-container {
        max-width: 480px;
        margin: 0 auto;
    }
    
    .auth-card {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        -webkit-backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        text-align: center;
    }
    
    .auth-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: rgba(255, 215, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--glass-border);
    }
    
    .auth-icon i {
        font-size: 2rem;
        color: var(--gold-primary);
    }
    
    .auth-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--gold-primary);
        text-transform: uppercase;
        letter-spacing: -0.5px;
    }
    
    .auth-subtitle {
        color: var(--text-muted);
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }
    
    .form-control {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--glass-border);
        color: #fff;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--gold-accent);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        background: rgba(0, 0, 0, 0.5);
    }
    
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        text-align: left;
    }
    
    [dir="rtl"] .form-group {
        text-align: right;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-muted);
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        justify-content: flex-start;
    }
    
    [dir="rtl"] .form-check {
        justify-content: flex-end;
    }
    
    .form-check input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .form-check label {
        cursor: pointer;
        font-size: 0.9rem;
        color: var(--text-muted);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--gold-primary), var(--gold-accent));
        border: none;
        color: #000;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
    }
    
    .btn-ghost {
        background: transparent;
        border: 1px solid var(--glass-border);
        color: var(--text-muted);
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
    }
    
    .btn-ghost:hover {
        border-color: var(--gold-accent);
        color: #fff;
    }
    
    .invalid-feedback {
        color: #ff4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        text-align: left;
    }
    
    [dir="rtl"] .invalid-feedback {
        text-align: right;
    }
    
    .is-invalid {
        border-color: #ff4444 !important;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-building"></i>
        </div>
        
        <h1 class="auth-title" data-en="Gym Owner" data-ar="مالك القاعة">Gym Owner</h1>
        <p class="auth-subtitle" data-en="Access your gym management dashboard" data-ar="الوصول إلى لوحة إدارة القاعة">
            Access your gym management dashboard
        </p>
        
        <form method="POST" action="{{ route('gym.login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label" data-en="Email Address" data-ar="البريد الإلكتروني">Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       data-en-placeholder="Enter your email"
                       data-ar-placeholder="أدخل بريدك الإلكتروني"
                       placeholder="Enter your email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label" data-en="Password" data-ar="كلمة المرور">Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required
                       data-en-placeholder="Enter your password"
                       data-ar-placeholder="أدخل كلمة المرور"
                       placeholder="Enter your password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" data-en="Remember me" data-ar="تذكرني">Remember me</label>
            </div>

            <button type="submit" class="btn-primary" data-en="Login" data-ar="تسجيل الدخول">Login</button>
            <a href="/" class="btn-ghost" data-en="Back to Home" data-ar="العودة للرئيسية">Back to Home</a>
        </form>
    </div>
</div>

<script>
    // Dynamic placeholder translation
    document.addEventListener('languageChanged', (e) => {
        const lang = e.detail.lang;
        document.querySelectorAll('[data-en-placeholder]').forEach(input => {
            const placeholder = input.getAttribute(`data-${lang}-placeholder`);
            if (placeholder) input.setAttribute('placeholder', placeholder);
        });
    });
    
    // Set initial placeholders
    const currentLang = document.documentElement.getAttribute('lang');
    document.querySelectorAll('[data-en-placeholder]').forEach(input => {
        const placeholder = input.getAttribute(`data-${currentLang}-placeholder`);
        if (placeholder) input.setAttribute('placeholder', placeholder);
    });
</script>
@endsection
