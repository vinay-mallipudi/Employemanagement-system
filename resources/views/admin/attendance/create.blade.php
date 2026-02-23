@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Attendance Record</h1>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="employee_id" class="form-label">Employee</label>
                @if(Auth::user()->isAdmin())
                <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                    @endforeach
                </select>
                @else
                    <input type="text" class="form-control" value="{{ Auth::user()->employee->full_name }}" disabled>
                    <input type="hidden" name="employee_id" value="{{ Auth::user()->employee->id }}">
                @endif
                @error('employee_id')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="clock_in" class="form-label">Clock In</label>
                <input type="time" class="form-control @error('clock_in') is-invalid @enderror" id="clock_in" name="clock_in" value="{{ old('clock_in') }}">
                @error('clock_in')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="clock_out" class="form-label">Clock Out</label>
                <input type="time" class="form-control @error('clock_out') is-invalid @enderror" id="clock_out" name="clock_out" value="{{ old('clock_out') }}">
                @error('clock_out')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Submit</button>
            <a href="{{ route('attendance.index') }}" class="logout-btn" style="margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
