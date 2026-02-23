@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Create Payroll</h1>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('payroll.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="employee_id" class="form-label">Employee</label>
                <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" data-salary="{{ $employee->salary }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                    @endforeach
                </select>
                @error('employee_id')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="salary_amount" class="form-label">Salary Amount</label>
                <input type="number" step="0.01" class="form-control @error('salary_amount') is-invalid @enderror" id="salary_amount" name="salary_amount" value="{{ old('salary_amount') }}">
                @error('salary_amount')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="pay_period_start" class="form-label">Pay Period Start</label>
                <input type="date" class="form-control @error('pay_period_start') is-invalid @enderror" id="pay_period_start" name="pay_period_start" value="{{ old('pay_period_start') }}">
                @error('pay_period_start')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-6 form-group">
                <label for="pay_period_end" class="form-label">Pay Period End</label>
                <input type="date" class="form-control @error('pay_period_end') is-invalid @enderror" id="pay_period_end" name="pay_period_end" value="{{ old('pay_period_end') }}">
                @error('pay_period_end')
                    <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Create Payroll</button>
            <a href="{{ route('payroll.index') }}" class="logout-btn" style="margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const employeeSelect = document.getElementById('employee_id');
        const salaryInput = document.getElementById('salary_amount');
        
        employeeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const salary = selectedOption.getAttribute('data-salary');
            if (salary) {
                salaryInput.value = salary;
            }
        });
    });
</script>
@endpush
@endsection
