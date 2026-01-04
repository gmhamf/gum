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
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-size: 1.5rem; color: #D4AF37;">Edit Member: {{ $member->name }}</h2>
    <a href="{{ route('gym.members.index') }}" class="btn btn-ghost">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

@if(session('success'))
<div class="alert alert-success" style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); color: #00cc66; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
    {{ session('success') }}
</div>
@endif

<div class="content-grid" style="grid-template-columns: 2fr 1fr;">
    <!-- Profile Edit Form -->
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-user-edit text-gold"></i> Basic Information</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('gym.members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" id="name" value="{{ old('name', $member->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" id="email" value="{{ old('email', $member->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               name="phone" id="phone" value="{{ old('phone', $member->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Member Code</label>
                        <input type="text" class="form-control" value="{{ $member->member_code }}" readonly style="background: rgba(255,255,255,0.05); color: #aaa;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror"
                               name="weight" id="weight" value="{{ old('weight', $member->weight) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror"
                               name="height" id="height" value="{{ old('height', $member->height) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control @error('age') is-invalid @enderror"
                               name="age" id="age" value="{{ old('age', $member->age) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control @error('gender') is-invalid @enderror"
                                name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="trainer_id">Trainer</label>
                        <select class="form-control @error('trainer_id') is-invalid @enderror"
                                name="trainer_id" id="trainer_id">
                            <option value="">No Trainer</option>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ old('trainer_id', $member->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                    {{ $trainer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                     <label for="status">Account Status</label>
                    <select class="form-control @error('status') is-invalid @enderror"
                            name="status" id="status">
                        <option value="1" {{ old('status', $member->status) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !old('status', $member->status) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-gold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscription Management -->
    <div>
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-credit-card text-gold"></i> Subscription</h4>
            </div>
            <div class="card-body">
                @if($member->activeSubscription)
                    <div style="background: rgba(0,204,102,0.1); border: 1px solid rgba(0,204,102,0.2); padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                        <h5 style="color: #00cc66; margin: 0 0 0.5rem 0;">Active</h5>
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.5rem;">
                            <span>Type</span>
                            <strong style="color: #fff;">{{ ucfirst($member->activeSubscription->type) }}</strong>
                        </div>
                         <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.5rem;">
                            <span>Ends</span>
                            <strong style="color: #fff;">{{ $member->activeSubscription->end_date->format('Y-m-d') }}</strong>
                        </div>
                        <div style="text-align: center; margin-top: 1rem;">
                             <form action="{{ route('gym.subscriptions.renew', $member->activeSubscription->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-gold btn-sm w-100">Renew Now</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem 0;">
                        <p class="text-muted">No active subscription.</p>
                        <a href="{{ route('gym.subscriptions.create') }}?member_id={{ $member->id }}" class="btn btn-gold btn-sm">Add Subscription</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                 <h4><i class="fas fa-history text-gold"></i> History</h4>
            </div>
            <div class="card-body p-0">
                @if($member->subscriptions->count() > 0)
                 <table class="custom-table" style="font-size: 0.8rem;">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>End</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($member->subscriptions->sortByDesc('created_at')->take(5) as $sub)
                        <tr>
                            <td>{{ ucfirst($sub->type) }}</td>
                            <td>{{ $sub->end_date->format('Y-m-d') }}</td>
                            <td>
                                @if($sub->status == 'active') <span style="color:#00cc66">Active</span>
                                @elseif($sub->status == 'expired') <span style="color:#ff4d4d">Expired</span>
                                @else <span style="color:#aaa">{{ ucfirst($sub->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                 </table>
                @else
                <p class="text-center text-muted py-3 m-0">No history.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
