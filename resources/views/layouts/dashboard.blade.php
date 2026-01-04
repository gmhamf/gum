{{-- 
    This layout acts as an alias for dashboard-bilingual.
    It ensures backward compatibility with existing views that extend layouts.dashboard.
    All new views should use layouts.dashboard-bilingual directly.
--}}
@extends('layouts.dashboard-bilingual')

@section('sidebar')
    @yield('sidebar')
@endsection

@section('content')
    @yield('content')
@endsection
