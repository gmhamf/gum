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
    <a class="nav-link" href="{{ route('trainer.diets.index') }}">
        <i class="fas fa-utensils"></i> Diets
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
<div class="row">
    <!-- Send Notification Form -->
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-paper-plane text-gold"></i> Send Notification</h4>
            </div>
            <div class="card-body">
                 @if(session('success'))
                <div class="alert alert-success" style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); color: #00cc66; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('trainer.notifications.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="member_id">Select Member</label>
                        <select name="member_id" id="member_id" class="form-control" required>
                            <option value="">-- Choose Member --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                         @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" placeholder="Notification Title" required>
                         @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" rows="4" class="form-control @error('message') is-invalid @enderror"
                                  placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- History List -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-history text-gold"></i> Sent History</h4>
            </div>
            <div class="card-body">
                @if($notifications->count() > 0)
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>To</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                            <tr>
                                <td>{{ $notification->title }}</td>
                                <td>{{ $notification->member->name }}</td>
                                <td>
                                    @if(!$notification->seen)
                                        <span class="badge" style="background: rgba(255,193,7,0.1); color: #ffc107;">Unread</span>
                                    @else
                                        <span class="badge" style="background: rgba(0,204,102,0.1); color: #00cc66;">Seen</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.8rem; color: #888;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                 <div class="text-center py-5">
                    <p class="text-muted">No notifications sent yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
