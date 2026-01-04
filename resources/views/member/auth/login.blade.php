@extends('layouts.bilingual')

@section('title', 'Member Login')
@section('title-ar', 'تسجيل دخول اللاعب')

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
    
    /* Select specific styling */
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23D4AF37' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }
    
    [dir="rtl"] select.form-control {
        background-position: left 1rem center;
        padding-right: 1.25rem;
        padding-left: 2.5rem;
    }
    
    .form-control option {
        background: #1a1a1a;
        color: #fff;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--gold-accent);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        background-color: rgba(0, 0, 0, 0.5);
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
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-dumbbell"></i>
        </div>
        
        <h1 class="auth-title" data-en="Member" data-ar="اللاعب">Member</h1>
        <p class="auth-subtitle" data-en="Track your progress and workouts" data-ar="تابع تمارينك وتقدمك">
            Track your progress and workouts
        </p>
        
        <form method="POST" action="{{ route('member.login') }}">
            @csrf

            <!-- Gym Selection -->
            <div class="form-group">
                <label for="gym_id" class="form-label" data-en="Select Gym" data-ar="اختر القاعة">Select Gym</label>
                <select class="form-control @error('gym_id') is-invalid @enderror" id="gym_id" name="gym_id" required>
                    <option value="" data-en="Choose your gym..." data-ar="اختر القاعة...">Choose your gym...</option>
                    @foreach($gyms as $gym)
                        <option value="{{ $gym->id }}" {{ old('gym_id') == $gym->id ? 'selected' : '' }}>{{ $gym->name }}</option>
                    @endforeach
                </select>
                @error('gym_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="member_code" class="form-label" data-en="Member Code" data-ar="كود اللاعب">Member Code</label>
                <input type="text" 
                       class="form-control @error('member_code') is-invalid @enderror" 
                       id="member_code" 
                       name="member_code" 
                       value="{{ old('member_code') }}" 
                       required 
                       autofocus 
                       data-en-placeholder="Enter your member code"
                       data-ar-placeholder="أدخل كود اللاعب"
                       placeholder="Enter your member code">
                @error('member_code')
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
    document.addEventListener('languageChanged', (e) => {
        const lang = e.detail.lang;
        
        // Update placeholders
        document.querySelectorAll('[data-en-placeholder]').forEach(input => {
            const placeholder = input.getAttribute(`data-${lang}-placeholder`);
            if (placeholder) input.setAttribute('placeholder', placeholder);
        });
        
        // Update select options (manual handling for dropdowns)
        document.querySelectorAll('option[data-en]').forEach(opt => {
            const text = opt.getAttribute(`data-${lang}`);
            if (text) opt.textContent = text;
        });
    });
    
    // Initial load
    const currentLang = document.documentElement.getAttribute('lang') || 'en';
    document.querySelectorAll('[data-en-placeholder]').forEach(input => {
        const placeholder = input.getAttribute(`data-${currentLang}-placeholder`);
        if (placeholder) input.setAttribute('placeholder', placeholder);
    });
    document.querySelectorAll('option[data-en]').forEach(opt => {
            const text = opt.getAttribute(`data-${currentLang}`);
            if (text) opt.textContent = text;
    });
</script>
@endsection
