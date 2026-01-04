@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('member.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('member.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> Workouts
    </a>
    <a class="nav-link active" href="{{ route('member.diets.index') }}">
        <i class="fas fa-utensils"></i> Diet Plan
    </a>
    <a class="nav-link" href="{{ route('member.progress.index') }}">
        <i class="fas fa-chart-line"></i> Progress
    </a>
     {{-- Notification link if needed, or rely on header/dashboard --}}
    
    <form action="{{ route('member.logout') }}" method="POST" style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
        @csrf
        <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: left; color: #ff4d4d;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-utensils text-gold"></i> My Diet Plan</h4>
    </div>
    <div class="card-body">
        @if($diets->count() > 0)
        <div class="content-grid">
            @foreach($diets as $diet)
            <div class="card" style="border: 1px solid rgba(255,255,255,0.1); background: #252525;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <h5 style="color: #D4AF37; margin: 0;">{{ $diet->meal_name }}</h5>
                        <div class="badge bg-secondary">{{ $diet->time }}</div>
                    </div>
                    
                    <div style="margin-bottom: 0.5rem;">
                         <span class="badge" style="background: rgba(212, 175, 55, 0.2); color: #D4AF37;">{{ $diet->day }}</span>
                    </div>

                    <div style="background: rgba(0,0,0,0.2); padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; color: #ccc;">
                        {{ $diet->description }}
                    </div>

                    <div class="row" style="font-size: 0.85rem; color: #aaa;">
                        <div class="col-4">
                            <i class="fas fa-fire" style="color: #ff4d4d;"></i>
                            {{ $diet->calories ?? '-' }} cal
                        </div>
                        <div class="col-4">
                            <i class="fas fa-drumstick-bite" style="color: #17a2b8;"></i>
                            {{ $diet->proteins ?? '-' }}g
                        </div>
                        <div class="col-4">
                            <i class="fas fa-bread-slice" style="color: #ffc107;"></i>
                            {{ $diet->carbs ?? '-' }}g
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
            <p class="text-muted">No diet plan assigned yet.</p>
        </div>
        @endif
    </div>
</div>
@endsection
