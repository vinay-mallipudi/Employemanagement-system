@extends('layouts.admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="page-title">Departments</h1>
    <a href="{{ route('departments.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add New Department
    </a>
</div>

<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>EMPLOYEES</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                <tr>
                    <td style="font-weight: 600;">{{ $department->name }}</td>
                    <td>{{ $department->description ?? '-' }}</td>
                    <td><span class="badge badge-secondary">{{ $department->employees_count }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">

                            <a href="{{ route('departments.edit', $department->id) }}"
                                class="btn btn-sm btn-secondary">
                                Edit
                            </a>

                            <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
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
                    <td colspan="4" style="text-align: center; padding: 2rem; color: #6b7280;">No departments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
