@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('trainer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('trainer.members.index') }}">
        <i class="fas fa-user-friends"></i> My Members
    </a>
    <a class="nav-link" href="{{ route('trainer.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> Workouts
    </a>
    <a class="nav-link" href="{{ route('trainer.diets.index') }}">
        <i class="fas fa-utensils"></i> Diet Plans
    </a>
    <a class="nav-link active" href="{{ route('trainer.notifications.index') }}">
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
        <h4><i class="fas fa-paper-plane text-gold"></i> Send New Notification</h4>
        <a href="{{ route('trainer.notifications.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('trainer.notifications.store') }}" method="POST">
            @csrf

            <div class="form-group mb-4">
                <label for="member_id">Select Member</label>
                <select name="member_id" id="member_id" class="form-control" required>
                    <option value="">-- Choose Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }} ({{ $member->member_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="title">Notification Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Session Reminder" required>
            </div>

            <div class="form-group mb-4">
                <label for="message">Message Content</label>
                <textarea name="message" id="message" class="form-control" rows="5" placeholder="Enter your message here..." required>{{ old('message') }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-gold px-4">Send Notification</button>
                <a href="{{ route('trainer.notifications.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h6 class="text-gold mb-0"><i class="fas fa-lightbulb"></i> Tips for Effective Notifications</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-gold">Clear Title:</h6>
                <ul class="list-unstyled text-muted small">
                    <li>• Session reminders</li>
                    <li>• Training tips</li>
                    <li>• Diet updates</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="text-gold">Useful Content:</h6>
                <ul class="list-unstyled text-muted small">
                    <li>• Be direct and clear</li>
                    <li>• Use motivating language</li>
                    <li>• Provide actionable advice</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
