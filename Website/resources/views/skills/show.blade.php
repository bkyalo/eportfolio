@extends('layouts.admin')

@section('title', 'Skill: ' . $skill->name)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('skills.index') }}">Skills</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('skill-categories.show', $skill->category) }}">{{ $skill->category->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $skill->name }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ $skill->name }}</h1>
                <div>
                    <a href="{{ route('skills.edit', $skill) }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('skills.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Skills
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Skill Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $skill->name }}</dd>

                        <dt class="col-sm-3">Category</dt>
                        <dd class="col-sm-9">
                            <a href="{{ route('skill-categories.show', $skill->category) }}">
                                {{ $skill->category->name }}
                            </a>
                        </dd>

                        @if($skill->description)
                            <dt class="col-sm-3">Description</dt>
                            <dd class="col-sm-9">{{ $skill->description }}</dd>
                        @endif

                        <dt class="col-sm-3">Proficiency</dt>
                        <dd class="col-sm-9">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-{{ $this->getProficiencyColor($skill->proficiency) }}" 
                                     role="progressbar" 
                                     style="width: {{ $skill->proficiency }}%; font-weight: 500;" 
                                     aria-valuenow="{{ $skill->proficiency }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $skill->proficiency }}%
                                </div>
                            </div>
                        </dd>

                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge {{ $skill->is_active ? 'bg-success' : 'bg-secondary' }} me-2">
                                {{ $skill->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($skill->is_featured)
                                <span class="badge bg-warning text-dark">Featured</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Order</dt>
                        <dd class="col-sm-9">{{ $skill->order }}</dd>

                        <dt class="col-sm-3">Created</dt>
                        <dd class="col-sm-9">{{ $skill->created_at->format('M j, Y') }}</dd>

                        <dt class="col-sm-3">Last Updated</dt>
                        <dd class="col-sm-9">{{ $skill->updated_at->format('M j, Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('skills.edit', $skill) }}" class="btn btn-primary mb-2">
                            <i class="fas fa-edit me-1"></i> Edit Skill
                        </a>
                        
                        <form action="{{ route('skills.destroy', $skill) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this skill? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete Skill
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $skill->category->name }}</h6>
                    @if($skill->category->description)
                        <p class="text-muted">{{ $skill->category->description }}</p>
                    @else
                        <p class="text-muted">No description available.</p>
                    @endif
                    <a href="{{ route('skill-categories.show', $skill->category) }}" class="btn btn-sm btn-outline-primary">
                        View Category
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Helper function to determine proficiency color
    function getProficiencyColor(proficiency) {
        if (proficiency >= 80) return 'success';
        if (proficiency >= 60) return 'primary';
        if (proficiency >= 40) return 'info';
        if (proficiency >= 20) return 'warning';
        return 'danger';
    }
</script>
@endpush
@endsection
