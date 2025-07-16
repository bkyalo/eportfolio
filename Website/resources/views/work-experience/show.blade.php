@extends('layouts.admin')

@section('title', 'View Work Experience')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Work Experience Details</h5>
                        <div class="btn-group">
                            <a href="{{ route('work-experience.edit', $workExperience) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('work-experience.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="mb-1">{{ $workExperience->role }}</h4>
                        <h5 class="text-muted mb-3">{{ $workExperience->company }}</h5>
                        
                        <div class="d-flex align-items-center text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>{{ $workExperience->location }}</span>
                            <span class="mx-2">•</span>
                            <i class="far fa-calendar-alt me-2"></i>
                            <span>{{ $workExperience->date_range }}</span>
                            @if($workExperience->is_visible)
                                <span class="badge bg-success ms-2">Visible</span>
                            @else
                                <span class="badge bg-secondary ms-2">Hidden</span>
                            @endif
                        </div>
                        
                        @if($workExperience->description)
                            <div class="border-top pt-3 mt-3">
                                <h6>Description:</h6>
                                <div class="text-muted">
                                    {!! nl2br(e($workExperience->description)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between border-top pt-3">
                        <div>
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>
                                Created: {{ $workExperience->created_at->diffForHumans() }}
                            </small>
                            @if($workExperience->updated_at->gt($workExperience->created_at))
                                <small class="text-muted ms-3">
                                    <i class="fas fa-sync-alt me-1"></i>
                                    Updated: {{ $workExperience->updated_at->diffForHumans() }}
                                </small>
                            @endif
                        </div>
                        
                        <form action="{{ route('work-experience.destroy', $workExperience) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this work experience?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
