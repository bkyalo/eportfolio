@extends('layouts.admin')

@section('title', $media->title)

@push('styles')
<style>
    .media-container {
        background: #f8f9fa;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .media-content {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #000;
    }
    .media-content img,
    .media-content video {
        max-width: 100%;
        max-height: 70vh;
        width: auto;
        height: auto;
    }
    .video-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
    }
    .video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .media-meta {
        background: #fff;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .meta-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }
    .meta-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: 0;
    }
    .meta-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }
    .meta-value {
        color: #212529;
    }
    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ $media->title }}</h1>
                <div class="btn-group">
                    <a href="{{ route('media.edit', $media) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('media.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Gallery
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="media-container
                    @if($media->type === 'image') 
                        d-flex justify-content-center align-items-center" 
                        style="min-height: 400px;"
                    @endif">
                        @if($media->type === 'image')
                            <div class="media-content">
                                <img src="{{ $media->getUrl() }}" alt="{{ $media->title }}" class="img-fluid">
                            </div>
                        @elseif($media->type === 'video')
                            @if($media->hasCustomProperty('video_url'))
                                @php
                                    $videoUrl = $media->getCustomProperty('video_url');
                                    $embedUrl = null;
                                    
                                    // Handle YouTube URLs
                                    if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                        $videoId = null;
                                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                        if ($videoId) {
                                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                        }
                                    } 
                                    // Handle Vimeo URLs
                                    elseif (str_contains($videoUrl, 'vimeo.com')) {
                                        $videoId = null;
                                        if (preg_match('/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)(\d+)/', $videoUrl, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                        if ($videoId) {
                                            $embedUrl = 'https://player.vimeo.com/video/' . $videoId;
                                        }
                                    }
                                @endphp
                                
                                @if($embedUrl)
                                    <div class="video-wrapper">
                                        <iframe src="{{ $embedUrl }}" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                        </iframe>
                                    </div>
                                @else
                                    <div class="text-center p-5">
                                        <i class="fas fa-video fa-4x mb-3 text-muted"></i>
                                        <p class="mb-0">Video preview not available</p>
                                        <a href="{{ $videoUrl }}" target="_blank" class="btn btn-link">
                                            View on source <i class="fas fa-external-link-alt ms-1"></i>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="video-wrapper">
                                    <video controls class="w-100">
                                        <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <div class="card-text">
                                @if($media->description)
                                    {{ $media->description }}
                                @else
                                    <p class="text-muted">No description provided.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Media Information</h5>
                            
                            <div class="meta-item">
                                <div class="meta-label">Type</div>
                                <div class="meta-value">
                                    {{ ucfirst($media->type) }}
                                    @if($media->is_featured)
                                        <span class="badge bg-warning text-dark ms-2">Featured</span>
                                    @endif
                                    @if(!$media->is_visible)
                                        <span class="badge bg-secondary ms-2">Hidden</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($media->mime_type)
                                <div class="meta-item">
                                    <div class="meta-label">MIME Type</div>
                                    <div class="meta-value">{{ $media->mime_type }}</div>
                                </div>
                            @endif
                            
                            @if($media->size)
                                <div class="meta-item">
                                    <div class="meta-label">File Size</div>
                                    <div class="meta-value">
                                        @if($media->size < 1024 * 1024)
                                            {{ number_format($media->size / 1024, 1) }} KB
                                        @else
                                            {{ number_format($media->size / (1024 * 1024), 1) }} MB
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            @if($media->dimensions && is_array($media->dimensions) && count($media->dimensions) >= 2)
                                <div class="meta-item">
                                    <div class="meta-label">Dimensions</div>
                                    <div class="meta-value">
                                        {{ $media->dimensions[0] }} × {{ $media->dimensions[1] }} px
                                    </div>
                                </div>
                            @endif
                            
                            @if($media->type === 'video' && $media->hasCustomProperty('video_url'))
                                <div class="meta-item">
                                    <div class="meta-label">Source URL</div>
                                    <div class="meta-value">
                                        <a href="{{ $media->getCustomProperty('video_url') }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 100%;">
                                            {{ $media->getCustomProperty('video_url') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="meta-item">
                                <div class="meta-label">Uploaded</div>
                                <div class="meta-value">
                                    {{ $media->created_at->format('F j, Y \a\t g:i a') }}
                                </div>
                            </div>
                            
                            <div class="meta-item">
                                <div class="meta-label">Last Updated</div>
                                <div class="meta-value">
                                    {{ $media->updated_at->format('F j, Y \a\t g:i a') }}
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-3 border-top">
                                <a href="{{ $media->getUrl() }}" 
                                   class="btn btn-outline-primary w-100 mb-2" 
                                   target="_blank"
                                   download>
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                                
                                <div class="btn-group w-100">
                                    <a href="{{ route('media.edit', $media) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('media.destroy', $media) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.');">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
