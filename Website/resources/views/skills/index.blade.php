@extends('layouts.admin')

@section('title', 'Skills Management')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Skills Management</h1>
                <div>
                    <a href="{{ route('skill-categories.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    <a href="{{ route('skills.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Skill
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

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="skillsTabs" role="tablist">
                @foreach($categories as $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                id="cat-{{ $category->id }}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#cat-{{ $category->id }}" 
                                type="button" 
                                role="tab" 
                                aria-controls="cat-{{ $category->id }}" 
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $category->name }}
                            <span class="badge bg-secondary ms-1">{{ $category->skills_count }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="skillsTabsContent">
                @foreach($categories as $category)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="cat-{{ $category->id }}" 
                         role="tabpanel" 
                         aria-labelledby="cat-{{ $category->id }}-tab">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">{{ $category->name }} Skills</h5>
                            <a href="{{ route('skills.create', ['category_id' => $category->id]) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i> Add to {{ $category->name }}
                            </a>
                        </div>

                        @if($category->skills->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Proficiency</th>
                                            <th>Status</th>
                                            <th>Order</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category->skills->sortBy('order') as $skill)
                                            <tr>
                                                <td>
                                                    {{ $skill->name }}
                                                    @if($skill->is_featured)
                                                        <span class="badge bg-warning text-dark ms-1">Featured</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                            <div class="progress-bar bg-{{ $this->getProficiencyColor($skill->proficiency) }}" 
                                                                 role="progressbar" 
                                                                 style="width: {{ $skill->proficiency }}%" 
                                                                 aria-valuenow="{{ $skill->proficiency }}" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100">
                                                                {{ $skill->proficiency }}%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $skill->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $skill->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>{{ $skill->order }}</td>
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
                                <a href="{{ route('skills.create', ['category_id' => $category->id]) }}">Add a new skill</a>.
                            </div>
                        @endif
                    </div>
                @endforeach
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
