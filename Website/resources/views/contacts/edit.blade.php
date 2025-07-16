@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Contact Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Contact Details</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-address-card me-1"></i>
            Update Contact Information
        </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.details.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $contact->name ?? '') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $contact->email ?? '') }}" required autocomplete="email">
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
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio/About</label>
                            <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" 
                                      name="bio" rows="3">{{ old('bio', $contact->bio ?? '') }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="github_username" class="form-label">GitHub Username</label>
                                <div class="input-group">
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
                                <label for="x_username" class="form-label">X (Twitter) Username</label>
                                <div class="input-group">
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
                        </div>

                        <div class="mb-3">
                            <label for="linkedin_url" class="form-label">LinkedIn Profile URL</label>
                            <input id="linkedin_url" type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                   name="linkedin_url" value="{{ old('linkedin_url', $contact->linkedin_url ?? '') }}">
                            @error('linkedin_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" 
                                   name="location" value="{{ old('location', $contact->location ?? '') }}">
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address</label>
                            <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                                      name="address" rows="2">{{ old('address', $contact->address ?? '') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="profile_photo" class="form-label">Profile Photo</label>
                            <input class="form-control @error('profile_photo') is-invalid @enderror" 
                                   type="file" id="profile_photo" name="profile_photo" accept="image/*">
                            @error('profile_photo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            @if(isset($contact) && $contact->profile_photo_path)
                                <div class="mt-2">
                                    <img src="{{ $contact->profile_photo_url }}" alt="Profile Photo" class="img-thumbnail" style="max-width: 200px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo">
                                        <label class="form-check-label" for="remove_photo">
                                            Remove photo
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-photo-preview').src = e.target.result;
                document.getElementById('profile-photo-preview').classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // Remove photo
    document.getElementById('remove-photo').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('profile_photo').value = '';
        document.getElementById('profile-photo-preview').src = '{{ $contact->profile_photo_path ? asset('storage/' . $contact->profile_photo_path) : asset('images/default-avatar.png') }}';
        document.getElementById('remove-photo').classList.add('d-none');
    });
</script>
@endpush
@endsection
