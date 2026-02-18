@extends('layouts.admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="page-title">Announcements</h1>
    @if(Auth::user()->isAdmin())
    <a href="{{ route('announcements.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Create Announcement
    </a>
    @endif
</div>

<div class="row">
    @forelse($announcements as $announcement)
    <div class="col-md-6" style="margin-bottom: 1.5rem;">
        <div class="card" style="height: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <h3 style="margin: 0; font-size: 1.25rem;">{{ $announcement->title }}</h3>
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn-link action-btn btn-edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-link action-btn btn-delete"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            
            <p style="color: #4b5563; line-height: 1.5; margin-bottom: 1.5rem;">
                {{ $announcement->message }}
            </p>
            
            <div style="margin-top: auto; display: flex; justify-content: space-between; font-size: 0.875rem; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
                <span>By: {{ $announcement->creator->name ?? 'Unknown' }}</span>
                <span>{{ $announcement->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-md-12">
        <div class="card" style="text-align: center; padding: 3rem; color: #6b7280;">
            <i class="fas fa-bullhorn" style="font-size: 3rem; margin-bottom: 1rem; color: #d1d5db;"></i>
            <p>No announcements yet.</p>
        </div>
    </div>
    @endforelse
</div>

<div style="margin-top: 1.5rem;">
    {{ $announcements->links() }}
</div>
@endsection
