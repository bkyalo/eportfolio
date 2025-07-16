@extends('layouts.admin')

@section('title', 'Work Experience')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Work Experience</h1>
        <a href="{{ route('work-experience.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Experience
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($workExperiences->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Role</th>
                                <th>Company</th>
                                <th>Period</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach($workExperiences as $experience)
                                <tr data-id="{{ $experience->id }}">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-grip-vertical text-muted me-3 handle" style="cursor: move;"></i>
                                            <div>
                                                <h6 class="mb-0">{{ $experience->role }}</h6>
                                                <small class="text-muted">{{ $experience->location }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $experience->company }}</td>
                                    <td>
                                        {{ $experience->date_range }}
                                        @if($experience->is_visible)
                                            <span class="badge bg-success ms-2">Visible</span>
                                        @else
                                            <span class="badge bg-secondary ms-2">Hidden</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('work-experience.edit', $experience) }}" 
                                               class="btn btn-sm btn-outline-secondary"
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('work-experience.toggle-visibility', $experience) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to {{ $experience->is_visible ? 'hide' : 'show' }} this experience?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-{{ $experience->is_visible ? 'warning' : 'info' }}"
                                                        data-bs-toggle="tooltip" 
                                                        title="{{ $experience->is_visible ? 'Hide' : 'Show' }}">
                                                    <i class="fas fa-eye{{ $experience->is_visible ? '-slash' : '' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('work-experience.destroy', $experience) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this experience?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete">
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
                <div class="text-center p-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-briefcase fa-3x opacity-25"></i>
                    </div>
                    <h5>No work experience added yet</h5>
                    <p class="text-muted">Get started by adding your first work experience</p>
                    <a href="{{ route('work-experience.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i> Add Experience
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Make table rows sortable
    $("#sortable").sortable({
        handle: ".handle",
        update: function(event, ui) {
            var order = [];
            $('#sortable tr').each(function(index) {
                order.push({
                    id: $(this).data('id'),
                    position: index + 1
                });
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('work-experience.update-order') }}",
                data: {
                    order: order.map(item => item.id),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Optional: Show a success message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-3';
                        alert.style.zIndex = '1060';
                        alert.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i> Order updated successfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        document.body.appendChild(alert);
                        
                        // Auto-dismiss after 3 seconds
                        setTimeout(() => {
                            const bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        }, 3000);
                    }
                }
            });
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.handle {
    cursor: move;
    opacity: 0.5;
    transition: opacity 0.2s;
}

.handle:hover {
    opacity: 1;
}

.ui-sortable-helper {
    background-color: #f8f9fa;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.ui-sortable-helper td {
    border-bottom: 1px solid #dee2e6;
}
</style>
@endpush
@endsection
