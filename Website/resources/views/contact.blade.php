@extends('layouts.app')

@section('content')
    <style>
        :root {
            --bg-color: #242429;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --border-color: #4d4d4d;
            --font-body: 'Inter', sans-serif;
            --font-mono: 'Fira Code', monospace;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: var(--font-body);
            margin: 0;
            padding: 2rem 4rem;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        /* Header & Navigation */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            margin-bottom: 4rem;
        }

        .header-logo {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .header-nav a {
            font-family: var(--font-mono);
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s;
        }

        .header-nav a:hover,
        .header-nav a.active {
            color: var(--text-primary);
        }

        .lang-switcher {
            font-family: var(--font-mono);
            cursor: pointer;
        }

        /* Social Sidebar */
        .social-sidebar {
            position: fixed;
            top: 50%;
            left: 2rem;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .social-sidebar svg {
            width: 24px;
            height: 24px;
            fill: var(--text-secondary);
            transition: fill 0.3s;
        }

        .social-sidebar a:hover svg {
            fill: var(--text-primary);
        }

        /* Contact Content */
        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 2rem;
            align-items: start;
        }

        .contact-section, .media-section {
            margin-bottom: 6rem;
        }

        .section-header {
            margin-bottom: 2rem;
        }

        .section-header h1 {
            font-family: var(--font-mono);
            font-size: 2.5rem;
            margin: 0 0 0.5rem 0;
        }

        .section-header .subheading {
            color: var(--text-secondary);
        }

        .contact-content p {
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 400px;
            margin: 0;
        }

        .contact-boxes {
            display: flex;
            gap: 1rem;
        }

        .info-box {
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            flex: 1;
        }

        .info-box h3 {
            font-weight: 400;
            margin: 0 0 1rem 0;
        }

        .info-box .detail {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
            font-family: var(--font-mono);
            font-size: 0.9rem;
        }

        .info-box .detail svg {
            width: 20px;
            height: 20px;
            fill: var(--text-secondary);
        }

        /* Media Section */
        .media-section {
            position: relative;
            padding-left: 100px;
        }

        .media-section .dots {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
            background-image: radial-gradient(circle, var(--border-color) 2px, transparent 2px);
            background-size: 15px 15px;
        }

        .media-section h2 {
            font-family: var(--font-mono);
            font-size: 2rem;
            margin: 0 0 1.5rem 0;
        }

        .media-links {
            display: flex;
            gap: 2rem;
        }

        .media-links a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text-secondary);
            font-family: var(--font-mono);
            transition: color 0.3s;
        }

        .media-links a:hover {
            color: var(--text-primary);
        }

        .media-links svg {
            width: 24px;
            height: 24px;
            fill: currentColor;
        }

        /* Footer */
        .footer {
            margin-top: 6rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .footer-info h3 {
            font-size: 1.2rem;
            margin: 0;
        }

        .footer-info p {
            color: var(--text-secondary);
            margin-top: 0.5rem;
        }

        .footer-media h3 {
            font-size: 1.2rem;
            font-weight: 400;
            margin: 0 0 1rem 0;
        }

        .footer-social-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-social-links svg {
            width: 24px;
            height: 24px;
            fill: var(--text-secondary);
            transition: fill 0.3s;
        }

        .footer-social-links a:hover svg {
            fill: var(--text-primary);
        }

        .footer-copyright {
            text-align: center;
            margin-top: 4rem;
            color: var(--text-secondary);
            font-family: var(--font-mono);
            font-size: 0.9rem;
        }
        }

        .contact-content {
            margin-top: 2rem;
        }

        .contact-boxes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-5px);
        }

        .info-box h3 {
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .detail {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .detail svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .media-section h2 {
            font-family: var(--font-mono);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .media-links {
            display: flex;
            gap: 1.5rem;
        }

        .media-links a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .media-links a:hover {
            color: var(--text-primary);
        }
    </style>

    <div class="main-container">
        <div class="contact-content">
            <div class="contact-section">
                <h1>Get in Touch</h1>
                <p>Feel free to reach out to me for any questions or opportunities.</p>

                <div class="contact-methods">
                    <h1>/contacts</h1>
                    <span class="subheading">Who am i?</span>
                </div>
                <div class="contact-content">
                    <p>I'm interested in freelance opportunities. However, if you have other requests or questions, don't hesitate to contact me.</p>
                    <div class="contact-boxes">
                        <div class="info-box">
                            <h3>Support me here</h3>
                            <div class="detail">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/></svg>
                                <span>4149500120690030</span>
                    </div>
                    <div class="info-box">
                        <h3>Message me here</h3>
                        <div class="detail">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M20.3,3.7A22.7,22.7,0,0,0,12,2h0a22.8,22.8,0,0,0-8.3,1.7,4.3,4.3,0,0,0-2.1,3.2A51.9,51.9,0,0,0,1.5,12a51.9,51.9,0,0,0,.1,3.1A4.3,4.3,0,0,0,3.7,18.3,22.8,22.8,0,0,0,12,20h0a22.7,22.7,0,0,0,8.3-1.7,4.3,4.3,0,0,0,2.1-3.2A51.9,51.9,0,0,0,22.5,12a51.9,51.9,0,0,0-.1-3.1A4.3,4.3,0,0,0,20.3,3.7ZM9.7,14.9V7.1L15.4,11Z"/>
                            </svg>
                            <span>Elias#1234</span>
                        </div>
                        <div class="detail">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z"/>
                            </svg>
                            <span>elias@elias-dev.ml</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="media-section">
            <div class="dots"></div>
            <h2>#all-media</h2>
            <div class="media-links">
                @if(isset($contact) && $contact->github_username)
                    <a href="https://github.com/{{ $contact->github_username }}" target="_blank">
                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                        </svg>
                        <span>{{ '@' . $contact->github_username }}</span>
                    </a>
                @endif
                
                @if(isset($contact) && $contact->x_username)
                    <a href="https://x.com/{{ $contact->x_username }}" target="_blank">
                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                        </svg>
                        <span>{{ '@' . $contact->x_username }}</span>
                    </a>
                @endif
                
                @if(isset($contact) && $contact->linkedin_url)
                    <a href="{{ $contact->linkedin_url }}" target="_blank">
                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        <span>LinkedIn</span>
                    </a>
                @endif
                
                @if(isset($contact) && $contact->facebook_url)
                    <a href="{{ $contact->facebook_url }}" target="_blank">
                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.797v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Facebook</span>
                    </a>
                @endif
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-info">
                <h3>Elias <span style="color: var(--text-secondary)">elias@elias-dev.ml</span></h3>
                <p>Web designer and front-end developer</p>
            </div>
            <div class="footer-media">
                <h3>Media</h3>
                <div class="footer-social-links">
                    @if(isset($contact) && $contact->github_username)
                        <a href="https://github.com/{{ $contact->github_username }}" aria-label="GitHub">
                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                            </svg>
                        </a>
                    @endif
                    @if(isset($contact) && $contact->x_username)
                        <a href="https://x.com/{{ $contact->x_username }}" aria-label="Twitter">
                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                            </svg>
                        </a>
                    @endif
                    @if(isset($contact) && $contact->linkedin_url)
                        <a href="{{ $contact->linkedin_url }}" aria-label="LinkedIn">
                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <p class="footer-copyright">  Copyright {{ date('Y') }}. Made by Elias</p>
    </footer>
</div>
@endsection
