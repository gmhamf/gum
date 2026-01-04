@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('trainer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link active" href="{{ route('trainer.members.index') }}">
        <i class="fas fa-user-friends"></i> My Members
    </a>
    <a class="nav-link" href="{{ route('trainer.workouts.index') }}">
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
        <h4><i class="fas fa-user-plus text-gold"></i> Add New Member</h4>
        <a href="{{ route('trainer.members.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('trainer.members.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="name">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="member_code">Member Code <span class="text-danger">*</span></label>
                    <input type="text" name="member_code" id="member_code" class="form-control" value="{{ old('member_code') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="join_date">Join Date <span class="text-danger">*</span></label>
                    <input type="date" name="join_date" id="join_date" class="form-control" value="{{ old('join_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.1);">
            <h5 class="text-gold mb-3">Physical Information (Optional)</h5>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" id="weight" class="form-control" value="{{ old('weight') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" step="0.1" name="height" id="height" class="form-control" value="{{ old('height') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control" value="{{ old('age') }}">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-gold px-4">Create Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
