@extends('layouts.admin')

@section('title', 'Edit Skill: ' . $skill->name)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('skills.index') }}">Skills</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit: {{ $skill->name }}</li>
                </ol>
            </nav>
            <h1>Edit Skill: <small class="text-muted">{{ $skill->name }}</small></h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('skills.update', $skill) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $skill->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="skill_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('skill_category_id') is-invalid @enderror" 
                                    id="skill_category_id" name="skill_category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" 
                                        {{ old('skill_category_id', $skill->skill_category_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('skill_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="2">{{ old('description', $skill->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="proficiency" class="form-label">Proficiency <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="range" class="form-range" 
                                       id="proficiency" name="proficiency" 
                                       min="0" max="100" step="5" 
                                       value="{{ old('proficiency', $skill->proficiency) }}" 
                                       oninput="updateProficiencyValue(this.value)">
                                <span class="input-group-text w-auto" id="proficiencyValue">{{ old('proficiency', $skill->proficiency) }}%</span>
                            </div>
                            @error('proficiency')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="order" class="form-label">Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $skill->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 pt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_featured" name="is_featured" value="1" 
                                       {{ old('is_featured', $skill->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $skill->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('skills.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Skills
                    </a>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Skill
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update the proficiency value display
    function updateProficiencyValue(value) {
        document.getElementById('proficiencyValue').textContent = value + '%';
    }

    // Initialize the proficiency value on page load
    document.addEventListener('DOMContentLoaded', function() {
        const proficiencyInput = document.getElementById('proficiency');
        updateProficiencyValue(proficiencyInput.value);
    });
</script>
@endpush
@endsection
