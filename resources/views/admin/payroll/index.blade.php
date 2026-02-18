@extends('layouts.admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="page-title">Payroll</h1>
    @if(Auth::user()->isAdmin())
    <a href="{{ route('payroll.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Create Payroll
    </a>
    @endif
</div>

<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>EMPLOYEE</th>
                    <th>PAY PERIOD</th>
                    <th>SALARY</th>
                    <th>STATUS</th>
                    <th>PAID AT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $payroll)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2rem; height: 2rem; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: #4b5563;">
                                {{ strtoupper(substr($payroll->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $payroll->employee->full_name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ $payroll->pay_period_start->format('M d') }} - {{ $payroll->pay_period_end->format('M d, Y') }}
                    </td>
                    <td>${{ number_format($payroll->salary_amount, 2) }}</td>
                    <td>{!! $payroll->status_badge !!}</td>
                    <td>{{ $payroll->paid_at ? $payroll->paid_at->format('M d, Y h:i A') : '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            @if($payroll->status === 'pending')
                            <form action="{{ route('payroll.markAsPaid', $payroll->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="badge badge-success" style="border: none; cursor: pointer;">Mark as Paid</button>
                            </form>
                            @endif
                            <form action="{{ route('payroll.destroy', $payroll->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link action-btn btn-delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #6b7280;">No payroll records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
     <div style="margin-top: 1.5rem;">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection
