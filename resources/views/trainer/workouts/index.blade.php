@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('trainer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('trainer.members.index') }}">
        <i class="fas fa-user-friends"></i> Members
    </a>
    <a class="nav-link active" href="{{ route('trainer.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> Workouts
    </a>
    <a class="nav-link" href="{{ route('trainer.diets.index') }}">
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
<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h4><i class="fas fa-search text-gold"></i> Filter Workouts</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('trainer.workouts.index') }}">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="search">Search</label>
                     <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search ?? '' }}" placeholder="Exercise name...">
                </div>

                <div class="col-md-3 form-group">
                    <label for="day">Date</label>
                    <input type="date" class="form-control" id="day" name="day" value="{{ $selectedDay ?? '' }}">
                </div>

                <div class="col-md-3 form-group">
                    <label for="member_id">Member</label>
                    <select class="form-control" id="member_id" name="member_id">
                        <option value="">All Members</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ $selectedMember == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                 <div class="col-md-2 d-flex align-items-end form-group" style="gap: 0.5rem;">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    <a href="{{ route('trainer.workouts.index') }}" class="btn btn-ghost">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-dumbbell text-gold"></i> Workout Plans</h4>
        <a href="{{ route('trainer.workouts.create') }}" class="btn btn-gold">
            <i class="fas fa-plus"></i> Add Workout
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success" style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); color: #00cc66; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
        @endif

        @if($workouts->count() > 0)
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Day</th>
                        <th>Exercise</th>
                        <th>Details</th>
                        <th>Rest</th>
                        <th>Video</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workouts as $workout)
                    <tr>
                        <td>
                            <strong>{{ $workout->member->name }}</strong>
                             <div style="font-size: 0.8rem; color: #888;">{{ $workout->member->member_code }}</div>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($workout->day)->translatedFormat('Y-m-d') }}
                            <div style="font-size: 0.8rem; color: #888;">{{ \Carbon\Carbon::parse($workout->day)->translatedFormat('l') }}</div>
                        </td>
                        <td>
                            <strong>{{ $workout->exercise_name }}</strong>
                            @if($workout->notes)
                            <div style="font-size: 0.8rem; color: #aaa;">{{ Str::limit($workout->notes, 30) }}</div>
                            @endif
                        </td>
                        <td>
                             <span style="background: rgba(0,123,255,0.1); color: #007bff; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;">{{ $workout->sets }} Sets</span>
                             <span style="background: rgba(23,162,184,0.1); color: #17a2b8; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;">{{ $workout->reps }} Reps</span>
                        </td>
                        <td>{{ $workout->rest_time }}s</td>
                        <td>
                             @if($workout->video_url)
                            <a href="{{ $workout->video_url }}" target="_blank" class="btn btn-ghost btn-sm" style="color: #ff4d4d;">
                                <i class="fab fa-youtube"></i>
                            </a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('trainer.workouts.edit', $workout->id) }}" class="btn btn-ghost btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('trainer.workouts.destroy', $workout->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color: #ff4d4d;"
                                            onclick="return confirm('Delete this workout?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
         <div class="text-center py-5">
            <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
            <p class="text-muted">No workouts found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
