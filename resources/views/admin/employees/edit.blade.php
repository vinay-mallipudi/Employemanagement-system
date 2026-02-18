@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Employee: {{ $employee->full_name }}</h1>
</div>

<div class="card">
    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
                @error('first_name')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
                @error('last_name')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->user->email) }}" required>
                @error('email')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="department_id" class="form-label">Department</label>
                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                    <option value="">Select Department (Optional)</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}">
                @error('salary')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday', $employee->birthday ? $employee->birthday->format('Y-m-d') : '') }}">
                @error('birthday')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="experience_years" class="form-label">Experience (Years)</label>
                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" id="experience_years" name="experience_years" value="{{ old('experience_years', $employee->experience_years) }}">
                @error('experience_years')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
             <div class="col-md-6 form-group">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="terminated" {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                </select>
                @error('status')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>


             <div class="col-md-6 form-group">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $employee->address) }}</textarea>
                @error('address')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
             <div class="col-md-6 form-group">
                <label for="contact_no" class="form-label">Contact No</label>
                <input type="text" class="form-control @error('contact_no') is-invalid @enderror" id="contact_no" name="contact_no" value="{{ old('contact_no', $employee->contact_no) }}">
                @error('contact_no')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Update Employee</button>
            <a href="{{ route('employees.index') }}" class="logout-btn" style="margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
