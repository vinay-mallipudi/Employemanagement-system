@extends('layouts.admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="page-title">Attendance</h1>
    @if(Auth::user()->isAdmin())
    <a href="{{ route('attendance.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add Attendance Record
    </a>
    @endif
</div>

<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>EMPLOYEE</th>
                    <th>DATE</th>
                    <th>CLOCK IN</th>
                    <th>CLOCK OUT</th>
                    <th>TOTAL HOURS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                             <div style="width: 2rem; height: 2rem; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: #4b5563;">
                                {{ strtoupper(substr($attendance->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $attendance->employee->full_name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}</td>
                    <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->total_hours ? $attendance->total_hours . ' hrs' : '-' }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">

                            <a href="{{ route('attendance.edit', $attendance->id) }}"
                                class="btn btn-sm btn-secondary">
                                Edit
                            </a>

                            <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #6b7280;">No attendance records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
     <div style="margin-top: 1.5rem;">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
