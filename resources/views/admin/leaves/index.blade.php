@extends('layouts.admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="page-title">Leave Applications</h1>
    @if(Auth::user()->isEmployee())
    <a href="{{ route('leaves.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> New Leave Request
    </a>
    @endif
</div>

<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>EMPLOYEE</th>
                    <th>LEAVE TYPE</th>
                    <th>DURATION</th>
                    <th>REASON</th>
                    <th>STATUS</th>
                    <th>VALIDATED BY</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2rem; height: 2rem; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: #4b5563;">
                                {{ strtoupper(substr($leave->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $leave->employee->full_name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>
                        {{ $leave->from_date->format('M d') }} - {{ $leave->to_date->format('M d, Y') }}<br>
                        <small style="color: #6b7280;">({{ $leave->duration }} days)</small>
                    </td>
                    <td style="max-width: 200px;">{{ Str::limit($leave->reason, 50) }}</td>
                    <td>{!! $leave->status_badge !!}</td>
                     <td>{{ $leave->approvedBy->name ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            @if($leave->status === 'pending')
                            <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="badge badge-success" style="border: none; cursor: pointer;">Approve</button>
                            </form>
                            <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="badge badge-danger" style="border: none; cursor: pointer;">Reject</button>
                            </form>
                            @endif
                            <a href="{{ route('leaves.edit', $leave->id) }}" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                             <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link action-btn btn-delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">No leave requests found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
     <div style="margin-top: 1.5rem;">
        {{ $leaves->links() }}
    </div>
</div>
@endsection
