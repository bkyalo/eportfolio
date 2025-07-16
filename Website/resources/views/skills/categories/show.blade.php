@extends('layouts.admin')

@section('title', 'Skills in ' . $skillCategory->name)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('skill-categories.index') }}">Skill Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $skillCategory->name }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h1>Skills in {{ $skillCategory->name }}</h1>
                <div>
                    <a href="{{ route('skills.create', ['category_id' => $skillCategory->id]) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Skill
                    </a>
                    <a href="{{ route('skill-categories.edit', $skillCategory) }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-edit"></i> Edit Category
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

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Category Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>{{ $skillCategory->name }}</h4>
                    @if($skillCategory->description)
                        <p class="text-muted">{{ $skillCategory->description }}</p>
                    @endif
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge {{ $skillCategory->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                        {{ $skillCategory->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <div class="mt-2">
                        <span class="text-muted">Order: {{ $skillCategory->order }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Skills ({{ $skillCategory->skills->count() }})</h5>
                <a href="{{ route('skills.create', ['category_id' => $skillCategory->id]) }}" 
                   class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Add Skill
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($skillCategory->skills->isNotEmpty())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Proficiency</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skillCategory->skills->sortBy('order') as $skill)
                                <tr>
                                    <td>{{ $skill->name }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $this->getProficiencyColor($skill->proficiency) }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $skill->proficiency }}%" 
                                                 aria-valuenow="{{ $skill->proficiency }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ $skill->proficiency }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $skill->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $skill->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        @if($skill->is_featured)
                                            <span class="badge bg-warning text-dark">Featured</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('skills.edit', $skill) }}" 
                                               class="btn btn-sm btn-outline-secondary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('skills.destroy', $skill) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this skill?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    No skills found in this category. 
                    <a href="{{ route('skills.create', ['category_id' => $skillCategory->id]) }}">Add a new skill</a>.
                </div>
            @endif
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
