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
<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h4><i class="fas fa-search text-gold"></i> Search & Filter</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('gym.subscriptions.index') }}">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="search">Search Member</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search ?? '' }}" placeholder="Name or Code...">
                </div>

                <div class="col-md-2 form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="daily" {{ $selectedType == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ $selectedType == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $selectedType == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ $selectedType == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>

                <div class="col-md-2 form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ $selectedStatus == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ $selectedStatus == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="cancelled" {{ $selectedStatus == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <label for="date_filter">Date Filter</label>
                    <select class="form-control" id="date_filter" name="date_filter">
                        <option value="">All Time</option>
                        <option value="today" {{ $selectedDateFilter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ $selectedDateFilter == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ $selectedDateFilter == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="expiring_soon" {{ $selectedDateFilter == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end form-group" style="gap: 0.5rem;">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    <a href="{{ route('gym.subscriptions.index') }}" class="btn btn-ghost">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- List Section -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-credit-card text-gold"></i> Subscriptions List</h4>
        <div style="display: flex; gap: 1rem; align-items: center;">
             <span class="badge bg-gold text-dark" style="padding: 0.5rem 1rem; border-radius: 4px;">{{ $subscriptions->count() }} Records</span>
             <a href="{{ route('gym.subscriptions.create') }}" class="btn btn-gold btn-sm">
                <i class="fas fa-plus"></i> New Subscription
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success" style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); color: #00cc66; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
        @endif

        @if($subscriptions->count() > 0)
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Start / End</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $subscription->member->name }}</strong>
                        </td>
                        <td>
                            <span style="font-family: monospace; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px;">{{ $subscription->member->member_code }}</span>
                        </td>
                        <td>
                            <span class="badge" style="background: rgba(0,123,255,0.1); color: #007bff; padding: 4px 8px; border-radius: 4px;">{{ ucfirst($subscription->type) }}</span>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem;">
                                <div>{{ $subscription->start_date->format('Y-m-d') }}</div>
                                <div style="color: {{ $subscription->end_date->isPast() ? '#ff4d4d' : '#888' }}">
                                    {{ $subscription->end_date->format('Y-m-d') }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="color: #D4AF37; font-weight: bold;">{{ number_format($subscription->amount, 2) }}</span>
                        </td>
                        <td>
                            @if($subscription->status == 'active')
                                <span style="background: rgba(0,204,102,0.1); color: #00cc66; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Active</span>
                            @elseif($subscription->status == 'expired')
                                <span style="background: rgba(255,77,77,0.1); color: #ff4d4d; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Expired</span>
                            @else
                                <span style="background: rgba(255,255,255,0.1); color: #aaa; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">{{ ucfirst($subscription->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                @if($subscription->status == 'active')
                                    <form action="{{ route('gym.subscriptions.renew', $subscription->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-ghost btn-sm" style="color: #00cc66;" title="Renew">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('gym.subscriptions.cancel', $subscription->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-ghost btn-sm" style="color: #ffc107;" title="Cancel"
                                                onclick="return confirm('Cancel this subscription?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('gym.subscriptions.destroy', $subscription->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color: #ff4d4d;" title="Delete"
                                            onclick="return confirm('Delete this subscription permanentely?')">
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

        <div class="stats-grid mt-4">
            <div class="stat-card">
                 <div class="stat-info">
                    <h3>{{ $subscriptions->where('status', 'active')->count() }}</h3>
                    <span>Active</span>
                </div>
                 <div class="stat-icon" style="color: #00cc66;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card">
                 <div class="stat-info">
                    <h3>{{ $subscriptions->where('status', 'active')->filter(fn($s) => $s->end_date->diffInDays(now()) <= 7)->count() }}</h3>
                    <span>Expiring</span>
                </div>
                 <div class="stat-icon" style="color: #ffc107;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="stat-card">
                 <div class="stat-info">
                    <h3>{{ $subscriptions->where('status', 'expired')->count() }}</h3>
                    <span>Expired</span>
                </div>
                 <div class="stat-icon" style="color: #ff4d4d;">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
            <p class="text-muted">No subscriptions found matching your criteria.</p>
        </div>
        @endif
    </div>
</div>
@endsection
