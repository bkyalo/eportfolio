@extends('layouts.admin')

@section('title', 'Manage Projects')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">My Projects</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Project
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Project</th>
                            <th>Status</th>
                            <th>Stack</th>
                            <th>Links</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($project->image_path)
                                            <img src="{{ asset('storage/' . $project->image_path) }}" 
                                                 alt="{{ $project->title }}" 
                                                 class="rounded me-3" 
                                                 style="width: 60px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 60px; height: 40px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $project->title }}</h6>
                                            <small class="text-muted">{{ Str::limit($project->brief_description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'complete' => 'success',
                                            'in_progress' => 'warning',
                                            'planned' => 'info'
                                        ];
                                        $statusColor = $statusColors[$project->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} text-uppercase">
                                        {{ str_replace('_', ' ', $project->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1" style="max-width: 150px;">
                                        @foreach(explode(',', $project->stack) as $tech)
                                            <span class="badge bg-light text-dark">{{ trim($tech) }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($project->is_live && $project->live_url)
                                            <a href="{{ $project->live_url }}" target="_blank" class="btn btn-sm btn-outline-primary" 
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="View Live Demo">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                        @if($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" class="btn btn-sm btn-outline-dark"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="View on GitHub">
                                                <i class="fab fa-github"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('projects.public.show', $project) }}" 
                                           class="btn btn-sm btn-outline-secondary"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this project?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="mb-2">No projects found</h5>
                                        <p class="text-muted mb-3">Get started by creating a new project</p>
                                        <a href="{{ route('projects.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i> Create Project
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($projects->hasPages())
        <div class="mt-4">
            {{ $projects->withQueryString()->links() }}
        </div>
    @endif
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
