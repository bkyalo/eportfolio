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
                                            <th style="width: 40px;"></th>
                                            <th>Name</th>
                                            <th>Proficiency</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="skills-list-{{ $category->id }}" class="sortable" data-route="{{ route('skills.reorder') }}" data-token="{{ csrf_token() }}">
                                        @foreach($category->skills as $skill)
                                            <tr data-id="{{ $skill->id }}" class="sortable-item">
                                                <td class="sortable-handle" style="cursor: move;"><i class="fas fa-arrows-alt"></i></td>
                                                <td>
                                                    {{ $skill->name }}
                                                    @if($skill->is_featured)
                                                        <span class="badge bg-warning text-dark ms-1">Featured</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                            <div class="progress-bar bg-{{ \App\Models\Skill::getProficiencyColor($skill->proficiency) }}" 
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
                                                <td class="sortable-handle" style="cursor: move;"><i class="fas fa-arrows-alt"></i></td>
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

@push('styles')
<style>
    .sortable {
        min-height: 20px;
    }
    .sortable-item {
        cursor: move;
        transition: all 0.15s ease-in-out;
    }
    .sortable-item.sortable-ghost {
        opacity: 0.5;
        background: #f8f9fa;
    }
    .sortable-handle {
        cursor: move;
        opacity: 0.5;
        transition: opacity 0.2s;
    }
    .sortable-item:hover .sortable-handle {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Initialize sortable on all skill lists
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sortable').forEach(function(element) {
            new Sortable(element, {
                handle: '.sortable-handle',
                ghostClass: 'sortable-ghost',
                animation: 150,
                onEnd: function(evt) {
                    const itemEl = evt.item;
                    const items = Array.from(evt.from.children).map((item, index) => ({
                        id: item.dataset.id,
                        order: index + 1
                    }));
                    
                    // Send the new order to the server
                    fetch(evt.from.dataset.route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': evt.from.dataset.token
                        },
                        body: JSON.stringify({ items: items })
                    });
                }
            });
        });
        
        // Update all progress bars with the appropriate color
        document.querySelectorAll('.progress-bar').forEach(function(bar) {
            const proficiency = parseInt(bar.getAttribute('aria-valuenow'));
            const color = getProficiencyColor(proficiency);
            bar.classList.add('bg-' + color);
        });
    });
    
    // Helper function to determine proficiency color
    function getProficiencyColor(proficiency) {
        if (proficiency >= 80) return 'success';
        if (proficiency >= 50) return 'primary';
        if (proficiency >= 30) return 'warning';
        return 'danger';
    }
</script>
@endpush
@endsection
