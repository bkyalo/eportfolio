@extends('layouts.admin')

@section('title', 'Skill Categories')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Skill Categories</h1>
                <a href="{{ route('skill-categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Category
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Skills</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categories-list" 
                           data-route="{{ route('skill-categories.reorder') }}" 
                           data-token="{{ csrf_token() }}">
                        @forelse($categories as $category)
                            <tr data-id="{{ $category->id }}" class="sortable-item">
                                <td class="sortable-handle" style="cursor: move;">
                                    <i class="fas fa-arrows-alt me-2"></i>
                                    {{ $category->name }}
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $category->skills_count }}</span>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('skills.create', ['category_id' => $category->id]) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="Add Skill">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <a href="{{ route('skill-categories.show', $category) }}" 
                                           class="btn btn-sm btn-outline-info"
                                           title="View Skills">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('skill-categories.edit', $category) }}" 
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('skill-categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No categories found. <a href="{{ route('skill-categories.create') }}">Create one</a>.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .sortable-ghost {
        opacity: 0.5;
        background: #f8f9fa;
    }
    .sortable-item {
        cursor: move;
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
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('categories-list');
        if (el) {
            new Sortable(el, {
                handle: '.sortable-handle',
                ghostClass: 'sortable-ghost',
                animation: 150,
                onEnd: function(evt) {
                    const items = Array.from(evt.from.children).map((item, index) => ({
                        id: item.dataset.id,
                        order: index + 1
                    }));
                    
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
        }
    });
</script>
@endpush
@endsection
