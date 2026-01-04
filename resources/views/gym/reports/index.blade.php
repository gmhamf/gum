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
    <a class="nav-link" href="{{ route('gym.subscriptions.index') }}">
        <i class="fas fa-credit-card"></i> Subscriptions
    </a>
    <a class="nav-link active" href="{{ route('gym.reports') }}">
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
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['total_members'] }}</h3>
            <span>Total Members</span>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-friends"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['active_members'] }}</h3>
            <span>Active Members</span>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-check"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['total_trainers'] }}</h3>
            <span>Trainers</span>
        </div>
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ number_format($stats['monthly_income'], 0) }}</h3>
            <span>Monthly Revenue</span>
        </div>
        <div class="stat-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h4><i class="fas fa-user-plus text-gold"></i> Recently Joined Members</h4>
    </div>
    <div class="card-body">
        @if($recentMembers->count() > 0)
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentMembers as $member)
                    <tr>
                        <td style="font-weight: 500;">{{ $member->name }}</td>
                        <td><span style="font-family: monospace; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px;">{{ $member->member_code }}</span></td>
                        <td>{{ $member->email ?? '---' }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($member->status)
                                <span style="background: rgba(0,204,102,0.1); color: #00cc66; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Active</span>
                            @else
                                <span style="background: rgba(255,77,77,0.1); color: #ff4d4d; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-muted py-5">No recent members.</p>
        @endif
    </div>
</div>
@endsection
