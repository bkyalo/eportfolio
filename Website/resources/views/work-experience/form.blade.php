@if(isset($workExperience))
    @php $isEdit = true; @endphp
    @php $action = route('work-experience.update', $workExperience); @endphp
    @method('PUT')
@else
    @php $isEdit = false; @endphp
    @php $action = route('work-experience.store'); @endphp
@endif

@csrf

<div class="row mb-3">
    <div class="col-md-6">
        <label for="role" class="form-label">Role *</label>
        <input type="text" 
               class="form-control @error('role') is-invalid @enderror" 
               id="role" 
               name="role" 
               value="{{ old('role', $workExperience->role ?? '') }}" 
               required>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6">
        <label for="company" class="form-label">Company *</label>
        <input type="text" 
               class="form-control @error('company') is-invalid @enderror" 
               id="company" 
               name="company" 
               value="{{ old('company', $workExperience->company ?? '') }}" 
               required>
        @error('company')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="location" class="form-label">Location *</label>
        <input type="text" 
               class="form-control @error('location') is-invalid @enderror" 
               id="location" 
               name="location" 
               value="{{ old('location', $workExperience->location ?? '') }}" 
               required>
        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-3">
        <label for="start_date" class="form-label">Start Date *</label>
        <input type="date" 
               class="form-control @error('start_date') is-invalid @enderror" 
               id="start_date" 
               name="start_date" 
               value="{{ old('start_date', isset($workExperience->start_date) ? $workExperience->start_date->format('Y-m-d') : '') }}" 
               required>
        @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-3">
        <label for="end_date" class="form-label">End Date</label>
        <div class="input-group">
            <input type="date" 
                   class="form-control @error('end_date') is-invalid @enderror" 
                   id="end_date" 
                   name="end_date" 
                   value="{{ old('end_date', isset($workExperience->end_date) ? $workExperience->end_date->format('Y-m-d') : '') }}"
                   {{ isset($workExperience) && $workExperience->is_current ? 'disabled' : '' }}>
            <div class="input-group-text">
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="is_current" 
                           name="is_current"
                           {{ old('is_current', isset($workExperience) && $workExperience->is_current ? 'checked' : '') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_current">
                        Current
                    </label>
                </div>
            </div>
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" 
              name="description" 
              rows="4">{{ old('description', $workExperience->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <div class="form-check form-switch">
        <input class="form-check-input" 
               type="checkbox" 
               id="is_visible" 
               name="is_visible" 
               value="1"
               {{ old('is_visible', isset($workExperience) ? $workExperience->is_visible : true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_visible">
            Visible on website
        </label>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('work-experience.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i> {{ $isEdit ? 'Update' : 'Save' }}
    </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isCurrentCheckbox = document.getElementById('is_current');
    const endDateInput = document.getElementById('end_date');
    
    isCurrentCheckbox.addEventListener('change', function() {
        if (this.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
        } else {
            endDateInput.disabled = false;
        }
    });
    
    // Initialize the disabled state on page load
    if (isCurrentCheckbox.checked) {
        endDateInput.disabled = true;
    }
});
</script>
@endpush
