@php
    $contact = \App\Models\SiteContactDetail::first();
@endphp

<div class="footer-wrapper relative">
    <div class="absolute top-0 left-0 right-0 h-px bg-gray-700"></div>
    <footer class="site-footer pt-8">
        <div class="footer-top">
            <div class="footer-info">
                <h3>{{ $contact->name ?? 'Ben Tito Kyalo' }} <span>{{ $contact->email ?? 'benkyalo075@gmail.com' }}</span></h3>
                <p>{{ $contact->job_title ?? 'Electrical and Electronics Engineer & IT Consultant' }}</p>
                @if($contact?->location)
                    <p class="mt-2"><i class="fas fa-map-marker-alt me-2"></i> {{ $contact->location }}</p>
                @endif
            </div>
            <div class="footer-media">
                <h3>Media</h3>
                <div class="footer-social-links">
                    @if($contact?->github_username)
                        <a href="https://github.com/{{ $contact->github_username }}" target="_blank" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                    @endif
                    @if($contact?->x_username)
                        <a href="https://x.com/{{ ltrim($contact->x_username, '@') }}" target="_blank" aria-label="X (Twitter)">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if($contact?->linkedin_url)
                        <a href="{{ $contact->linkedin_url }}" target="_blank" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if($contact?->phone)
                        <a href="tel:{{ $contact->phone }}" aria-label="Phone">
                            <i class="fas fa-phone"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>&copy; Copyright {{ date('Y') }}. Made by {{ $contact->name ?? 'Ben Tito' }}</p>
        </div>
    </footer>
</div>