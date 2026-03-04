@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-megaphone-fill me-2 text-primary"></i>Announcements
            </h1>
            <p class="text-muted small mb-0">Stay updated with the latest school news and events</p>
        </div>
        
        @if(Auth::user()->isAdmin())
            <a href="{{ route('announcements.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-2"></i>Create New
            </a>
        @endif
    </div>

    @forelse($announcements as $announcement)
        <div class="card shadow-sm border-0 mb-4 fade-in">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">{{ $announcement->title }}</h4>
                        <div class="small text-muted">
                            <i class="bi bi-person-circle me-1"></i> Posted by {{ $announcement->author->user_name ?? 'System' }} 
                            <span class="mx-2 text-secondary">|</span>
                            <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($announcement->date)->format('d M, Y') }}
                        </div>
                    </div>
                    @if(Auth::user()->isAdmin())
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <a class="dropdown-item" href="{{ route('announcements.edit', $announcement) }}">
                                        <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this announcement?')">
                                            <i class="bi bi-trash me-2"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="announcement-content text-secondary leading-relaxed" style="white-space: pre-line;">
                    {{ $announcement->message }}
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 fade-in">
            <i class="bi bi-journal-text fs-1 text-muted opacity-25"></i>
            <p class="text-secondary mt-3">No announcements at the moment.</p>
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $announcements->links() }}
    </div>
@endsection
