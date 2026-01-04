@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('gym.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('gym.trainers.index') }}">
        <i class="fas fa-users"></i> Trainers
    </a>
    <a class="nav-link active" href="{{ route('gym.members.index') }}">
        <i class="fas fa-user-friends"></i> Members
    </a>
    <a class="nav-link" href="{{ route('gym.subscriptions.index') }}">
        <i class="fas fa-credit-card"></i> Subscriptions
    </a>
    <a class="nav-link" href="{{ route('gym.reports') }}">
        <i class="fas fa-chart-bar"></i> Reports
    </a>

    <form action="{{ route('gym.logout') }}" method="POST" style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
        @csrf
        <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: left; color: #ff4d4d;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
@endsection

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h4><i class="fas fa-user-plus text-gold"></i> Add New Member</h4>
        <a href="{{ route('gym.members.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('gym.members.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="trainer_id">Assign Trainer</label>
                    <select class="form-control @error('trainer_id') is-invalid @enderror" id="trainer_id" name="trainer_id">
                        <option value="">No Trainer</option>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('trainer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h6 class="text-gold mt-4 mb-3 border-bottom pb-2">Physical Information</h6>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror" 
                           id="weight" name="weight" value="{{ old('weight') }}">
                </div>

                <div class="col-md-4 form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror" 
                           id="height" name="height" value="{{ old('height') }}">
                </div>

                <div class="col-md-4 form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                           id="age" name="age" value="{{ old('age') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="Default: 123456">
                    <small class="text-muted" style="font-size: 0.75rem;">Leave blank to use default.</small>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-gold px-4">Save Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
