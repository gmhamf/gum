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
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-users text-gold"></i> Assigned Members</h4>
        {{-- Trainers usually act on members, maybe they don't create them? 
             The original view had "Create Member", but logic says Gym Owner creates members.
             I'll flip it to follow the original logic just in case: --}}
        {{-- <a href="{{ route('trainer.members.create') }}" class="btn btn-gold"><i class="fas fa-plus"></i> Add Member</a> --}}
        {{-- Checking original logic: yes, it had create button. --}}
        
        {{-- However, usually trainers don't register members. But if the system allows, I'll keep it. --}}
         {{-- Wait, the original code had route('trainer.members.create'). I will include it. --}}
         <a href="{{ route('trainer.members.create') }}" class="btn btn-gold">
            <i class="fas fa-plus"></i> Add Member
        </a>
    </div>
    <div class="card-body">
         @if(session('success'))
        <div class="alert alert-success" style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); color: #00cc66; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
        @endif

        @if($members->count())
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $m)
                    <tr>
                        <td style="font-weight: 500;">{{ $m->name }}</td>
                        <td><span style="font-family: monospace; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px;">{{ $m->member_code }}</span></td>
                        <td>{{ $m->phone }}</td>
                        <td>{{ $m->join_date?->format('Y-m-d') }}</td>
                        <td>
                             @if($m->status)
                                <span style="background: rgba(0,204,102,0.1); color: #00cc66; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Active</span>
                            @else
                                <span style="background: rgba(255,77,77,0.1); color: #ff4d4d; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('trainer.members.show', $m->id) }}" class="btn btn-ghost btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('trainer.members.edit', $m->id) }}" class="btn btn-ghost btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('trainer.members.destroy', $m->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-ghost btn-sm" style="color: #ff4d4d;" onclick="return confirm('Are you sure?')" title="Delete">
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
        @else
        <div class="text-center py-5">
            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
            <p class="text-muted">No members assigned.</p>
        </div>
        @endif
    </div>
</div>
@endsection
