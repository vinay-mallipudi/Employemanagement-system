@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Submit Leave Request</h1>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('leaves.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="employee_id" class="form-label">Employee</label>
                @if(Auth::user()->isAdmin())
                <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
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
                <label for="leave_type" class="form-label">Leave Type</label>
                <select class="form-select @error('leave_type') is-invalid @enderror" id="leave_type" name="leave_type" required>
                    <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                    <option value="casual" {{ old('leave_type') == 'casual' ? 'selected' : '' }}>Casual Leave</option>
                    <option value="vacation" {{ old('leave_type') == 'vacation' ? 'selected' : '' }}>Vacation</option>
                    <option value="other" {{ old('leave_type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('leave_type')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" name="from_date" value="{{ old('from_date') }}" required>
                @error('from_date')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" class="form-control @error('to_date') is-invalid @enderror" id="to_date" name="to_date" value="{{ old('to_date') }}" required>
                @error('to_date')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-12 form-group">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" required>{{ old('reason') }}</textarea>
                @error('reason')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Submit Request</button>
            <a href="{{ route('leaves.index') }}" class="logout-btn" style="margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
