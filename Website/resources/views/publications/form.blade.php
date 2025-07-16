@if(isset($publication) && $publication->image_path)
    @push('styles')
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
        }
        .image-preview img {
            max-width: 200px;
            max-height: 300px;
            border-radius: 4px;
        }
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0,0,0,0.7);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
    @endpush
@endif

<div class="mb-3">
    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" 
           id="title" name="title" 
           value="{{ old('title', $publication->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                   id="isbn" name="isbn" 
                   value="{{ old('isbn', $publication->isbn ?? '') }}">
            @error('isbn')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="url" class="form-control @error('url') is-invalid @enderror" 
                   id="url" name="url" 
                   value="{{ old('url', $publication->url ?? '') }}">
            @error('url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" name="description" 
              rows="3">{{ old('description', $publication->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label">Cover Image</label>
    
    @if(isset($publication) && $publication->image_path)
        <div class="image-preview mb-3">
            <img src="{{ $publication->image_url }}" alt="{{ $publication->title }}" class="img-thumbnail">
            <div class="remove-image" onclick="document.getElementById('remove-image').value = '1'; this.parentElement.style.display = 'none';">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <input type="hidden" id="remove-image" name="remove_image" value="0">
    @endif
    
    <input type="file" class="form-control @error('image') is-invalid @enderror" 
           id="image" name="image" accept="image/*">
    <div class="form-text">Recommended size: 300x450px. Max file size: 2MB.</div>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i> Save Publication
    </button>
</div>
