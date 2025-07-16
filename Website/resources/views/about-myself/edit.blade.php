@extends('layouts.admin')

@section('title', 'About Myself')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">About Myself</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">About Myself</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-edit me-1"></i>
            Update About Myself Information
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <ul class="nav nav-tabs mb-4" id="aboutTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ !session('active_tab') || session('active_tab') === 'details' ? 'active' : '' }}" 
                            id="details-tab" data-bs-toggle="tab" data-bs-target="#details" 
                            type="button" role="tab" aria-controls="details" aria-selected="true">
                        <i class="fas fa-info-circle me-1"></i> Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ session('active_tab') === 'additional' ? 'active' : '' }}" 
                            id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional" 
                            type="button" role="tab" aria-controls="additional" aria-selected="false">
                        <i class="fas fa-plus-circle me-1"></i> Additional Info
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ session('active_tab') === 'photo' ? 'active' : '' }}" 
                            id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo" 
                            type="button" role="tab" aria-controls="photo" aria-selected="false">
                        <i class="fas fa-camera me-1"></i> Profile Photo
                    </button>
                </li>
            </ul>

            <form method="POST" action="{{ route('about-myself.update') }}" enctype="multipart/form-data" id="aboutForm">
                @csrf
                @method('PUT')

                <div class="tab-content" id="aboutTabsContent">
                    <!-- Details Tab -->
                    <div class="tab-pane fade {{ !session('active_tab') || session('active_tab') === 'details' ? 'show active' : '' }}" 
                         id="details" role="tabpanel" aria-labelledby="details-tab">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $contact->name ?? '') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $contact->email ?? '') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone', $contact->phone ?? '') }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input id="job_title" type="text" class="form-control @error('job_title') is-invalid @enderror" 
                                       name="job_title" value="{{ old('job_title', $contact->job_title ?? '') }}">
                                @error('job_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" 
                                       name="location" value="{{ old('location', $contact->location ?? '') }}">
                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio/About Me</label>
                            <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" 
                                      name="bio" rows="5" placeholder="Tell us about yourself...">{{ old('bio', $contact->bio ?? '') }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="mt-4 mb-3">Social Media Links</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="github_username" class="form-label">GitHub Username</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">github.com/</span>
                                    <input id="github_username" type="text" class="form-control @error('github_username') is-invalid @enderror" 
                                           name="github_username" value="{{ old('github_username', $contact->github_username ?? '') }}">
                                </div>
                                @error('github_username')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="linkedin_url" class="form-label">LinkedIn Profile</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">linkedin.com/in/</span>
                                    @php
                                        $linkedinUsername = '';
                                        if (isset($contact->linkedin_url)) {
                                            $linkedinUsername = str_replace('https://linkedin.com/in/', '', $contact->linkedin_url);
                                            $linkedinUsername = trim($linkedinUsername, '/');
                                        }
                                    @endphp
                                    <input id="linkedin_url" type="text" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                           name="linkedin_url" value="{{ old('linkedin_url', $linkedinUsername) }}"
                                           placeholder="username">
                                </div>
                                <small class="form-text text-muted">Enter just your LinkedIn username (e.g., 'john-doe')</small>
                                @error('linkedin_url')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="x_username" class="form-label">X (Twitter) Username</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">x.com/</span>
                                    <input id="x_username" type="text" class="form-control @error('x_username') is-invalid @enderror" 
                                           name="x_username" value="{{ old('x_username', $contact->x_username ?? '') }}">
                                </div>
                                @error('x_username')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="facebook_url" class="form-label">Facebook Profile</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">facebook.com/</span>
                                    <input id="facebook_url" type="text" class="form-control @error('facebook_url') is-invalid @enderror" 
                                           name="facebook_url" value="{{ old('facebook_url', $contact->facebook_url ?? '') }}">
                                </div>
                                @error('facebook_url')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>

                    <!-- Additional Info Tab -->
                    <div class="tab-pane fade {{ session('active_tab') === 'additional' ? 'show active' : '' }}" 
                         id="additional" role="tabpanel" aria-labelledby="additional-tab">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="saying" class="form-label">Favorite Saying/Quote</label>
                                <textarea id="saying" class="form-control @error('saying') is-invalid @enderror" 
                                          name="saying" rows="2">{{ old('saying', $contact->saying ?? '') }}</textarea>
                                @error('saying')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="saying_author" class="form-label">Quote Author</label>
                                <input id="saying_author" type="text" class="form-control @error('saying_author') is-invalid @enderror" 
                                       name="saying_author" value="{{ old('saying_author', $contact->saying_author ?? '') }}">
                                @error('saying_author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="tags" class="form-label">Tags (comma separated, e.g., engineer, developer, designer)</label>
                                <input id="tags" type="text" class="form-control @error('tags') is-invalid @enderror" 
                                       name="tags" value="{{ old('tags', $contact->tags ?? '') }}">
                                @error('tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="home_description" class="form-label">Home Page Description</label>
                                <textarea id="home_description" class="form-control @error('home_description') is-invalid @enderror" 
                                          name="home_description" rows="4">{{ old('home_description', $contact->home_description ?? '') }}</textarea>
                                <div class="form-text">A brief introduction that will appear on the home page.</div>
                                @error('home_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="contact_description" class="form-label">Contact Page Description</label>
                                <textarea id="contact_description" class="form-control @error('contact_description') is-invalid @enderror" 
                                          name="contact_description" rows="4">{{ old('contact_description', $contact->contact_description ?? '') }}</textarea>
                                <div class="form-text">A brief message that will appear on the contact page.</div>
                                @error('contact_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Photo Tab -->
                    <div class="tab-pane fade {{ session('active_tab') === 'photo' ? 'show active' : '' }}" 
                         id="photo" role="tabpanel" aria-labelledby="photo-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="profile_photo" class="form-label">Profile Photo</label>
                                    <input class="form-control @error('profile_photo') is-invalid @enderror" 
                                           type="file" id="profile_photo" name="profile_photo" 
                                           accept="image/*" onchange="previewImage(event)">
                                    <div class="form-text">Recommended size: 500x500px, Max size: 2MB</div>
                                    @error('profile_photo')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                @if($contact->profile_photo_path ?? false)
                                    <div class="mb-3">
                                        <label class="form-label">Current Photo</label>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $contact->profile_photo_path) }}" 
                                                 alt="Profile Photo" class="img-thumbnail me-3" 
                                                 style="max-width: 150px; max-height: 150px;">
                                            <button type="button" class="btn btn-danger" 
                                                    onclick="event.preventDefault(); document.getElementById('delete-photo-form').submit();">
                                                <i class="fas fa-trash me-1"></i> Remove Photo
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="d-none" id="imagePreviewContainer">
                                    <label class="form-label">New Photo Preview</label>
                                    <div>
                                        <img id="imagePreview" src="#" alt="Preview" 
                                             class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-1"></i> Upload Photo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            @if($contact->profile_photo_path ?? false)
                <form id="delete-photo-form" action="{{ route('about-myself.photo.destroy') }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image before upload
    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }
    
    // Handle tab switching and form submission
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Store the active tab in session storage
        const tabElms = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabElms.forEach(tabEl => {
            tabEl.addEventListener('shown.bs.tab', function (event) {
                const activeTab = event.target.getAttribute('id');
                sessionStorage.setItem('activeTab', activeTab);
            });
        });
        
        // Restore active tab from session storage
        const activeTab = sessionStorage.getItem('activeTab');
        if (activeTab) {
            const tab = document.querySelector(`#${activeTab}`);
            if (tab) {
                const tabInstance = new bootstrap.Tab(tab);
                tabInstance.show();
            }
        }
    });
</script>
@endpush
