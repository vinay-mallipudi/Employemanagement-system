@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Department</h1>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Create Department</button>
            <a href="{{ route('departments.index') }}" class="logout-btn" style="margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
