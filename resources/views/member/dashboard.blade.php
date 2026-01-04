@extends('layouts.dashboard-bilingual')

@section('sidebar')
    <a class="nav-link active" href="{{ route('member.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> 
        <span data-en="Dashboard" data-ar="لوحة التحكم">Dashboard</span>
    </a>
    <a class="nav-link" href="{{ route('member.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> 
        <span data-en="Workouts" data-ar="التمارين">Workouts</span>
    </a>
    <a class="nav-link" href="{{ route('member.diets.index') }}">
        <i class="fas fa-utensils"></i> 
        <span data-en="Diet Plan" data-ar="النظام الغذائي">Diet Plan</span>
    </a>
    <a class="nav-link" href="{{ route('member.progress.index') }}">
        <i class="fas fa-chart-line"></i> 
        <span data-en="Progress" data-ar="التقدم">Progress</span>
    </a>
    <a class="nav-link" href="{{ route('member.notifications.index') }}">
        <i class="fas fa-bell"></i> 
        <span data-en="Notifications" data-ar="الإشعارات">Notifications</span>
        @if($unreadNotifications > 0)
        <span style="background: #ff4d4d; color: white; padding: 2px 6px; border-radius: 10px; font-size: 0.7rem; margin-left: auto;">{{ $unreadNotifications }}</span>
        @endif
    </a>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $workouts->flatten()->count() }}</h3>
                <span data-en="Workouts (Week)" data-ar="تمارين (أسبوعية)">Workouts (Week)</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-dumbbell"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $diets->flatten()->count() }}</h3>
                <span data-en="Meals (Week)" data-ar="وجبات (أسبوعية)">Meals (Week)</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-utensils"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $recentProgress->count() }}</h3>
                <span data-en="Progress Logs" data-ar="سجلات التقدم">Progress Logs</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>

        <div class="stat-card">
             @php
                $activeSubscription = $member->activeSubscription();
                $daysRemaining = $activeSubscription ? $activeSubscription->end_date->diffInDays(now()) : 0;
            @endphp
            <div class="stat-info">
                <h3>{{ $daysRemaining }}</h3>
                <span data-en="Days Left" data-ar="أيام متبقية">Days Left</span>
            </div>
            <div class="stat-icon" style="color: {{ $daysRemaining < 7 ? '#ff4d4d' : '#00cc66' }}">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-dumbbell" style="color: #D4AF37; margin-right: 0.5rem;"></i> 
                    <span data-en="Weekly Workouts" data-ar="تمارين الأسبوع">Weekly Workouts</span>
                </h4>
                <a href="{{ route('member.workouts.index') }}" style="color: #A3A3A3; font-size: 0.8rem; text-decoration: none;">
                    <span data-en="View All" data-ar="عرض الكل">View All</span> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($workouts->count() > 0)
                    @foreach($workouts as $day => $dayWorkouts)
                    <div style="margin-bottom: 1rem;">
                        <h6 style="color: #666; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($day)->translatedFormat('l') }}</h6>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @foreach($dayWorkouts as $workout)
                            <div style="background: rgba(255,255,255,0.05); padding: 0.75rem; border-radius: 4px; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong style="display: block; color: #fff;">{{ $workout->exercise_name }}</strong>
                                    @if($workout->notes) <small style="color: #666;">{{ $workout->notes }}</small> @endif
                                </div>
                                <div>
                                    <span style="background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; color: #ddd;">{{ $workout->sets }} x {{ $workout->reps }}</span>
                                    @if($workout->video_url)
                                    <a href="{{ $workout->video_url }}" target="_blank" style="color: #ff4d4d; margin-left: 0.5rem;"><i class="fab fa-youtube"></i></a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @else
                <div style="text-align: center; color: #666; padding: 2rem;">
                    <span data-en="No workouts assigned this week." data-ar="لا توجد تمارين مخصصة لهذا الأسبوع.">No workouts assigned this week.</span>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
             <div class="card-header">
                <h4>
                    <i class="fas fa-user" style="color: #D4AF37; margin-right: 0.5rem;"></i> 
                    <span data-en="Profile Status" data-ar="حالة الملف الشخصي">Profile Status</span>
                </h4>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                    <div style="background: rgba(255,255,255,0.02); padding: 0.8rem; border-radius: 8px;">
                        <small style="color: #666; display: block;" data-en="Name" data-ar="الاسم">Name</small>
                        <span style="font-weight: 600;">{{ $member->name }}</span>
                    </div>
                    <div style="background: rgba(255,255,255,0.02); padding: 0.8rem; border-radius: 8px;">
                        <small style="color: #666; display: block;" data-en="Code" data-ar="الكود">Code</small>
                        <span style="font-weight: 600; font-family: monospace;">{{ $member->member_code }}</span>
                    </div>
                     <div style="background: rgba(255,255,255,0.02); padding: 0.8rem; border-radius: 8px; grid-column: span 2;">
                        <small style="color: #666; display: block;" data-en="Trainer" data-ar="المدرب">Trainer</small>
                        <span style="font-weight: 600;">{{ $member->trainer->name ?? 'None' }}</span>
                    </div>
                </div>

                @if($activeSubscription)
                <div style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); padding: 1rem; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                         <span style="color: #00cc66; font-weight: 600;" data-en="Active Subscription" data-ar="اشتراك نشط">Active Subscription</span>
                         <span style="color: #fff;">{{ $activeSubscription->type }}</span>
                    </div>
                    <div style="margin-top: 0.5rem; font-size: 0.9rem; color: #aaa;">
                        <span data-en="Expires on" data-ar="ينتهي في">Expires on</span> {{ $activeSubscription->end_date->format('Y-m-d') }}
                    </div>
                </div>
                @else
                <div style="background: rgba(255, 77, 77, 0.1); border: 1px solid rgba(255, 77, 77, 0.2); padding: 1rem; border-radius: 8px; text-align: center; color: #ff4d4d;">
                    <span data-en="No Active Subscription" data-ar="لا يوجد اشتراك نشط">No Active Subscription</span>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
