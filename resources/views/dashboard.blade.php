@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 class="page-title">Dashboard Overview</h1>
    <p class="page-subtitle">Welcome back to employee management! Here's your recent activity.</p>
</div>

<!-- Admin Stats -->
@if(Auth::user()->isAdmin())
<div class="stats-grid">
    <!-- Total Employees -->
    <div class="stat-card-gradient bg-grad-purple">
        <div class="stat-icon-box" style="color: #6b21a8;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Employees</span>
            <span class="stat-value">{{ $totalEmployees }}</span>
        </div>
    </div>
    
    <!-- Departments -->
    <div class="stat-card-gradient bg-grad-green">
        <div class="stat-icon-box" style="color: #064e3b;">
            <i class="fas fa-building"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Departments</span>
            <span class="stat-value">{{ $totalDepartments }}</span>
        </div>
    </div>
    
    <!-- Pending Leaves -->
    <div class="stat-card-gradient bg-grad-pink">
        <div class="stat-icon-box" style="color: #831843;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Pending Leaves</span>
            <span class="stat-value">{{ $pendingLeaves }}</span>
        </div>
    </div>
    
    <!-- Present Today -->
    <div class="stat-card-gradient bg-grad-blue">
        <div class="stat-icon-box" style="color: #1e3a8a;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Present Today</span>
            <span class="stat-value">{{ $presentToday }}</span>
        </div>
    </div>
</div>
@endif

<!-- Employee Stats (If needed for employee view, reusable structure) -->
@if(!Auth::user()->isAdmin())
<div class="stats-grid">
    <div class="stat-card-gradient bg-grad-pink">
        <div class="stat-icon-box" style="color: #831843;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">My Pending Leaves</span>
            <span class="stat-value">{{ $pendingLeaves }}</span>
        </div>
    </div>
    
     <div class="stat-card-gradient bg-grad-teal">
        <div class="stat-icon-box" style="color: #134e4a;">
            <i class="fas fa-user-clock"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Attendance Today</span>
            <span class="stat-value">{{ $presentToday ? 'Present' : 'Absent' }}</span>
        </div>
    </div>
</div>
@endif

<div class="row" style="gap: 2rem; margin: 0;">
    <div class="col-md-6" style="flex: 1; min-width: 300px; padding: 0;">
        <div class="card" style="height: 100%;">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.25rem; font-weight: 700;">Recent Attendance</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAttendance as $attendance)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 2rem; height: 2rem; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                        {{ strtoupper(substr($attendance->employee->first_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">{{ $attendance->employee->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}</td>
                            <td>
                                <span class="badge {{ $attendance->clock_out ? 'badge-success' : 'badge-warning' }}">
                                    {{ $attendance->clock_out ? 'Completed' : 'Working' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 2rem; color: #6b7280;">No recent records</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6" style="flex: 1; min-width: 300px; padding: 0;">
        <div class="card" style="height: 100%;">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.25rem; font-weight: 700;">Recent Leave Requests</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLeaves as $leave)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 2rem; height: 2rem; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                        {{ strtoupper(substr($leave->employee->first_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">{{ $leave->employee->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ ucfirst($leave->leave_type) }}</td>
                            <td>{!! $leave->status_badge !!}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 2rem; color: #6b7280;">No recent requests</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
