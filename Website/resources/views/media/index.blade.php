@extends('layouts.admin')

@section('title', 'Media Gallery')

@push('styles')
<style>
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .media-item {
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #f8f9fa;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .media-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .media-thumbnail {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .media-item.video::before {
        content: '▶';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: white;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        z-index: 1;
    }
    .media-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: none;
    }
    .media-item:hover .media-actions {
        display: flex;
        gap: 0.25rem;
    }
    .media-info {
        padding: 1rem;
    }
    .media-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .media-meta {
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Media Gallery</h1>
        <a href="{{ route('media.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Media
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($media->count() > 0)
                <div class="media-grid">
                    @foreach($media as $item)
                        <div class="media-item {{ $item->type }}">
                            @if($item->type === 'image')
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="media-thumbnail">
                            @else
                                <img src="{{ $item->thumbnail_url ?? 'https://via.placeholder.com/300x200?text=Video' }}" 
                                     alt="{{ $item->title }}" 
                                     class="media-thumbnail">
                            @endif
                            
                            <div class="media-actions">
                                <a href="{{ route('media.edit', $item) }}" 
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('media.destroy', $item) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="media-info">
                                <div class="media-title" title="{{ $item->title }}">
                                    {{ $item->title }}
                                </div>
                                <div class="media-meta">
                                    {{ $item->created_at->format('M d, Y') }}
                                    @if($item->is_featured)
                                        <span class="badge bg-warning text-dark ms-2">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $media->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                    <h4>No media items found</h4>
                    <p class="text-muted">Upload your first media item to get started</p>
                    <a href="{{ route('media.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus"></i> Add Media
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
