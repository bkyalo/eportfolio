@extends('layouts.admin')

@section('title', 'About Myself')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">About Myself</h1>
        <div>
            <a href="{{ route('about-myself.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Profile
            </a>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    @if($contact->profile_photo_path)
                        <img src="{{ asset('storage/' . $contact->profile_photo_path) }}" 
                             alt="Profile Photo" 
                             class="img-fluid rounded-circle mb-3"
                             style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 200px; height: 200px; margin: 0 auto;">
                            <i class="fas fa-user text-muted" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-9">
                    <h2 class="mb-3">{{ $contact->name }}</h2>
                    
                    @if($contact->job_title)
                        <h5 class="text-muted mb-4">{{ $contact->job_title }}</h5>
                    @endif
                    
                    @if($contact->saying)
                        <div class="card bg-light p-4 mb-4">
                            <h5 class="mb-3">Favorite Quote</h5>
                            <blockquote class="blockquote mb-0">
                                <p class="mb-2">"{{ $contact->saying }}"</p>
                                @if($contact->saying_author)
                                    <footer class="blockquote-footer">{{ $contact->saying_author }}</footer>
                                @endif
                            </blockquote>
                        </div>
                    @endif
                    
                    @if($contact->bio)
                        <div class="card bg-light p-4 mb-4">
                            <h5 class="mb-3">About Me</h5>
                            <p class="mb-0">{{ $contact->bio }}</p>
                        </div>
                    @endif
                    
                    @if($contact->tags)
                        <div class="mb-4">
                            @php
                                $tags = explode(',', $contact->tags);
                            @endphp
                            @foreach($tags as $tag)
                                <span class="badge bg-primary me-2 mb-2">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    @if($contact->home_description)
                        <div class="card bg-light p-4 mb-4">
                            <h5 class="mb-3">Home Page Introduction</h5>
                            <p class="mb-0">{{ $contact->home_description }}</p>
                        </div>
                    @endif
                    
                    @if($contact->contact_description)
                        <div class="card bg-light p-4 mb-4">
                            <h5 class="mb-3">Contact Page Message</h5>
                            <p class="mb-0">{{ $contact->contact_description }}</p>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Contact Information</h5>
                            <ul class="list-unstyled">
                                @if($contact->email)
                                    <li class="mb-2">
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                            {{ $contact->email }}
                                        </a>
                                    </li>
                                @endif
                                
                                @if($contact->phone)
                                    <li class="mb-2">
                                        <i class="fas fa-phone me-2 text-primary"></i>
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact->phone) }}" class="text-decoration-none">
                                            {{ $contact->phone }}
                                        </a>
                                    </li>
                                @endif
                                
                                @if($contact->location)
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                        {{ $contact->location }}
                                    </li>
                                @endif
                                
                                @if($contact->address)
                                    <li class="mb-2">
                                        <i class="fas fa-home me-2 text-primary"></i>
                                        {{ $contact->address }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3">Social Links</h5>
                            <div class="d-flex flex-wrap gap-3">
                                @if($contact->github_username)
                                    <a href="https://github.com/{{ $contact->github_username }}" 
                                       target="_blank" 
                                       class="btn btn-outline-dark btn-sm"
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="GitHub">
                                        <i class="fab fa-github me-1"></i> GitHub
                                    </a>
                                @endif
                                
                                @if($contact->linkedin_url)
                                    <a href="https://linkedin.com/in/{{ $contact->linkedin_url }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm"
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="LinkedIn">
                                        <i class="fab fa-linkedin-in me-1"></i> LinkedIn
                                    </a>
                                @endif
                                
                                @if($contact->x_username)
                                    <a href="https://x.com/{{ $contact->x_username }}" 
                                       target="_blank" 
                                       class="btn btn-outline-info btn-sm"
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="X (Twitter)">
                                        <i class="fab fa-twitter me-1"></i> X
                                    </a>
                                @endif
                                
                                @if($contact->facebook_url)
                                    <a href="https://facebook.com/{{ $contact->facebook_url }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm"
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="Facebook">
                                        <i class="fab fa-facebook-f me-1"></i> Facebook
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-end">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
        <a href="{{ route('about-myself.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Profile
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-body {
        padding: 2rem;
    }
    
    h1, h2, h3, h4, h5, h6 {
        color: #2c3e50;
    }
    
    .text-primary {
        color: #3498db !important;
    }
    
    .btn-outline-primary {
        color: #3498db;
        border-color: #3498db;
    }
    
    .btn-outline-primary:hover {
        background-color: #3498db;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
