@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('trainer.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link active" href="{{ route('trainer.members.index') }}">
        <i class="fas fa-user-friends"></i> Members
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
@endsection

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h4>
            <i class="fas fa-user" style="color: #D4AF37; margin-right: 0.5rem;"></i> 
            Member Details
        </h4>
        <a href="{{ route('trainer.members.index') }}" style="color: #A3A3A3; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        {{-- Member Info --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.8rem; color: #666; margin-bottom: 0.25rem;">Name</div>
                <div style="font-size: 1.1rem; font-weight: 600;">{{ $member->name }}</div>
            </div>
            <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.8rem; color: #666; margin-bottom: 0.25rem;">Member Code</div>
                <div style="font-size: 1.1rem; font-weight: 600; font-family: monospace;">{{ $member->member_code }}</div>
            </div>
            <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.8rem; color: #666; margin-bottom: 0.25rem;">Phone</div>
                <div style="font-size: 1.1rem; font-weight: 600;">{{ $member->phone ?? 'N/A' }}</div>
            </div>
            <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.8rem; color: #666; margin-bottom: 0.25rem;">Status</div>
                <div>
                    @if($member->status)
                        <span style="background: rgba(0,204,102,0.1); color: #00cc66; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">Active</span>
                    @else
                        <span style="background: rgba(255,77,77,0.1); color: #ff4d4d; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">Inactive</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Physical Info --}}
        <h5 style="color: #D4AF37; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <i class="fas fa-weight"></i> Physical Information
        </h5>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 8px;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #D4AF37;">{{ $member->weight ?? '--' }}</div>
                <div style="font-size: 0.8rem; color: #666;">kg</div>
            </div>
            <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 8px;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #D4AF37;">{{ $member->height ?? '--' }}</div>
                <div style="font-size: 0.8rem; color: #666;">cm</div>
            </div>
            <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 8px;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #D4AF37;">{{ $member->age ?? '--' }}</div>
                <div style="font-size: 0.8rem; color: #666;">years</div>
            </div>
            <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 8px;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #D4AF37;">{{ ucfirst($member->gender ?? '--') }}</div>
                <div style="font-size: 0.8rem; color: #666;">gender</div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <h5 style="color: #D4AF37; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <i class="fas fa-bolt"></i> Quick Actions
        </h5>
        <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
            <a href="{{ route('trainer.workouts.create') }}?member_id={{ $member->id }}" 
               style="padding: 0.75rem 1.25rem; background: rgba(212,175,55,0.1); border: 1px solid rgba(212,175,55,0.3); border-radius: 8px; color: #D4AF37; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-dumbbell"></i> Assign Workout
            </a>
            <a href="{{ route('trainer.diets.create') }}?member_id={{ $member->id }}" 
               style="padding: 0.75rem 1.25rem; background: rgba(212,175,55,0.1); border: 1px solid rgba(212,175,55,0.3); border-radius: 8px; color: #D4AF37; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-utensils"></i> Assign Diet
            </a>
            <a href="{{ route('trainer.members.progress', $member->id) }}" 
               style="padding: 0.75rem 1.25rem; background: rgba(0,204,102,0.1); border: 1px solid rgba(0,204,102,0.3); border-radius: 8px; color: #00cc66; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-chart-line"></i> View Progress
            </a>
        </div>
    </div>
</div>
@endsection
