@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('gym.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link active" href="{{ route('gym.trainers.index') }}">
        <i class="fas fa-users"></i> Trainers
    </a>
    <a class="nav-link" href="{{ route('gym.members.index') }}">
        <i class="fas fa-user-friends"></i> Members
    </a>
    <a class="nav-link" href="{{ route('gym.subscriptions.index') }}">
        <i class="fas fa-credit-card"></i> Subscriptions
    </a>
    <a class="nav-link" href="{{ route('gym.reports') }}">
        <i class="fas fa-chart-bar"></i> Reports
    </a>
@endsection

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h4><i class="fas fa-user-edit" style="color: #D4AF37; margin-right: 0.5rem;"></i> Edit Trainer</h4>
        <a href="{{ route('gym.trainers.index') }}" style="color: #A3A3A3; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('gym.trainers.update', $trainer->id) }}">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #A3A3A3;">Trainer Name</label>
                    <input type="text" name="name" value="{{ old('name', $trainer->name) }}" required
                           style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    @error('name')
                        <div style="color: #ff4d4d; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #A3A3A3;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $trainer->email) }}" required
                           style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    @error('email')
                        <div style="color: #ff4d4d; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #A3A3A3;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $trainer->phone) }}" required
                           style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    @error('phone')
                        <div style="color: #ff4d4d; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #A3A3A3;">Password <small style="color: #666;">(Leave blank to keep current)</small></label>
                    <input type="password" name="password"
                           style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    @error('password')
                        <div style="color: #ff4d4d; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #A3A3A3;">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $trainer->specialization) }}" required
                           style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    @error('specialization')
                        <div style="color: #ff4d4d; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #A3A3A3;">Experience (Years)</label>
                    <input type="number" name="experience" value="{{ old('experience', $trainer->experience) }}" min="0"
                           style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    @error('experience')
                        <div style="color: #ff4d4d; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #A3A3A3;">Status</label>
                    <select name="status" style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                        <option value="1" {{ $trainer->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$trainer->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 2rem; gap: 1rem;">
                <a href="{{ route('gym.trainers.index') }}" style="padding: 0.75rem 1.5rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #A3A3A3; text-decoration: none;">Cancel</a>
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #FFD700, #D4AF37); border: none; border-radius: 8px; color: #000; font-weight: 600; cursor: pointer;">Update Trainer</button>
            </div>
        </form>
    </div>
</div>
@endsection
