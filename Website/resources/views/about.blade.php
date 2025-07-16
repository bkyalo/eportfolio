@extends('layouts.app')

@section('content')
<style>
    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }

    /* --- Global Elements & Helpers --- */
    .section-heading {
        font-family: var(--font-mono);
        font-size: 2.5rem;
        font-weight: 500;
        margin: 0;
        white-space: nowrap;
    }
    
    .dots {
        position: absolute;
        width: 60px;
        height: 60px;
        background-image: radial-gradient(circle, var(--border-color) 1px, transparent 1px);
        background-size: 15px 15px;
        z-index: -1;
    }
    
    .shape {
        position: absolute;
        border: 1px solid var(--border-color);
        z-index: -1;
    }
    
    .purple-shape {
        border-color: var(--accent-purple);
        opacity: 0.6;
    }

    /* --- Social Sidebar --- */
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

    /* --- About Me Section --- */
    .about-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        position: relative;
        padding: 4rem 0;
    }
    .about-text .subheading {
        color: var(--text-secondary);
        margin-top: 0.5rem;
        margin-bottom: 2rem;
    }
    .about-text p {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        color: var(--text-secondary);
    }
    .about-image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    /* --- Skills Section --- */
    .skills-section {
        padding: 6rem 0;
        position: relative;
    }
    .skills-section .section-heading {
        margin-bottom: 3rem;
    }
    .skills-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .skill-category {
        border: 1px solid var(--border-color);
        padding: 1.5rem;
    }
    .skill-category h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
    }
    .skill-category ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px 15px;
    }
    .skill-category li {
        font-family: var(--font-mono);
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    /* --- Fun Facts Section --- */
    .fun-facts-section {
        padding: 4rem 0;
        position: relative;
    }
    .fun-facts-section .section-heading {
        margin-bottom: 2rem;
    }
    .facts-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        max-width: 80%;
    }
    .fact-item {
        border: 1px solid var(--border-color);
        padding: 0.75rem 1.5rem;
        font-family: var(--font-mono);
        color: var(--text-secondary);
        white-space: nowrap;
    }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
        .about-section {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .facts-container {
            max-width: 100%;
            justify-content: center;
        }
        
        .social-sidebar {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        body {
            padding: 1rem;
        }
        
        .skills-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .fact-item {
            white-space: normal;
            text-align: center;
            flex: 1 0 calc(50% - 1rem);
        }
    }
    
    @media (max-width: 480px) {
        .skills-grid {
            grid-template-columns: 1fr;
        }
        
        .fact-item {
            flex: 1 0 100%;
        }
    }
</style>

<aside class="social-sidebar">
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
</aside>

<div class="main-container">
    <main>
        <section class="about-section">
            <div class="about-text">
                <h2 class="section-heading">/about-me</h2>
                <p class="subheading">Who am i?</p>
                <p>Hello, I'm {{ $contact->name ?? 'Elias' }}!</p>
                <p>I'm a self-taught front-end developer based in {{ $contact->location ?? 'Kyiv, Ukraine' }}. I can develop responsive websites from scratch and raise them into modern user-friendly web experiences.</p>
                <p>Transforming my creativity and knowledge into websites has been my passion for over a year. I have been helping various clients to establish their presence online. I always strive to learn about the newest technologies and frameworks.</p>
            </div>
            <div class="about-image">
                <img src="{{ $contact->profile_photo_url ?? 'https://i.pinimg.com/564x/44/ae/53/44ae53578d32a353d953934d0815184b.jpg' }}" alt="{{ $contact->name ?? 'Elias' }}">
            </div>
            
            <div class="dots" style="top: 100px; left: -30px;"></div>
            <div class="dots" style="top: 150px; right: 80px; z-index: 1;"></div>
            <div class="dots" style="bottom: 150px; right: -50px;"></div>
        </section>

        <section class="skills-section">
            <h2 class="section-heading">#skills</h2>
            <div class="skills-grid">
                <div class="skill-category">
                    <h3>Languages</h3>
                    <ul>
                        <li>TypeScript</li>
                        <li>Lua</li>
                        <li>Python</li>
                        <li>JavaScript</li>
                    </ul>
                </div>
                <div class="skill-category">
                    <h3>Other</h3>
                    <ul>
                        <li>HTML</li>
                        <li>CSS</li>
                        <li>EJS</li>
                        <li>SCSS</li>
                        <li>REST</li>
                        <li>Jinja</li>
                    </ul>
                </div>
                <div class="skill-category">
                    <h3>Tools</h3>
                    <ul>
                        <li>VSCode</li>
                        <li>Neovim</li>
                        <li>Linux</li>
                        <li>Figma</li>
                        <li>XFCE</li>
                        <li>Arch</li>
                        <li>Git</li>
                        <li>Font Awesome</li>
                        <li>KDE</li>
                    </ul>
                </div>
                <div class="skill-category">
                    <h3>Databases</h3>
                    <ul>
                        <li>SQLite</li>
                        <li>PostgreSQL</li>
                        <li>Mongo</li>
                    </ul>
                </div>
                <div class="skill-category">
                    <h3>Frameworks</h3>
                    <ul>
                        <li>React</li>
                        <li>Vue</li>
                        <li>Disnake</li>
                        <li>Discord.js</li>
                        <li>Flask</li>
                        <li>Express.js</li>
                    </ul>
                </div>
            </div>

            <div class="shape" style="top: 150px; right: -50px; width: 80px; height: 80px;"></div>
        </section>

        <section class="fun-facts-section">
            <h2 class="section-heading">#my-fun-facts</h2>
            <div class="facts-container">
                @forelse($funFacts as $fact)
                    <span class="fact-item">{{ $fact->fact }}</span>
                @empty
                    <span class="fact-item">No fun facts available yet.</span>
                @endforelse
            </div>
            
            <div class="shape" style="bottom: 100px; left: -80px; width: 100px; height: 100px;"></div>
            <div class="dots" style="bottom: 40px; right: 180px;"></div>
            <div class="purple-squares" style="bottom: 0; right: 80px;">
                <div class="shape purple-shape" style="width: 90px; height: 90px;"></div>
                <div class="shape purple-shape" style="width: 90px; height: 90px; top: 20px; left: 20px; position:absolute;"></div>
            </div>
        </section>
    </main>
</div>
@endsection
