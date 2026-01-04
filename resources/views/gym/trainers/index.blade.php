@extends('layouts.dashboard-bilingual')

@section('sidebar')
    <a class="nav-link" href="{{ route('gym.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> 
        <span data-en="Dashboard" data-ar="لوحة التحكم">Dashboard</span>
    </a>
    <a class="nav-link active" href="{{ route('gym.trainers.index') }}">
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
<div class="card">
    <div class="card-header">
        <h4>
            <i class="fas fa-users" style="color: #D4AF37; margin-right: 0.5rem;"></i> 
            <span data-en="Trainers List" data-ar="قائمة المدربين">Trainers List</span>
        </h4>
        <a href="{{ route('gym.trainers.create') }}" style="background: linear-gradient(135deg, #FFD700, #D4AF37); color: #000; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i> <span data-en="Add New" data-ar="إضافة جديد">Add New</span>
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div style="background: rgba(0, 204, 102, 0.1); border: 1px solid rgba(0, 204, 102, 0.2); color: #00cc66; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
        @endif

        @if($trainers->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; color: #ccc;">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left;">
                        <th style="padding: 1rem 0.5rem;">#</th>
                        <th style="padding: 1rem 0.5rem;" data-en="Name" data-ar="الاسم">Name</th>
                        <th style="padding: 1rem 0.5rem;" data-en="Email" data-ar="البريد">Email</th>
                        <th style="padding: 1rem 0.5rem;" data-en="Phone" data-ar="الهاتف">Phone</th>
                        <th style="padding: 1rem 0.5rem;" data-en="Specialization" data-ar="التخصص">Specialization</th>
                        <th style="padding: 1rem 0.5rem;" data-en="Experience" data-ar="الخبرة">Experience</th>
                        <th style="padding: 1rem 0.5rem;" data-en="Status" data-ar="الحالة">Status</th>
                        <th style="padding: 1rem 0.5rem;" data-en="Actions" data-ar="إجراءات">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trainers as $trainer)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 1rem 0.5rem;">{{ $loop->iteration }}</td>
                        <td style="padding: 1rem 0.5rem;">
                            <div style="font-weight: 600; color: #fff;">{{ $trainer->name }}</div>
                        </td>
                        <td style="padding: 1rem 0.5rem;">{{ $trainer->email }}</td>
                        <td style="padding: 1rem 0.5rem;">{{ $trainer->phone }}</td>
                        <td style="padding: 1rem 0.5rem;">{{ $trainer->specialization }}</td>
                        <td style="padding: 1rem 0.5rem;">{{ $trainer->experience }} <span data-en="Years" data-ar="سنوات">Years</span></td>
                        <td style="padding: 1rem 0.5rem;">
                            @if($trainer->status)
                                <span style="background: rgba(0,204,102,0.1); color: #00cc66; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;" data-en="Active" data-ar="نشط">Active</span>
                            @else
                                <span style="background: rgba(255,77,77,0.1); color: #ff4d4d; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;" data-en="Inactive" data-ar="غير نشط">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 1rem 0.5rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('gym.trainers.edit', $trainer->id) }}" style="color: #D4AF37; padding: 0.4rem; border-radius: 4px; background: rgba(212,175,55,0.1);" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('gym.trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #ff4d4d; padding: 0.4rem; border-radius: 4px; background: rgba(255,77,77,0.1); border: none; cursor: pointer;" onclick="return confirm('Are you sure?')" title="Delete">
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
        <div style="text-align: center; padding: 3rem; color: #666;">
            <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
            <p data-en="No trainers found." data-ar="لا يوجد مدربين.">No trainers found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
