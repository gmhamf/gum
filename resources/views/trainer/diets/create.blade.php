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
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h4><i class="fas fa-plus text-gold"></i> Add Diet Plan</h4>
        <a href="{{ route('trainer.diets.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('trainer.diets.store') }}">
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
                    <label for="day">Day</label>
                    <select class="form-control @error('day') is-invalid @enderror"
                            id="day" name="day" required>
                        <option value="">Select Day</option>
                        <option value="Monday" {{ old('day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ old('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ old('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ old('day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="Friday" {{ old('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                        <option value="Saturday" {{ old('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ old('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                    </select>
                    @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="meal_name">Meal Name</label>
                    <input type="text" class="form-control @error('meal_name') is-invalid @enderror"
                           id="meal_name" name="meal_name" value="{{ old('meal_name') }}"
                           placeholder="e.g. Breakfast" required>
                    @error('meal_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="time">Time</label>
                    <input type="text" class="form-control @error('time') is-invalid @enderror"
                           id="time" name="time" value="{{ old('time') }}"
                           placeholder="e.g. 8:00 AM">
                    @error('time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="calories">Calories</label>
                    <input type="number" class="form-control" id="calories" name="calories"
                           value="{{ old('calories') }}" placeholder="0">
                </div>
                <div class="col-md-4 form-group">
                    <label for="proteins">Proteins (g)</label>
                    <input type="number" class="form-control" id="proteins" name="proteins"
                           value="{{ old('proteins') }}" placeholder="0">
                </div>
                <div class="col-md-4 form-group">
                    <label for="carbs">Carbs (g)</label>
                    <input type="number" class="form-control" id="carbs" name="carbs"
                           value="{{ old('carbs') }}" placeholder="0">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description (Food Items)</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="4"
                          placeholder="List food items here...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-gold px-4">Save Diet Plan</button>
            </div>
        </form>
    </div>
</div>
@endsection
