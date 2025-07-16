@extends('layouts.admin')

@section('title', $publication->title)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $publication->title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('publications.index') }}">Publications</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $publication->title }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('publications.edit', $publication) }}" class="btn btn-outline-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    @if($publication->image_path)
                        <img src="{{ $publication->image_url }}" 
                             alt="{{ $publication->title }}" 
                             class="img-fluid rounded mb-3" 
                             style="max-height: 400px; width: auto;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 300px; width: 100%;">
                            <div class="text-muted">No image available</div>
                        </div>
                    @endif
                    
                    @if($publication->url)
                        <a href="{{ $publication->url }}" 
                           class="btn btn-primary w-100 mb-2" 
                           target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i> View Publication
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Details</h5>
                        <hr class="mt-2">
                        <dl class="row">
                            <dt class="col-sm-3">Title</dt>
                            <dd class="col-sm-9">{{ $publication->title }}</dd>
                            
                            @if($publication->isbn)
                                <dt class="col-sm-3">ISBN</dt>
                                <dd class="col-sm-9">{{ $publication->isbn }}</dd>
                            @endif
                            
                            @if($publication->url)
                                <dt class="col-sm-3">URL</dt>
                                <dd class="col-sm-9">
                                    <a href="{{ $publication->url }}" target="_blank">
                                        {{ $publication->url }}
                                    </a>
                                </dd>
                            @endif
                            
                            <dt class="col-sm-3">Created</dt>
                            <dd class="col-sm-9">{{ $publication->created_at->format('M d, Y') }}</dd>
                            
                            <dt class="col-sm-3">Last Updated</dt>
                            <dd class="col-sm-9">{{ $publication->updated_at->format('M d, Y') }}</dd>
                        </dl>
                    </div>
                    
                    @if($publication->description)
                        <div class="mb-4">
                            <h5>Description</h5>
                            <hr class="mt-2">
                            <div class="text-muted">
                                {!! nl2br(e($publication->description)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
