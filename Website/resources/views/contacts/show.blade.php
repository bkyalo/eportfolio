@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Message Details</h1>
        <div class="d-flex">
            <a href="{{ route('contact.submissions.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Messages
            </a>
            <form action="{{ route('contact.submissions.destroy', $submission) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('contact.submissions.index') }}">Messages</a></li>
        <li class="breadcrumb-item active">Message Details</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-envelope me-1"></i>
                {{ $submission->subject ?: '(No subject)' }}
            </div>
            <span class="badge bg-{{ $submission->is_read ? 'secondary' : 'danger' }}">
                {{ $submission->is_read ? 'Read' : 'Unread' }}
            </span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>From:</strong> {{ $submission->name }}</p>
                    <p class="mb-1"><strong>Email:</strong> <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></p>
                    @if($submission->phone)
                        <p class="mb-0"><strong>Phone:</strong> {{ $submission->phone }}</p>
                    @endif
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-1">
                        <small>Received: {{ $submission->created_at->format('M j, Y \a\t g:i A') }}</small>
                    </p>
                    <p class="text-muted mb-0">
                        <small>IP: {{ $submission->ip_address }}</small>
                    </p>
                </div>
            </div>

            <div class="border-top pt-3">
                <h6>Message:</h6>
                <div class="bg-light p-3 rounded">
                    {!! nl2br(e($submission->message)) !!}
                </div>
            </div>

            @if($submission->user_agent)
                <div class="mt-3 text-muted">
                    <small>
                        <strong>User Agent:</strong> {{ $submission->user_agent }}
                    </small>
                </div>
            @endif
        </div>
        <div class="card-footer bg-light d-flex justify-content-between">
            @if($submission->is_read)
                <form action="{{ route('contact.submissions.unread', $submission) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-envelope me-1"></i> Mark as Unread
                    </button>
                </form>
            @else
                <form action="{{ route('contact.submissions.read', $submission) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-envelope-open me-1"></i> Mark as Read
                    </button>
                </form>
            @endif
            
            <div>
                <a href="mailto:{{ $submission->email }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-reply me-1"></i> Reply
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
