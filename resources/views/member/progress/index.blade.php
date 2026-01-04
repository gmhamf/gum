@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('member.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('member.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> Workouts
    </a>
    <a class="nav-link" href="{{ route('member.diets.index') }}">
        <i class="fas fa-utensils"></i> Diet Plan
    </a>
    <a class="nav-link active" href="{{ route('member.progress.index') }}">
        <i class="fas fa-chart-line"></i> Progress
    </a>
    
    <form action="{{ route('member.logout') }}" method="POST" style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
        @csrf
        <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: left; color: #ff4d4d;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-chart-line text-gold"></i> Progress Log</h4>
        <a href="{{ route('member.progress.create') }}" class="btn btn-gold">
            <i class="fas fa-plus"></i> Add Entry
        </a>
    </div>
    <div class="card-body">
        @if($progress->count() > 0)
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Weight (kg)</th>
                        <th>Waist (cm)</th>
                        <th>Chest (cm)</th>
                        <th>Arms (cm)</th>
                        <th>Photos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progress as $p)
                    <tr>
                        <td>{{ $p->date ? $p->date->format('Y-m-d') : '-' }}</td>
                        <td><span style="color: #D4AF37; font-weight: bold;">{{ $p->weight ?? '-' }}</span></td>
                        <td>{{ $p->waist ?? '-' }}</td>
                        <td>{{ $p->chest ?? '-' }}</td>
                        <td>{{ $p->arms ?? '-' }}</td>
                        <td>
                            @if($p->image_before)
                                <a href="{{ asset('storage/'.$p->image_before) }}" target="_blank" class="btn btn-ghost btn-sm">Before</a>
                            @endif
                            @if($p->image_after)
                                <a href="{{ asset('storage/'.$p->image_after) }}" target="_blank" class="btn btn-ghost btn-sm">After</a>
                            @endif
                            @if(!$p->image_before && !$p->image_after)
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
             {{ $progress->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
            <p class="text-muted">No progress entries yet. Start tracking your journey!</p>
        </div>
        @endif
    </div>
</div>
@endsection
