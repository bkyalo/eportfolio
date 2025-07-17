@extends('layouts.admin')

@section('title', 'Edit Project: ' . $project->title)

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Project: {{ $project->title }}</h1>
        <div>
            <form id="delete-form" action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" 
                        onclick="if(confirm('Are you sure you want to delete this project? This action cannot be undone.')) { this.form.submit(); }" 
                        class="btn btn-outline-danger">
                    <i class="fas fa-trash me-1"></i> Delete Project
                </button>
            </form>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Projects
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $project->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Stack -->
                        <div class="mb-3">
                            <label for="stack" class="form-label">
                                Technologies Used <span class="text-danger">*</span> 
                                <small class="text-muted">(comma separated)</small>
                            </label>
                            <input type="text" class="form-control @error('stack') is-invalid @enderror" 
                                   id="stack" name="stack" value="{{ old('stack', $project->stack) }}" 
                                   placeholder="e.g., Laravel, Vue.js, Bootstrap 5" required>
                            @error('stack')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Live URL -->
                        <div class="mb-3">
                            <label for="live_url" class="form-label">Live URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                <input type="url" class="form-control @error('live_url') is-invalid @enderror" 
                                       id="live_url" name="live_url" value="{{ old('live_url', $project->live_url) }}"
                                       placeholder="https://example.com">
                            </div>
                            @error('live_url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- GitHub URL -->
                        <div class="mb-3">
                            <label for="github_url" class="form-label">GitHub URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-github"></i></span>
                                <input type="url" class="form-control @error('github_url') is-invalid @enderror" 
                                       id="github_url" name="github_url" value="{{ old('github_url', $project->github_url) }}"
                                       placeholder="https://github.com/username/repo">
                            </div>
                            @error('github_url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_in_progress" 
                                           value="in_progress" {{ old('status', $project->status) === 'in_progress' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_in_progress">
                                        <span class="badge bg-warning-subtle text-warning">In Progress</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_complete" 
                                           value="complete" {{ old('status', $project->status) === 'complete' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_complete">
                                        <span class="badge bg-success-subtle text-success">Complete</span>
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Checkboxes -->
                        <div class="mb-4">
                            <div class="form-check form-switch mb-2">
                                <input type="hidden" name="is_live" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       id="is_live" name="is_live" value="1" 
                                       {{ old('is_live', $project->is_live) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_live">Project is live</label>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_small_project" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       id="is_small_project" name="is_small_project" value="1" 
                                       {{ old('is_small_project', $project->is_small_project) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_small_project">
                                    Small Project (will be displayed differently)
                                </label>
                            </div>
                        </div>
                        
                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Project Image</label>
                            
                            @if($project->image_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $project->image_path) }}" 
                                         alt="{{ $project->title }}" 
                                         class="img-thumbnail d-block" 
                                         style="max-height: 150px; width: auto;">
                                    <small class="text-muted">Current image</small>
                                </div>
                            @endif
                            
                            <input class="form-control @error('image') is-invalid @enderror" 
                                   type="file" id="image" name="image" accept="image/*">
                            <div class="form-text">
                                @if($project->image_path)
                                    Upload a new image to replace the current one. 
                                @endif
                                Recommended size: 800x600px (2MB max)
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-2 text-center d-none">
                                <img src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <label for="brief_description" class="form-label">
                        Brief Description <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('brief_description') is-invalid @enderror" 
                              id="brief_description" name="brief_description" 
                              rows="4" required>{{ old('brief_description', $project->brief_description) }}</textarea>
                    <div class="form-text">A short description of your project (max 500 characters).</div>
                    @error('brief_description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.querySelector('#imagePreview img');
            const previewContainer = document.getElementById('imagePreview');
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            
            reader.readAsDataURL(file);
        }
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
