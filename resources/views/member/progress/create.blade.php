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
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h4><i class="fas fa-plus text-gold"></i> Log Progress</h4>
        <a href="{{ route('member.progress.index') }}" class="btn btn-ghost btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('member.progress.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" placeholder="e.g. 75.5">
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="chest">Chest (cm)</label>
                    <input type="number" step="0.1" name="chest" id="chest" class="form-control" value="{{ old('chest') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="waist">Waist (cm)</label>
                    <input type="number" step="0.1" name="waist" id="waist" class="form-control" value="{{ old('waist') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="arms">Arms (cm)</label>
                    <input type="number" step="0.1" name="arms" id="arms" class="form-control" value="{{ old('arms') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="thighs">Thighs (cm)</label>
                    <input type="number" step="0.1" name="thighs" id="thighs" class="form-control" value="{{ old('thighs') }}">
                </div>
            </div>

             <div class="row display-flex" style="align-items: flex-end;">
                 {{-- For photos, simple file inputs --}}
                <div class="col-md-6 form-group">
                    <label for="image_before">Before Photo</label>
                    <input type="file" name="image_before" id="image_before" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 form-group">
                    <label for="image_after">After Photo</label>
                    <input type="file" name="image_after" id="image_after" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label for="note">Notes</label>
                <textarea name="note" id="note" class="form-control" rows="3">{{ old('note') }}</textarea>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-gold px-4">Save Entry</button>
            </div>
        </form>
    </div>
</div>
@endsection
