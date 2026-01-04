@extends('layouts.dashboard')

@section('sidebar')
    <a class="nav-link" href="{{ route('member.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a class="nav-link active" href="{{ route('member.workouts.index') }}">
        <i class="fas fa-dumbbell"></i> My Workouts
    </a>
    <a class="nav-link" href="{{ route('member.diets.index') }}">
        <i class="fas fa-utensils"></i> Diet Plan
    </a>
    <a class="nav-link" href="{{ route('member.progress.index') }}">
        <i class="fas fa-chart-line"></i> Progress
    </a>
    {{-- Assuming notifications link exists or is part of dashboard --}}
    
    <form action="{{ route('member.logout') }}" method="POST" style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
        @csrf
        <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: left; color: #ff4d4d;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
@endsection

@section('content')
<!-- Search & Filter -->
<div class="card mb-4">
   <div class="card-header">
       <h4><i class="fas fa-search text-gold"></i> Filter Workouts</h4>
   </div>
   <div class="card-body">
       <form method="GET" action="{{ route('member.workouts.index') }}">
           <div class="row">
               <div class="col-md-5 form-group">
                   <label for="search">Search Exercise</label>
                   <input type="text" class="form-control" id="search" name="search"
                          value="{{ $search ?? '' }}" placeholder="Exercise name...">
               </div>

               <div class="col-md-4 form-group">
                   <label for="day">Day</label>
                   <select class="form-control" id="day" name="day">
                       <option value="">All Days</option>
                       <option value="Monday" {{ (isset($selectedDay) && $selectedDay == 'Monday') ? 'selected' : '' }}>Monday</option>
                       <option value="Tuesday" {{ (isset($selectedDay) && $selectedDay == 'Tuesday') ? 'selected' : '' }}>Tuesday</option>
                       <option value="Wednesday" {{ (isset($selectedDay) && $selectedDay == 'Wednesday') ? 'selected' : '' }}>Wednesday</option>
                       <option value="Thursday" {{ (isset($selectedDay) && $selectedDay == 'Thursday') ? 'selected' : '' }}>Thursday</option>
                       <option value="Friday" {{ (isset($selectedDay) && $selectedDay == 'Friday') ? 'selected' : '' }}>Friday</option>
                       <option value="Saturday" {{ (isset($selectedDay) && $selectedDay == 'Saturday') ? 'selected' : '' }}>Saturday</option>
                       <option value="Sunday" {{ (isset($selectedDay) && $selectedDay == 'Sunday') ? 'selected' : '' }}>Sunday</option>
                   </select>
               </div>

               <div class="col-md-3 d-flex align-items-end form-group" style="gap: 0.5rem;">
                   <button type="submit" class="btn btn-gold w-100"><i class="fas fa-filter"></i> Apply</button>
                   <a href="{{ route('member.workouts.index') }}" class="btn btn-ghost"><i class="fas fa-undo"></i></a>
               </div>
           </div>
       </form>
   </div>
</div>

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-dumbbell text-gold"></i> My Workout Schedule</h4>
    </div>
    <div class="card-body">
        @if($workouts->count() > 0)
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Exercise</th>
                        <th>Details</th>
                        <th>Rest</th>
                        <th>Notes</th>
                        <th>Video</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workouts as $workout)
                    <tr>
                        <td>
                            <strong>{{ $workout->day }}</strong>
                            {{-- Assuming day is stored as string like 'Monday' or date --}}
                            {{-- Or using Carbon if it's a date field --}}
                        </td>
                        <td>
                            <strong>{{ $workout->exercise_name }}</strong>
                        </td>
                        <td>
                             <span style="background: rgba(0,123,255,0.1); color: #007bff; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;">{{ $workout->sets }} Sets</span>
                             <span style="background: rgba(23,162,184,0.1); color: #17a2b8; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;">{{ $workout->reps }} Reps</span>
                        </td>
                        <td>{{ $workout->rest_time }}s</td>
                        <td style="font-size: 0.8rem; color: #aaa;">{{ $workout->notes ? Str::limit($workout->notes, 50) : '-' }}</td>
                        <td>
                            @if($workout->video_url)
                            <a href="{{ $workout->video_url }}" target="_blank" class="btn btn-ghost btn-sm" style="color: #ff4d4d;">
                                <i class="fab fa-youtube"></i> Watch
                            </a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
            <p class="text-muted">No workouts found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
