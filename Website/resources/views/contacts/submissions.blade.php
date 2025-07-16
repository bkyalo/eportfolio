@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Contact Submissions</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Messages</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-envelope me-1"></i>
                Messages
            </div>
            @if($unreadCount > 0)
                <span class="badge bg-danger rounded-pill">{{ $unreadCount }} unread</span>
            @endif
        </div>

        @if($submissions->isEmpty())
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <p class="h5 text-muted mb-0">No messages yet</p>
                <p class="text-muted">New contact form submissions will appear here</p>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $submission)
                                <tr class="{{ $submission->is_read ? '' : 'table-active fw-bold' }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="fas fa-user-circle fa-lg text-muted"></i>
                                            </div>
                                            <div>
                                                <div>{{ $submission->name }}</div>
                                                <small class="text-muted">{{ $submission->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('contact.submissions.show', $submission) }}" 
                                           class="text-decoration-none {{ $submission->is_read ? 'text-dark' : 'text-primary' }}">
                                            {{ $submission->subject ?: '(No subject)' }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-muted" title="{{ $submission->created_at->format('M j, Y g:i a') }}">
                                            {{ $submission->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('contact.submissions.show', $submission) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('contact.submissions.destroy', $submission) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
            </div>

            @if($submissions->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{ $submissions->total() }} messages
                        </div>
                        {{ $submissions->links() }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
