@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('member.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('member.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> Workouts
    </a>
    <a class="nav-link" href="{{ route('member.diets.index') }}">
        <i class="fas fa-utensils"></i> Diet Plan
    </a>
    <a class="nav-link" href="{{ route('member.progress.index') }}">
        <i class="fas fa-chart-line"></i> Progress
    </a>
    <a class="nav-link active" href="{{ route('member.notifications.index') }}">
        <i class="fas fa-bell"></i> Notifications
        @if(isset($unreadNotifications) && $unreadNotifications > 0)
            <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadNotifications }}</span>
        @endif
    </a>
    
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
        <h4><i class="fas fa-bell text-gold"></i> Notifications</h4>
    </div>
    <div class="card-body">
        @if($notifications->count() > 0)
        <div class="list-group">
            @foreach($notifications as $notification)
            <div class="list-group-item" style="background: rgba(45, 45, 45, 0.5); border: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 0.5rem; border-left: 3px solid {{ !$notification->seen ? '#D4AF37' : 'transparent' }};">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1" style="color: #D4AF37;">{{ $notification->title }}</h6>
                        <p class="mb-1 text-light">{{ $notification->message }}</p>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                    @if(!$notification->seen)
                    <span class="badge bg-gold text-dark">New</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
             {{ $notifications->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
            <p class="text-muted">No new notifications.</p>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark notifications as read when viewed
        @if($notifications->count())
            setTimeout(() => {
                fetch('{{ route("member.notifications.markAsRead") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                });
            }, 2000);
        @endif
    });
</script>
@endsection
