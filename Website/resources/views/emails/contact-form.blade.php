@component('mail::layout')
{{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endslot

# New Contact Form Submission

You have received a new message from your portfolio website.

**Name:** {{ $name }}

**Email:** {{ $email }}

@if($phone)
**Phone:** {{ $phone }}
@endif

**Subject:** {{ $subject }}

**Message:**  
{{ $messageContent }}

@if(isset($submissionId))
@component('mail::button', ['url' => url('/contact/submissions/' . $submissionId), 'color' => 'primary'])
    View Full Message
@endcomponent
@endif

---

This email was sent from the contact form on your portfolio website.

{{-- Subcopy --}}
@slot('subcopy')
    @component('mail::subcopy')
        This is an automated message. Please do not reply to this email.
    @endcomponent
@endslot

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endslot
@endcomponent
