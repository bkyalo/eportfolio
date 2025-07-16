@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div class="icon-wrapper bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; font-size: 36px;">
                            <i class="fas fa-check-circle text-primary"></i>
                        </div>
                    </div>
                    
                    <h1 class="h2 mb-3">Thank You!</h1>
                    <p class="lead text-muted mb-4">Your message has been sent successfully. I'll get back to you as soon as possible.</p>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="btn btn-primary px-4">
                            <i class="fas fa-home me-2"></i> Back to Home
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary px-4">
                            <i class="fas fa-envelope me-2"></i> Send Another Message
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-wrapper {
        transition: all 0.3s ease;
    }
    
    .btn {
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
    }
    
    .btn-primary {
        background-color: #6c63ff;
        border-color: #6c63ff;
    }
    
    .btn-primary:hover {
        background-color: #5a52d6;
        border-color: #5a52d6;
    }
    
    .btn-outline-primary {
        color: #6c63ff;
        border-color: #6c63ff;
    }
    
    .btn-outline-primary:hover {
        background-color: #6c63ff;
        color: white;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    h1 {
        color: #2d3748;
        font-weight: 700;
    }
    
    .lead {
        color: #718096;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endsection
