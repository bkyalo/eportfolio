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
    
    .section-heading::first-letter {
        color: var(--accent-purple);
    }
    
    .greeting {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
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
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
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
            grid-template-columns: repeat(2, 1fr);
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

<div class="main-container">
    <main>
        <section class="about-section">
            <div class="about-text">
                <h2 class="section-heading">/about-me</h2>
                <p class="subheading">Who am i?</p>
                @if(isset($contact))
                    @if($contact->name)
                        <p class="greeting">Hello, I'm {{ $contact->name }}!</p>
                    @endif
                    @if($contact->bio)
                        {!! nl2br(e($contact->bio)) !!}
                    @else
                        <p>I'm a self-taught front-end developer based in {{ $contact->location ?? 'Kyiv, Ukraine' }}. I can develop responsive websites from scratch and raise them into modern user-friendly web experiences.</p>
                        <p>Transforming my creativity and knowledge into websites has been my passion for over a year. I have been helping various clients to establish their presence online. I always strive to learn about the newest technologies and frameworks.</p>
                    @endif
                @else
                    <p class="greeting">Hello, I'm Elias!</p>
                    <p>I'm a self-taught front-end developer based in Kyiv, Ukraine. I can develop responsive websites from scratch and raise them into modern user-friendly web experiences.</p>
                    <p>Transforming my creativity and knowledge into websites has been my passion for over a year. I have been helping various clients to establish their presence online. I always strive to learn about the newest technologies and frameworks.</p>
                @endif
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
                @forelse($skillCategories as $category)
                    <div class="skill-category">
                        <h3>{{ $category->name }}</h3>
                        <ul>
                            @forelse($category->skills as $skill)
                                <li>{{ $skill->name }}</li>
                            @empty
                                <li>No skills found in this category.</li>
                            @endforelse
                        </ul>
                    </div>
                @empty
                    <div class="skill-category">
                        <h3>Skills</h3>
                        <li>No skill categories found.</li>
                    </div>
                @endforelse
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
