@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Attendance Record</h1>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
        @csrf
         @method('PUT')

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="employee_id" class="form-label">Employee</label>
                <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id', $attendance->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                    @endforeach
                </select>
                @error('employee_id')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required>
                @error('date')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="clock_in" class="form-label">Clock In</label>
                <input type="time" step="1" class="form-control @error('clock_in') is-invalid @enderror" id="clock_in" name="clock_in" value="{{ old('clock_in', $attendance->clock_in) }}">
                @error('clock_in')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="clock_out" class="form-label">Clock Out</label>
                <input type="time" step="1" class="form-control @error('clock_out') is-invalid @enderror" id="clock_out" name="clock_out" value="{{ old('clock_out', $attendance->clock_out) }}">
                @error('clock_out')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Update Attendance</button>
            <a href="{{ route('attendance.index') }}" class="logout-btn" style="margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
