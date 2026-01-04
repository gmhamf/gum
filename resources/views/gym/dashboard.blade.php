@extends('layouts.dashboard-bilingual')

@section('sidebar')
    <a class="nav-link active" href="{{ route('gym.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> 
        <span data-en="Dashboard" data-ar="لوحة التحكم">Dashboard</span>
    </a>
    <a class="nav-link" href="{{ route('gym.trainers.index') }}">
        <i class="fas fa-users"></i> 
        <span data-en="Trainers" data-ar="المدربين">Trainers</span>
    </a>
    <a class="nav-link" href="{{ route('gym.members.index') }}">
        <i class="fas fa-user-friends"></i> 
        <span data-en="Members" data-ar="الأعضاء">Members</span>
    </a>
    <a class="nav-link" href="{{ route('gym.subscriptions.index') }}">
        <i class="fas fa-credit-card"></i> 
        <span data-en="Subscriptions" data-ar="الاشتراكات">Subscriptions</span>
    </a>
    <a class="nav-link" href="{{ route('gym.reports') }}">
        <i class="fas fa-chart-bar"></i> 
        <span data-en="Reports" data-ar="التقارير">Reports</span>
    </a>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['total_members'] }}</h3>
                <span data-en="Total Members" data-ar="إجمالي الأعضاء">Total Members</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-friends"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['total_trainers'] }}</h3>
                <span data-en="Trainers" data-ar="المدربين">Trainers</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['active_subscriptions'] }}</h3>
                <span data-en="Active Subs" data-ar="اشتراكات نشطة">Active Subs</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-credit-card"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $stats['expiring_soon'] }}</h3>
                <span data-en="Expiring Soon" data-ar="تنتهي قريباً">Expiring Soon</span>
            </div>
            <div class="stat-icon" style="color: #ff4d4d;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-bell" style="color: #D4AF37; margin-right: 0.5rem;"></i> 
                    <span data-en="Expiring Subscriptions" data-ar="اشتراكات قاربت على الانتهاء">Expiring Subscriptions</span>
                </h4>
                <span style="background: rgba(212, 175, 55, 0.2); color: #D4AF37; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">{{ $expiringSubscriptions->count() }}</span>
            </div>
            <div class="card-body">
                @if($expiringSubscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="custom-table" style="width: 100%; color: #ccc;">
                        <thead>
                            <tr style="text-align: left;">
                                <th data-en="Member" data-ar="العضو">Member</th>
                                <th data-en="Type" data-ar="النوع">Type</th>
                                <th data-en="Days Left" data-ar="الأيام المتبقية">Days Left</th>
                                <th data-en="Action" data-ar="إجراء">Action</th>
                            </tr>
                        </thead>
                        <tbody style="border-top: 1px solid rgba(255,255,255,0.1);">
                            @foreach($expiringSubscriptions as $subscription)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td style="padding: 1rem 0;">
                                    <strong style="color: #fff;">{{ $subscription->member->name }}</strong>
                                    <div style="font-size: 0.8rem; color: #666;">{{ $subscription->member->member_code }}</div>
                                </td>
                                <td>{{ $subscription->type }}</td>
                                <td style="color: #ff4d4d;">{{ $subscription->end_date->diffInDays(now()) }} <span data-en="days" data-ar="يوم">days</span></td>
                                <td>
                                    <form action="{{ route('gym.subscriptions.renew', $subscription->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="background: none; border: 1px solid #D4AF37; color: #D4AF37; padding: 0.3rem 0.8rem; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                            <i class="fas fa-sync-alt"></i> <span data-en="Renew" data-ar="تجديد">Renew</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div style="text-align: center; color: #666; padding: 2rem;">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: #00cc66; margin-bottom: 1rem; display: block;"></i>
                    <span data-en="No expirations soon." data-ar="لا توجد اشتراكات تنتهي قريباً.">No expirations soon.</span>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-chart-pie" style="color: #D4AF37; margin-right: 0.5rem;"></i> 
                    <span data-en="Quick Stats" data-ar="إحصائيات سريعة">Quick Stats</span>
                </h4>
            </div>
            <div class="card-body">
                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                     <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px;">
                         <div style="font-size: 0.8rem; color: #aaa;" data-en="New Members" data-ar="أعضاء جدد">New Members</div>
                         <div style="font-size: 1.5rem; font-weight: 700; color: #00cc66;">+{{ $stats['new_members'] ?? 0 }}</div>
                     </div>
                     <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px;">
                         <div style="font-size: 0.8rem; color: #aaa;" data-en="Monthly Income" data-ar="الدخل الشهري">Monthly Income</div>
                         <div style="font-size: 1.5rem; font-weight: 700; color: #D4AF37;">${{ number_format($stats['monthly_income'] ?? 0, 2) }}</div>
                     </div>
                 </div>

                 <h5 style="color: #D4AF37; margin-bottom: 1rem;" data-en="Recent Members" data-ar="آخر الأعضاء">Recent Members</h5>
                 @php
                    $recentMembers = \App\Models\Member::where('gym_id', Auth::guard('gym')->id())
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                 @endphp
                 
                 <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                     @foreach($recentMembers as $member)
                     <a href="{{ route('gym.members.edit', $member->id) }}" style="display: flex; justify-content: space-between; padding: 0.75rem; background: rgba(255,255,255,0.02); border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s;">
                         <span style="font-weight: 500;">{{ $member->name }}</span>
                         <span style="font-size: 0.8rem; color: #666;">{{ $member->created_at->diffForHumans() }}</span>
                     </a>
                     @endforeach
                 </div>
            </div>
        </div>
    </div>
@endsection
