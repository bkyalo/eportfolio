@extends('layouts.admin')

@section('title', 'Upload Media')

@push('styles')
<style>
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 1.5rem;
    }
    .upload-area:hover {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }
    .upload-area i {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
        display: block;
    }
    .file-info {
        margin-top: 1rem;
        font-size: 0.875rem;
        color: #6c757d;
    }
    #file-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 1rem auto;
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Upload Media</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data" id="media-upload-form" onsubmit="return submitMediaForm(event)">
                        @csrf
                        
                        <div class="mb-4">
                            <div class="upload-area" id="upload-area">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <h5>Drag & drop files here or click to browse</h5>
                                <p class="text-muted">Supports JPG, PNG, GIF, WebP, MP4, MOV, AVI, WMV (Max 100MB)</p>
                                <input type="file" name="file" id="file-input" class="d-none" accept="image/*,video/*">
                                <div id="file-preview-container">
                                    <img id="file-preview" class="img-fluid rounded">
                                </div>
                                <div id="file-info" class="file-info"></div>
                            </div>
                            
                            <div class="text-center">
                                <p class="mb-2">- OR -</p>
                                <div class="form-group">
                                    <label for="video_url" class="form-label">Enter Video URL</label>
                                    <input type="url" class="form-control" id="video_url" name="video_url" 
                                           placeholder="https://www.youtube.com/watch?v=...">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           id="is_visible" name="is_visible" value="1" checked>
                                    <label class="form-check-label" for="is_visible">Visible to visitors</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           id="is_featured" name="is_featured" value="1">
                                    <label class="form-check-label" for="is_featured">Mark as featured</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('media.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="submit-button">
                                <i class="fas fa-upload me-1"></i> Upload Media
                            </button>
                            <button class="btn btn-primary d-none" type="button" disabled id="loading-button">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Uploading...
                            </button>
                        </div>
                        <div class="alert alert-success mt-3 d-none" id="success-message"></div>
                        <div class="alert alert-danger mt-3 d-none" id="error-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('file-input');
        const filePreview = document.getElementById('file-preview');
        const fileInfo = document.getElementById('file-info');
        const videoUrlInput = document.getElementById('video_url');
        const form = document.getElementById('media-upload-form');
        
        // Handle drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            uploadArea.classList.add('border-primary');
            uploadArea.style.backgroundColor = '#f8f9fa';
        }
        
        function unhighlight() {
            uploadArea.classList.remove('border-primary');
            uploadArea.style.backgroundColor = '';
        }
        
        // Handle dropped files
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        // Handle click to select files
        uploadArea.addEventListener('click', () => {
            fileInput.click();
        });
        
        // Handle file selection
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
        
        // Handle video URL input
        videoUrlInput.addEventListener('input', function() {
            if (this.value) {
                fileInput.disabled = true;
                // Extract video ID if it's a YouTube or Vimeo URL
                const videoId = extractVideoId(this.value);
                if (videoId) {
                    updateFileInfo({
                        name: 'Video from URL',
                        size: 0,
                        type: 'video/url',
                        videoId: videoId
                    });
                }
            } else {
                fileInput.disabled = false;
                resetFileInfo();
            }
        });
        
        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv'];
                if (!validTypes.includes(file.type)) {
                    alert('Invalid file type. Please upload an image or video file.');
                    return;
                }
                
                // Validate file size (100MB max)
                const maxSize = 100 * 1024 * 1024; // 100MB in bytes
                if (file.size > maxSize) {
                    alert('File is too large. Maximum size is 100MB.');
                    return;
                }
                
                // Update file info
                updateFileInfo(file);
                
                // Show preview for images
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.src = e.target.result;
                        filePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    filePreview.style.display = 'none';
                }
                
                // Disable video URL input
                videoUrlInput.disabled = true;
                videoUrlInput.value = '';
            }
        }
        
        function updateFileInfo(file) {
            let fileSize = '';
            if (file.size) {
                if (file.size < 1024 * 1024) {
                    fileSize = (file.size / 1024).toFixed(1) + ' KB';
                } else {
                    fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                }
            }
            
            fileInfo.innerHTML = `
                <strong>${file.name || 'Video from URL'}</strong><br>
                ${file.type || 'video/url'} • ${fileSize || 'N/A'}
            `;
        }
        
        function resetFileInfo() {
            fileInfo.innerHTML = '';
            filePreview.style.display = 'none';
            fileInput.value = '';
        }
        
        function extractVideoId(url) {
            // YouTube video ID extraction
            const ytMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
            if (ytMatch && ytMatch[1]) {
                return { platform: 'youtube', id: ytMatch[1] };
            }
            
            // Vimeo video ID extraction
            const vimeoMatch = url.match(/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)(\d+)/);
            if (vimeoMatch && vimeoMatch[1]) {
                return { platform: 'vimeo', id: vimeoMatch[1] };
            }
            
            return null;
        }
        
        // Handle form submission with AJAX
        function submitMediaForm(e) {
            e.preventDefault();
            
            // Reset messages
            document.getElementById('success-message').classList.add('d-none');
            document.getElementById('error-message').classList.add('d-none');
            
            // Show loading state
            document.getElementById('submit-button').classList.add('d-none');
            document.getElementById('loading-button').classList.remove('d-none');
            
            // Get form data
            const form = document.getElementById('media-upload-form');
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading state
                document.getElementById('submit-button').classList.remove('d-none');
                document.getElementById('loading-button').classList.add('d-none');
                
                if (data.success) {
                    // Show success message
                    const successMessage = document.getElementById('success-message');
                    successMessage.textContent = data.message || 'Media uploaded successfully!';
                    successMessage.classList.remove('d-none');
                    
                    // Reset form
                    form.reset();
                    resetFileInfo();
                    
                    // Scroll to top
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    
                    // Optionally, you can update the media grid here if you want to show the new item
                    // without refreshing the page
                } else {
                    throw new Error(data.message || 'An error occurred');
                }
            })
            .catch(error => {
                // Hide loading state
                document.getElementById('submit-button').classList.remove('d-none');
                document.getElementById('loading-button').classList.add('d-none');
                
                // Show error message
                const errorMessage = document.getElementById('error-message');
                errorMessage.textContent = error.message || 'An error occurred while uploading the media.';
                errorMessage.classList.remove('d-none');
                
                // Scroll to error
                window.scrollTo({ top: errorMessage.offsetTop - 20, behavior: 'smooth' });
            });
            
            return false;
        }
        
        // Form validation
        form.addEventListener('submit', submitMediaForm);
    });
</script>
@endpush
@endsection
