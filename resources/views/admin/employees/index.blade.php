@extends('layouts.admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="page-title">View Employees</h1>
    <a href="{{ route('employees.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add New Employee
    </a>
</div>

<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>DEPARTMENT</th>
                    <th>EXPERIENCE</th>
                    <th>SALARY</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #4b5563;">
                                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $employee->full_name }}</div>
                                <div style="font-size: 0.75rem; color: #6b7280;">{{ $employee->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $employee->department->name ?? 'None' }}</td>
                    <td>{{ $employee->experience_years }} Years</td>
                    <td>{{ number_format($employee->salary, 2) }}</td>
                    <td>
                        {!! $employee->status !!}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">

                            <a href="{{ route('employees.edit', $employee->id) }}"
                                class="btn btn-sm btn-secondary">
                                Edit
                            </a>

                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
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
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #6b7280;">No employees found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $employees->links() }}
    </div>
</div>
@endsection