@extends('layouts.admin')

@section('title', 'Edit Work Experience')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Work Experience</h5>
                        <a href="{{ route('work-experience.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('work-experience.update', $workExperience) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('work-experience.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
