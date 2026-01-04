@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('trainer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('trainer.members.index') }}">
        <i class="fas fa-user-friends"></i> My Members
    </a>
    <a class="nav-link active" href="{{ route('trainer.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> Workouts
    </a>
    <a class="nav-link" href="{{ route('trainer.diets.index') }}">
        <i class="fas fa-utensils"></i> Diet Plans
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
        <h4><i class="fas fa-edit text-gold"></i> Edit Workout</h4>
        <a href="{{ route('trainer.workouts.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('trainer.workouts.update', $workout->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="member_id">Member</label>
                    <select class="form-control" id="member_id" name="member_id" required>
                        <option value="">Choose Member...</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id', $workout->member_id) == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} - {{ $member->member_code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group">
                     <label for="day">Day</label>
                    <select class="form-control" id="day" name="day" required>
                         @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <option value="{{ $day }}" {{ old('day', $workout->day) == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="exercise_name">Exercise Name</label>
                    <input type="text" class="form-control" id="exercise_name" name="exercise_name" value="{{ old('exercise_name', $workout->exercise_name) }}" required>
                </div>

                <div class="col-md-3 form-group">
                    <label for="sets">Sets</label>
                    <input type="number" class="form-control" id="sets" name="sets" value="{{ old('sets', $workout->sets) }}" min="1" required>
                </div>

                <div class="col-md-3 form-group">
                    <label for="reps">Reps</label>
                    <input type="number" class="form-control" id="reps" name="reps" value="{{ old('reps', $workout->reps) }}" min="1" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="rest_time">Rest Time (seconds)</label>
                    <input type="number" class="form-control" id="rest_time" name="rest_time" value="{{ old('rest_time', $workout->rest_time) }}">
                </div>

                <div class="col-md-6 form-group">
                    <label for="video_url">Video URL (Optional)</label>
                    <input type="url" class="form-control" id="video_url" name="video_url" value="{{ old('video_url', $workout->video_url) }}">
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $workout->notes) }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-gold px-4">Update Workout</button>
                <a href="{{ route('trainer.workouts.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
