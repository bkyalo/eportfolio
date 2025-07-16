@extends('layouts.admin')

@section('title', 'Add New Publication')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add New Publication</h1>
        <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('publications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('publications.form')
            </form>
        </div>
    </div>
</div>
@endsection
