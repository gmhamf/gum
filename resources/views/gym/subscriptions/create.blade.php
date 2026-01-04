@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('gym.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('gym.trainers.index') }}">
        <i class="fas fa-users"></i> Trainers
    </a>
    <a class="nav-link" href="{{ route('gym.members.index') }}">
        <i class="fas fa-user-friends"></i> Members
    </a>
    <a class="nav-link active" href="{{ route('gym.subscriptions.index') }}">
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
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h4><i class="fas fa-plus text-gold"></i> Create New Subscription</h4>
        <a href="{{ route('gym.subscriptions.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('gym.subscriptions.store') }}">
            @csrf

            <div class="form-group">
                <label for="member_id">Member</label>
                <select class="form-control @error('member_id') is-invalid @enderror"
                        id="member_id" name="member_id" required>
                    <option value="">Select Member</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id', request('member_id')) == $member->id ? 'selected' : '' }}>
                            {{ $member->name }} ({{ $member->member_code }})
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="type">Subscription Type</label>
                    <select class="form-control @error('type') is-invalid @enderror"
                            id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="daily" {{ old('type') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ old('type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ old('type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="amount">Amount</label>
                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                           id="amount" name="amount" value="{{ old('amount') }}" required placeholder="0.00">
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                           id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-gold w-100">Create Subscription</button>
            </div>
        </form>
    </div>
</div>
@endsection
