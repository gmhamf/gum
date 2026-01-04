@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('trainer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('trainer.members.index') }}">
        <i class="fas fa-user-friends"></i> Members
    </a>
    <a class="nav-link" href="{{ route('trainer.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> Workouts
    </a>
    <a class="nav-link active" href="{{ route('trainer.diets.index') }}">
        <i class="fas fa-utensils"></i> Diets
    </a>
    <a class="nav-link" href="{{ route('trainer.notifications.index') }}">
        <i class="fas fa-bell"></i> Notifications
    </a>

    <form action="{{ route('trainer.logout') }}" method="POST" style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
        @csrf
        <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: left; color: #ff4d4d;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-utensils text-gold"></i> Diet Plans</h4>
        <a href="{{ route('trainer.diets.create') }}" class="btn btn-gold">
            <i class="fas fa-plus"></i> Add Diet Plan
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success" style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); color: #00cc66; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
        @endif

        @if($diets->count() > 0)
        <div class="content-grid">
            @foreach($diets as $diet)
            <div class="card" style="border: 1px solid rgba(255,255,255,0.1); background: #252525;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <h5 style="color: #D4AF37; margin: 0;">{{ $diet->meal_name }}</h5>
                        <div class="badge bg-secondary">{{ $diet->time }}</div>
                    </div>
                    
                    <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 1rem;">
                        <i class="fas fa-user-circle"></i> {{ $diet->member->name }}
                    </p>

                    <div style="background: rgba(0,0,0,0.2); padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem;">
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

                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05); text-align: right;">
                         <form action="{{ route('trainer.diets.destroy', $diet->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-sm" style="color: #ff4d4d;"
                                    onclick="return confirm('Delete this diet plan?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $diets->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
            <p class="text-muted">No diet plans found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
