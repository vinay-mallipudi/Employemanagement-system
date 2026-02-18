@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Announcement</h1>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $announcement->title) }}" required>
            @error('title')
                <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message', $announcement->message) }}</textarea>
            @error('message')
                <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Update Announcement</button>
            <a href="{{ route('announcements.index') }}" class="logout-btn" style="margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
