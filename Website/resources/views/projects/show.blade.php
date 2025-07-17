@extends('layouts.admin')

@section('title', 'View Project: ' . $project->title)

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $project->title }}</h1>
            <div class="d-flex align-items-center gap-2 mt-2">
                <span class="badge {{ $project->status === 'complete' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                    {{ str_replace('_', ' ', ucfirst($project->status)) }}
                </span>
                @if($project->is_small_project)
                    <span class="badge bg-info-subtle text-info">
                        Small Project
                    </span>
                @endif
                @if($project->is_live)
                    <span class="badge bg-primary-subtle text-primary">
                        <i class="fas fa-check-circle me-1"></i> Live
                    </span>
                @endif
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Project
            </a>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Projects
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        @if($project->image_path)
            <img src="{{ asset('storage/' . $project->image_path) }}" 
                 class="card-img-top" 
                 alt="{{ $project->title }}"
                 style="max-height: 400px; object-fit: cover;">
        @endif
        <div class="card-body">
            <h5 class="card-title">Project Details</h5>
            <div class="d-flex gap-3 mb-3">
                @if($project->is_live && $project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i> Live Demo
                    </a>
                @endif
                @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-dark">
                        <i class="fab fa-github me-1"></i> View on GitHub
                    </a>
                @endif
            </div>
            
            <div class="mb-4">
                <h6>Description</h6>
                <p class="text-muted">{!! nl2br(e($project->brief_description)) !!}</p>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="w-25">Technologies</th>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(explode(',', $project->stack) as $tech)
                                            <span class="badge bg-primary-subtle text-primary">
                                                {{ trim($tech) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge {{ $project->status === 'complete' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                        {{ str_replace('_', ' ', ucfirst($project->status)) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            @if($project->live_url)
                                <tr>
                                    <th class="w-25">Live URL</th>
                                    <td>
                                        <a href="{{ $project->live_url }}" target="_blank" class="text-decoration-none">
                                            {{ $project->live_url }}
                                            <i class="fas fa-external-link-alt ms-1 small"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            @if($project->github_url)
                                <tr>
                                    <th>GitHub</th>
                                    <td>
                                        <a href="{{ $project->github_url }}" target="_blank" class="text-decoration-none">
                                            {{ $project->github_url }}
                                            <i class="fas fa-external-link-alt ms-1 small"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>Created</th>
                                <td>{{ $project->created_at->format('F j, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $project->updated_at->format('F j, Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="d-flex justify-content-between">
        <div>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Projects
            </a>
        </div>
        <div>
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Project
            </a>
            <form id="delete-form" action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" 
                        onclick="if(confirm('Are you sure you want to delete this project? This action cannot be undone.')) { this.form.submit(); }" 
                        class="btn btn-outline-danger ms-2">
                    <i class="fas fa-trash me-1"></i> Delete Project
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
