@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.5rem;
    }
    .recent-item {
        transition: background-color 0.2s;
        padding: 0.75rem 1.25rem;
    }
    .recent-item:hover {
        background-color: #f8f9fa;
    }
    .project-status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35em 0.65em;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> New Project
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Projects -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">Total Projects</h6>
                            <h2 class="mb-0">{{ $projects->count() }}</h2>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Projects -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">Completed</h6>
                            <h2 class="mb-0">{{ $projects->where('status', 'complete')->count() }}</h2>
                            <div class="text-success small mt-1">
                                @if($projects->count() > 0)
                                    {{ round(($projects->where('status', 'complete')->count() / $projects->count()) * 100) }}% of total
                                @else
                                    0% of total
                                @endif
                            </div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress Projects -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">In Progress</h6>
                            <h2 class="mb-0">{{ $projects->where('status', 'in_progress')->count() }}</h2>
                            <div class="text-warning small mt-1">
                                @if($projects->count() > 0)
                                    {{ round(($projects->where('status', 'in_progress')->count() / $projects->count()) * 100) }}% of total
                                @else
                                    0% of total
                                @endif
                            </div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Small Projects -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">Small Projects</h6>
                            <h2 class="mb-0">{{ $projects->where('is_small_project', true)->count() }}</h2>
                            <div class="text-info small mt-1">
                                @if($projects->count() > 0)
                                    {{ round(($projects->where('is_small_project', true)->count() / $projects->count()) * 100) }}% of total
                                @else
                                    0% of total
                                @endif
                            </div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Overview and Messages -->
    <div class="row g-4 mb-4">
        <!-- Projects Overview Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Projects Overview</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="projectsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Messages</h5>
                    <a href="{{ route('contact.submissions.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-purple bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-envelope text-purple fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-0">{{ $unreadCount }} {{ Str::plural('New', $unreadCount) }}</h2>
                            <p class="text-muted mb-0">unread message{{ $unreadCount != 1 ? 's' : '' }}</p>
                        </div>
                    </div>
                    @if($recentSubmissions->count() > 0)
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Recent Messages</h6>
                        <div class="list-group list-group-flush">
                            @foreach($recentSubmissions->take(3) as $submission)
                                <a href="{{ route('contact.submissions.show', $submission) }}" class="list-group-item list-group-item-action border-0 px-0 py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-truncate me-2">
                                            <strong>{{ $submission->name }}</strong>
                                            <div class="text-muted small text-truncate">{{ $submission->subject ?? 'No subject' }}</div>
                                        </div>
                                        <small class="text-muted" data-bs-toggle="tooltip" title="{{ $submission->created_at->format('M d, Y H:i') }}">
                                            {{ $submission->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Projects</h5>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Project</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProjects as $project)
                                    <tr class="recent-project-item">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($project->image_path)
                                                    <img src="{{ asset('storage/' . $project->image_path) }}" 
                                                         alt="{{ $project->title }}" 
                                                         class="rounded me-3" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $project->title }}</h6>
                                                    <small class="text-muted">{{ Str::limit($project->brief_description, 30) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($project->status === 'complete')
                                                <span class="badge bg-success">Complete</span>
                                            @else
                                                <span class="badge bg-warning">In Progress</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span data-bs-toggle="tooltip" title="{{ $project->updated_at->format('M d, Y H:i') }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($project->status === 'complete')
                                            <span class="badge bg-success">Complete</span>
                                        @else
                                            <span class="badge bg-warning">In Progress</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span data-bs-toggle="tooltip" title="{{ $project->updated_at->format('M d, Y H:i') }}">
                                            {{ $project->updated_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.projects.edit', $project) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.projects.show', $project) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               data-bs-toggle="tooltip" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">No projects found. <a href="{{ route('admin.projects.create') }}">Create your first project</a></div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Contact Submissions -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Messages</h5>
                <a href="{{ route('contact.submissions.index') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @if($recentSubmissions->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentSubmissions as $submission)
                            <a href="{{ route('contact.submissions.show', $submission) }}" class="list-group-item list-group-item-action recent-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $submission->name }}</h6>
                                        <p class="text-muted small mb-0">{{ Str::limit($submission->message, 60) }}</p>
                                    </div>
                                    <small class="text-muted" data-bs-toggle="tooltip" title="{{ $submission->created_at->format('M d, Y H:i') }}">
                                        {{ $submission->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-4">
                        <div class="text-muted mb-3">
                            <i class="fas fa-inbox fa-3x opacity-25"></i>
                        </div>
                        <p class="mb-0">No messages yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex">
                        <div class="bg-purple bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-cog text-purple"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Portfolio Settings</h5>
                            <p class="card-text text-muted small">Configure your portfolio appearance and settings</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-external-link-alt me-1"></i> View Public Portfolio
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Projects Chart
        const ctx = document.getElementById('projectsChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total', 'Completed', 'In Progress', 'Small Projects'],
                    datasets: [{
                        label: 'Projects',
                        data: [
                            {{ $projects->count() }},
                            {{ $projects->where('status', 'complete')->count() }},
                            {{ $projects->where('status', 'in_progress')->count() }},
                            {{ $projects->where('is_small_project', true)->count() }}
                        ],
                        backgroundColor: [
                            'rgba(13, 110, 253, 0.7)',
                            'rgba(25, 135, 84, 0.7)',
                            'rgba(255, 193, 7, 0.7)',
                            'rgba(13, 202, 240, 0.7)'
                        ],
                        borderColor: [
                            'rgba(13, 110, 253, 1)',
                            'rgba(25, 135, 84, 1)',
                            'rgba(255, 193, 7, 1)',
                            'rgba(13, 202, 240, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} ${context.parsed.y === 1 ? 'project' : 'projects'}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

@endsection