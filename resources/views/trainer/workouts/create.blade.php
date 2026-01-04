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
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h4><i class="fas fa-plus text-gold"></i> Create New Workout</h4>
        <a href="{{ route('trainer.workouts.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('trainer.workouts.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="member_id">Member</label>
                    <select class="form-control @error('member_id') is-invalid @enderror"
                            id="member_id" name="member_id" required>
                        <option value="">Select Member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} ({{ $member->member_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="day">Date</label>
                    <input type="date" class="form-control @error('day') is-invalid @enderror"
                           id="day" name="day" value="{{ old('day', date('Y-m-d')) }}" required>
                    @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="exercise_name">Exercise Name</label>
                    <input type="text" class="form-control @error('exercise_name') is-invalid @enderror"
                           id="exercise_name" name="exercise_name" value="{{ old('exercise_name') }}"
                           placeholder="e.g. Bench Press" required>
                    @error('exercise_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 form-group">
                    <label for="sets">Sets</label>
                    <input type="number" class="form-control @error('sets') is-invalid @enderror"
                           id="sets" name="sets" value="{{ old('sets', 3) }}" min="1">
                </div>

                <div class="col-md-3 form-group">
                    <label for="reps">Reps</label>
                    <input type="number" class="form-control @error('reps') is-invalid @enderror"
                           id="reps" name="reps" value="{{ old('reps', 10) }}" min="1">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="rest_time">Rest Time (seconds)</label>
                    <input type="number" class="form-control @error('rest_time') is-invalid @enderror"
                           id="rest_time" name="rest_time" value="{{ old('rest_time', 60) }}">
                </div>

                <div class="col-md-6 form-group">
                    <label for="video_url">Video URL</label>
                    <input type="url" class="form-control @error('video_url') is-invalid @enderror"
                           id="video_url" name="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/...">
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-gold px-4">Save Workout</button>
            </div>
        </form>
    </div>
</div>
@endsection
