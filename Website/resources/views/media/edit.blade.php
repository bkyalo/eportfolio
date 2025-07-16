@extends('layouts.admin')

@section('title', 'Edit Media - ' . $media->title)

@push('styles')
<style>
    .media-preview {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        margin-bottom: 1.5rem;
        background: #000;
        border-radius: 0.5rem;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .media-info {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .media-info-item {
        margin-bottom: 0.5rem;
    }
    .media-info-label {
        font-weight: 600;
        color: #495057;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Media</h4>
                    <form action="{{ route('media.destroy', $media) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this item? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    @if($media->type === 'image')
                        <div class="text-center">
                            <img src="{{ $media->getUrl() }}" alt="{{ $media->title }}" class="media-preview img-fluid">
                        </div>
                    @elseif($media->type === 'video' && $media->hasCustomProperty('video_url'))
                        <div class="video-container">
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
                                <iframe src="{{ $embedUrl }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-center text-white p-4">
                                        <i class="fas fa-video fa-3x mb-3"></i>
                                        <p class="mb-0">Video preview not available</p>
                                        <a href="{{ $videoUrl }}" target="_blank" class="text-white text-decoration-underline">
                                            View on source
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="media-info">
                        <div class="media-info-item">
                            <span class="media-info-label">Type:</span> 
                            {{ ucfirst($media->type) }}
                        </div>
                        @if($media->mime_type)
                            <div class="media-info-item">
                                <span class="media-info-label">MIME Type:</span> 
                                {{ $media->mime_type }}
                            </div>
                        @endif
                        @if($media->size)
                            <div class="media-info-item">
                                <span class="media-info-label">Size:</span> 
                                @if($media->size < 1024 * 1024)
                                    {{ number_format($media->size / 1024, 1) }} KB
                                @else
                                    {{ number_format($media->size / (1024 * 1024), 1) }} MB
                                @endif
                            </div>
                        @endif
                        @if($media->dimensions && is_array($media->dimensions) && count($media->dimensions) >= 2)
                            <div class="media-info-item">
                                <span class="media-info-label">Dimensions:</span> 
                                {{ $media->dimensions[0] }} × {{ $media->dimensions[1] }} px
                            </div>
                        @endif
                        <div class="media-info-item">
                            <span class="media-info-label">Uploaded:</span> 
                            {{ $media->created_at->format('F j, Y \a\t g:i a') }}
                        </div>
                    </div>
                    
                    <form action="{{ route('media.update', $media) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $media->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $media->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           id="is_visible" name="is_visible" value="1" 
                                           {{ old('is_visible', $media->is_visible) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_visible">Visible to visitors</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           id="is_featured" name="is_featured" value="1"
                                           {{ old('is_featured', $media->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Mark as featured</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('media.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Gallery
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
