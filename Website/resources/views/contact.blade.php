@extends('layouts.app')

{{-- 
|--------------------------------------------------------------------------
| Page-Specific Styles
|--------------------------------------------------------------------------
|
| These styles are pushed to the @stack('styles') in your layout.
| I've adjusted the #contacts CSS to remove the problematic centering.
|
--}}
@push('styles')
<style>
    .section-heading {
        font-family: var(--font-mono);
        font-size: 2.5rem;
        font-weight: 500;
        margin: 0;
        white-space: nowrap;
    }
    .section-heading::first-letter {
        color: var(--accent-purple);
    }
    
    .contact-methods {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        padding: 2rem;
        border-radius: 8px;
    }
    .contact-methods p {
        max-width: 60ch;
        margin: 0 auto 2rem auto;
        color: var(--text-color);
    }
    .contact-boxes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .info-box {
        border: 1px solid var(--border-color);
        padding: 1.5rem;
        border-radius: 8px;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .info-box:hover {
        transform: translateY(-5px);
        border-color: var(--accent-purple);
    }
    .info-box h3 {
        color: var(--heading-color);
        margin-bottom: 1rem;
        font-size: 1.2rem;
    }
    .info-box .detail {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-color);
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    /* All Media Section */
    .media-links {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }
    .social-link {
        color: var(--text-color);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: color 0.3s, transform 0.3s;
        padding: 1rem;
        min-width: 120px;
    }
    .social-link:hover {
        color: var(--accent-purple);
        transform: translateY(-5px);
    }
    .social-link i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
    }
    .social-link span {
        font-family: var(--font-mono);
    }

    /* Contact Layout */
    .contact-layout {
        display: grid;
        grid-template-columns: 1fr auto 1.2fr;
        gap: 0;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }
    
    .divider {
        width: 1px;
        background: var(--border-color);
        height: 80%;
        margin: auto 0;
        position: relative;
        opacity: 0.5;
    }
    
    .contact-info {
        padding: 1rem 2rem 1rem 0;
        height: 100%;
    }
    
    .contact-form-wrapper {
        position: relative;
        padding: 1rem 0 1rem 2rem;
        height: 100%;
    }
    
    .form-group {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .form-field {
        position: relative;
        padding-top: 1.5rem;
    }
    
    .form-label {
        position: absolute;
        top: 2rem;
        left: 0;
        color: var(--text-secondary);
        font-family: var(--font-mono);
        font-size: 1rem;
        pointer-events: none;
        transition: all 0.3s ease;
        transform-origin: left center;
    }
    
    .form-input,
    .form-textarea {
        width: 100%;
        padding: 0.75rem 0;
        font-size: 1rem;
        color: var(--text-color-light);
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--border-color);
        outline: none;
        transition: all 0.3s ease;
        font-family: var(--font-primary);
    }
    
    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }
    
    .form-line {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--accent-purple);
        transition: width 0.4s ease;
    }
    
    .form-input:focus,
    .form-textarea:focus {
        border-bottom-color: transparent;
    }
    
    .form-input:focus + .form-label,
    .form-input:not(:placeholder-shown) + .form-label,
    .form-textarea:focus + .form-label,
    .form-textarea:not(:placeholder-shown) + .form-label {
        top: 0;
        font-size: 0.85rem;
        color: var(--accent-purple);
        transform: translateY(0);
    }
    
    .form-input:focus ~ .form-line,
    .form-textarea:focus ~ .form-line {
        width: 100%;
    }
    
    .form-actions {
        text-align: center;
        margin-top: 3rem;
    }
    
    .submit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 1rem 2.5rem;
        font-family: var(--font-mono);
        font-size: 1rem;
        color: white;
        background: var(--accent-purple);
        border: 2px solid var(--accent-purple);
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }
    
    .submit-btn:hover {
        background: #6a44c7;
        border-color: #6a44c7;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(130, 80, 223, 0.3);
    }
    
    .submit-btn:active {
        transform: translateY(0);
    }
    
    .submit-btn:hover::before {
        left: 100%;
    }
    
    .submit-btn svg {
        transition: transform 0.3s ease;
    }
    
    .submit-btn:hover svg {
        transform: translateX(5px);
    }
    
    .form-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    /* Contact Info Styles */
    .info-heading {
        font-size: 1.5rem;
        color: var(--text-color-light);
        margin-bottom: 1.5rem;
        font-family: var(--font-mono);
    }
    
    .info-text {
        color: var(--text-secondary);
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .contact-details {
        margin-bottom: 2.5rem;
    }
    
    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .contact-icon {
        font-size: 1.25rem;
        color: var(--accent-purple);
        margin-top: 0.25rem;
    }
    
    .contact-item h4 {
        color: var(--text-color-light);
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }
    
    .contact-link, .contact-text {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .contact-link:hover {
        color: var(--accent-purple);
    }
    
    .social-links {
        display: flex;
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .social-links .social-link {
        font-size: 1.5rem;
        color: var(--text-secondary);
        transition: color 0.3s ease, transform 0.3s ease;
    }
    
    .social-links .social-link:hover {
        color: var(--accent-purple);
        transform: translateY(-3px);
    }
</style>
@endpush


@section('content')
<main>

    <section id="contacts" class="py-5">
        <div class="text-center mb-5">
            <h2 class="section-heading">/contacts</h2>
            <p class="lead text-muted">Get in touch or find me on other platforms.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="contact-methods text-center">
                    <p>I'm interested in freelance opportunities. If you have other requests or questions, don't hesitate to use the form below or reach out via Discord.</p>
                    <div class="contact-boxes">
                        <div class="info-box">
                            <h3>Support me here</h3>
                            <div class="detail">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span>Your Support Method</span>
                            </div>
                        </div>
                        <div class="info-box">
                            <h3>Message me here</h3>
                            <div class="detail">
                                <i class="fab fa-discord"></i>
                                <span>Username#1234</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="contact-me" class="py-5 my-5">
        <div class="text-center mb-5">
            <h2 class="section-heading">/get-in-touch</h2>
        </div>
        
        <div class="contact-layout">
            <div class="contact-info">
                @if(isset($contact) && $contact->contact_description)
                    <p class="info-text">{{ $contact->contact_description }}</p>
                @else
                    <p class="info-text">Feel free to reach out through any of these channels or use the contact form.</p>
                @endif
                
                <div class="contact-details">
                    @if(isset($contact) && $contact->email)
                    <div class="contact-item">
                        <i class="fas fa-envelope contact-icon"></i>
                        <div>
                            <h4>Email</h4>
                            <a href="mailto:{{ $contact->email }}" class="contact-link">{{ $contact->email }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($contact) && $contact->phone)
                    <div class="contact-item">
                        <i class="fas fa-phone contact-icon"></i>
                        <div>
                            <h4>Phone</h4>
                            <a href="tel:{{ $contact->phone }}" class="contact-link">{{ $contact->phone }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($contact) && $contact->location)
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt contact-icon"></i>
                        <div>
                            <h4>Location</h4>
                            <span class="contact-text">{{ $contact->location }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($contact) && $contact->address)
                    <div class="contact-item">
                        <i class="fas fa-address-card contact-icon"></i>
                        <div>
                            <h4>Address</h4>
                            <span class="contact-text">{{ $contact->address }}</span>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="social-links">
                    @if(isset($contact) && $contact->github_username)
                    <a href="https://github.com/{{ $contact->github_username }}" target="_blank" class="social-link" aria-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    @endif
                    
                    @if(isset($contact) && $contact->linkedin_url)
                    <a href="{{ $contact->linkedin_url }}" target="_blank" class="social-link" aria-label="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    @endif
                    
                    @if(isset($contact) && $contact->x_username)
                    <a href="https://x.com/{{ $contact->x_username }}" target="_blank" class="social-link" aria-label="X (Twitter)">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    
                    @if(isset($contact) && $contact->facebook_url)
                    <a href="{{ $contact->facebook_url }}" target="_blank" class="social-link" aria-label="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    @endif
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="contact-form-wrapper">
                <p class="lead text-muted">Send me a message directly.</p>
                <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="form-group">
                        <div class="form-field">
                            <input type="text" id="name" name="name" class="form-input" placeholder=" " required>
                            <label for="name" class="form-label">Your Name</label>
                            <div class="form-line"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-field">
                            <input type="email" id="email" name="email" class="form-input" placeholder=" " required>
                            <label for="email" class="form-label">Email Address</label>
                            <div class="form-line"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-field">
                            <input type="tel" id="phone" name="phone" class="form-input" placeholder=" ">
                            <label for="phone" class="form-label">Phone Number (Optional)</label>
                            <div class="form-line"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-field">
                            <input type="text" id="subject" name="subject" class="form-input" placeholder=" " required>
                            <label for="subject" class="form-label">Subject</label>
                            <div class="form-line"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-field">
                            <textarea id="message" name="message" class="form-textarea" rows="5" placeholder=" " required></textarea>
                            <label for="message" class="form-label">Your Message</label>
                            <div class="form-line"></div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">
                            <span>Send Message</span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="form-overlay"></div>
                </form>
            </div>
        </div>
    </section>

</main>
@endsection