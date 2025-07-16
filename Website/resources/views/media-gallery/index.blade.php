@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Media Gallery</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-plus me-1"></i> Add Image
                    </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

                    <div class="row" id="media-sortable">
                        @foreach($media as $item)
                            <div class="col-md-3 col-sm-6 mb-4" data-id="{{ $item->id }}">
                                <div class="card h-100">
                                    <img src="{{ $item->getImageUrl() }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->title }}</h5>
                                        @if($item->description)
                                            <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                                        @endif
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $item->getFileSizeInKb() }}</small>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary edit-media" 
                                                        data-id="{{ $item->id }}"
                                                        data-title="{{ $item->title }}"
                                                        data-description="{{ $item->description }}"
                                                        data-published="{{ $item->is_published ? 'true' : 'false' }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger delete-media" data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="uploadForm" action="{{ route('media-gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                        <div class="form-text">Max file size: 10MB. Allowed formats: jpg, jpeg, png, gif, webp</div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" checked>
                        <label class="form-check-label" for="publish">
                            Publish immediately
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="editImagePreview" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                    </div>
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Change Image</label>
                        <input class="form-control" type="file" id="editImage" name="image" accept="image/*">
                        <div class="form-text">Leave empty to keep current image. Max file size: 10MB</div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="publish" id="editPublish" value="1">
                        <label class="form-check-label" for="editPublish">
                            Publish
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this image? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .sortable-ghost {
        opacity: 0.5;
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Sortable
        const sortable = new Sortable(document.getElementById('media-sortable'), {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                const items = Array.from(document.querySelectorAll('#media-sortable [data-id]'));
                const order = items.map((item, index) => ({
                    id: item.getAttribute('data-id'),
                    order: index + 1
                }));

                fetch('{{ route("media-gallery.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ items: order })
                });
            }
        });

        // Handle edit modal
        document.querySelectorAll('.edit-media').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');
                const published = this.getAttribute('data-published') === 'true';
                const imageUrl = this.closest('.card').querySelector('img').src;

                document.getElementById('editForm').action = `/media-gallery/${id}`;
                document.getElementById('editTitle').value = title;
                document.getElementById('editDescription').value = description || '';
                document.getElementById('editPublish').checked = published;
                document.getElementById('editImagePreview').src = imageUrl;

                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        // Handle delete modal
        document.querySelectorAll('.delete-media').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteForm').action = `/media-gallery/${id}`;
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            });
        });

        // Image preview for upload
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // If you want to show preview in upload modal
                    // document.getElementById('uploadPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Image preview for edit
        document.getElementById('editImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('editImagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
