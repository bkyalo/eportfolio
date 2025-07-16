@extends('layouts.admin')

@section('title', 'Publications')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Publications</h1>
        <a href="{{ route('publications.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Publication
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
            @if($publications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Cover</th>
                                <th>Title</th>
                                <th>ISBN</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publications as $publication)
                                <tr>
                                    <td class="ps-4">
                                        <img src="{{ $publication->image_url }}" 
                                             alt="{{ $publication->title }}" 
                                             class="rounded" 
                                             style="width: 50px; height: 70px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $publication->title }}</h6>
                                        <small class="text-muted">
                                            {{ Str::limit($publication->description, 50) }}
                                        </small>
                                    </td>
                                    <td>{{ $publication->isbn ?? 'N/A' }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            @if($publication->url)
                                                <a href="{{ $publication->url }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   target="_blank"
                                                   data-bs-toggle="tooltip" 
                                                   title="View Publication">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('publications.edit', $publication) }}" 
                                               class="btn btn-sm btn-outline-secondary"
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('publications.destroy', $publication) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this publication?');">
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
                <div class="card-footer bg-white border-top-0">
                    {{ $publications->links() }}
                </div>
            @else
                <div class="text-center p-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-book-open fa-3x opacity-25"></i>
                    </div>
                    <h5>No publications found</h5>
                    <p class="text-muted">Get started by adding your first publication</p>
                    <a href="{{ route('publications.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i> Add Publication
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
