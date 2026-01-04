@extends('layouts.dashboard-bilingual')

@section('sidebar')
    <a class="nav-link active" href="{{ route('trainer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> 
        <span data-en="Dashboard" data-ar="لوحة التحكم">Dashboard</span>
    </a>
    <a class="nav-link" href="{{ route('trainer.members.index') }}">
        <i class="fas fa-user-friends"></i> 
        <span data-en="Members" data-ar="الأعضاء">Members</span>
    </a>
    <a class="nav-link" href="{{ route('trainer.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> 
        <span data-en="Workouts" data-ar="التمارين">Workouts</span>
    </a>
    <a class="nav-link" href="{{ route('trainer.diets.index') }}">
        <i class="fas fa-utensils"></i> 
        <span data-en="Diet Plans" data-ar="الأنظمة الغذائية">Diet Plans</span>
    </a>
    <a class="nav-link" href="{{ route('trainer.notifications.index') }}">
        <i class="fas fa-bell"></i> 
        <span data-en="Notifications" data-ar="الإشعارات">Notifications</span>
    </a>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['total_members'] }}</h3>
                <span data-en="Total Members" data-ar="إجمالي الأعضاء">Total Members</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['active_members'] }}</h3>
                <span data-en="Active" data-ar="نشط">Active</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['total_workouts'] }}</h3>
                <span data-en="Workouts" data-ar="التمارين">Workouts</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-dumbbell"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['weekly_workouts'] }}</h3>
                <span data-en="This Week" data-ar="هذا الأسبوع">This Week</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar"></i>
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
                <a href="{{ route('trainer.workouts.index') }}" style="color: #A3A3A3; font-size: 0.8rem; text-decoration: none;">
                    <span data-en="View All" data-ar="عرض الكل">View All</span> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($workouts->count() > 0)
                    @foreach($workouts as $day => $dayWorkouts)
                    <div style="margin-bottom: 1.5rem;">
                        <h6 style="color: #D4AF37; margin-bottom: 0.5rem; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($day)->translatedFormat('l - Y/m/d') }}</h6>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @foreach($dayWorkouts as $workout)
                            <div style="background: rgba(255,255,255,0.05); padding: 0.75rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong style="display: block; color: #fff;">{{ $workout->exercise_name }}</strong>
                                    <small style="color: #666;"><span data-en="For:" data-ar="للاعب:">For:</span> {{ $workout->member->name }}</small>
                                </div>
                                <span style="background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; color: #ddd;">{{ $workout->sets }} x {{ $workout->reps }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @else
                <div style="text-align: center; color: #666; padding: 2rem;">
                    <i class="fas fa-dumbbell" style="font-size: 2rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                    <span data-en="No workouts this week." data-ar="لا توجد تمارين هذا الأسبوع.">No workouts this week.</span>
                    <br>
                    <a href="{{ route('trainer.workouts.create') }}" style="color: #D4AF37; margin-top: 1rem; display: inline-block; text-decoration: none;">
                        <i class="fas fa-plus"></i> <span data-en="Add New Workout" data-ar="إضافة تمرين جديد">Add New Workout</span>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-user-friends" style="color: #D4AF37; margin-right: 0.5rem;"></i> 
                    <span data-en="Recent Members" data-ar="مشتركين جدد">Recent Members</span>
                </h4>
                <a href="{{ route('trainer.members.index') }}" style="color: #A3A3A3; font-size: 0.8rem; text-decoration: none;">
                    <span data-en="View All" data-ar="عرض الكل">View All</span> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recentMembers->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @foreach($recentMembers as $member)
                    <a href="{{ route('trainer.members.show', $member->id) }}" style="display: flex; justify-content: space-between; padding: 0.75rem; background: rgba(255,255,255,0.02); border-radius: 8px; text-decoration: none; color: inherit; align-items: center; transition: background 0.2s;">
                        <div style="display: flex; align-items: center; gap: 0.8rem;">
                            <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">{{ substr($member->name, 0, 1) }}</div>
                            <div>
                                <h6 style="margin: 0; font-size: 0.95rem;">{{ $member->name }}</h6>
                                <small style="color: #666;">{{ $member->member_code }}</small>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="color: {{ $member->status ? '#00cc66' : '#ff4d4d' }}; font-size: 0.75rem; font-weight: 600;">{{ $member->status ? 'Active' : 'Inactive' }}</span>
                            <br>
                            <small style="color: #666; font-size: 0.75rem;">{{ $member->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div style="text-align: center; color: #666; padding: 2rem;">
                     <span data-en="No members yet." data-ar="لا يوجد أعضاء حتى الآن.">No members yet.</span>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
