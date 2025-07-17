@extends('layouts.app')

@section('content')
<div class="container">

    <section id="home" class="hero-section py-5 py-lg-6">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-text">
                    <h1>
                        {{ $contact->name ?? 'Ben Tito' }} is a 
                        <span class="highlight typewriter" data-words='[{{ $contact->tags ? collect(explode(',', $contact->tags))->map(fn($tag) => '"' . trim($tag) . '"')->implode(',') : '' }}]' data-wait="2000"></span>
                    </h1>

                    <p class="subtitle">
                        @if($contact->home_description)
                            {{ $contact->home_description }}
                        @else
                            Bridging engineering and technology to create innovative solutions
                        @endif
                    </p>

                    <a href="#contacts" class="contact-button">Contact me !!</a>
                </div>

                <div class="hero-image-wrapper">
                    <div class="deco-square square-1"></div>
                    <div class="deco-square square-2"></div>
                    <div class="deco-dots"></div>
                    <img src="{{ asset('images/tiro.png') }}" alt="{{ $contact->name ?? 'Ben Tito' }}" class="hero-image">
                    <div class="status-box">
                        <div class="dot"></div>
                        Currently working on <strong>Portfolio</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 my-5 d-flex align-items-center" style="min-height: 50vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="quote-container mx-auto text-center p-5 position-relative">
                        @if(isset($contact) && $contact->saying)
                            <div class="quote-text mb-4">{{ $contact->saying }}</div>
                            @if($contact->saying_author)
                                <div class="quote-author position-absolute bg-dark px-4 py-2" style="bottom: -1rem; right: 2rem; border: 1px solid #555;">- {{ $contact->saying_author }}</div>
                            @endif
                        @else
                            <div class="quote-text mb-4">The only person you are destined to become is the person you decide to be</div>
                            <div class="quote-author position-absolute bg-dark px-4 py-2" style="bottom: -1rem; right: 2rem; border: 1px solid #555;">- Ralph Waldo Emerson</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="projects" class="py-5 my-5">
        <div class="container">
            <div class="projects-header">
                <div class="heading-container">
                    <h2 class="section-heading">#projects</h2>
                    <div class="line"></div>
                </div>
                <a href="{{ route('projects.index') }}" class="view-all-link">View all →</a>
            </div>

            <div class="project-grid">
                @foreach($projects as $index => $project)
                    <div class="project-card-wrapper" style="--index: {{ $index }}">
                        <x-project-card 
                            :title="$project['title']"
                            :description="$project['description']"
                            :techStack="$project['tech_stack']"
                            :image="$project['image']"
                            :liveUrl="$project['live_url']"
                            :isLive="$project['is_live'] ?? false"
                            :codeUrl="$project['code_url']"
                            :accent="$project['accent'] ?? 'purple'"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="skills-section" style="width: 100%; max-width: 1100px; margin: 0 auto; padding: 4rem 0;">
        <div class="skills-header" style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2.5rem;">
            <h2 style="font-size: 2.5rem; color: #FFFFFF; font-weight: 500; white-space: nowrap;">#skills</h2>
            <div style="flex-grow: 1; height: 1px; background-color: #BD93F9;"></div>
        </div>

        <div class="skills-body" style="display: grid; grid-template-columns: 1fr 2fr; gap: 3rem;">
            <div class="shapes-column" style="position: relative; min-height: 380px;">
                <div style="position: absolute; width: 75px; height: 75px; background-image: radial-gradient(circle, #44475a 2px, transparent 2px); background-size: 15px 15px; top: 20px; left: 20px;"></div>
                <div style="position: absolute; width: 75px; height: 75px; background-image: radial-gradient(circle, #44475a 2px, transparent 2px); background-size: 15px 15px; top: 220px; left: 150px;"></div>
                <div style="position: absolute; top: -20px; left: 220px; width: 80px; height: 80px; border: 1px solid #6272A4;"></div>
                <div style="position: absolute; top: 250px; left: 300px; width: 60px; height: 60px; border: 1px solid #6272A4;"></div>
                <div class="purple-group" style="position: absolute; top: 170px; left: 20px; width: 120px; height: 120px;">
                    <div style="width: 90px; height: 90px; position: absolute; border: 1px solid #BD93F9;"></div>
                    <div style="width: 90px; height: 90px; position: absolute; top: 20px; left: 20px; border: 1px solid #BD93F9;"></div>
                </div>
            </div>

            <div class="skills-grid-wrapper" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                @php
                    // Initialize columns (right to left: 2, 1, 0)
                    $columns = [[], [], []];
                    
                    // Distribute categories:
                    // First 2 categories in right column (index 2)
                    // Next 2 categories in middle column (index 1)
                    // Remaining categories in left column (index 0)
                    foreach ($skills as $index => $category) {
                        if ($index < 2) {
                            $columns[2][] = $category;  // Right column (first 2 categories)
                        } elseif ($index < 4) {
                            $columns[1][] = $category;  // Middle column (next 2 categories)
                        } else {
                            $columns[0][] = $category;  // Left column (remaining categories)
                        }
                    }
                @endphp

                @foreach($columns as $columnIndex => $columnCategories)
                    <div class="nested-box" style="display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-end;">
                        @foreach($columnCategories as $category)
                            <div class="skill-category" style="border: 1px solid #6272A4; padding: 0.5rem 0.75rem; height: fit-content; width: 100%;">
                                <h3 style="position: relative; font-size: 0.9rem; color: #FFFFFF; font-weight: 500; margin: 0 0 0.5rem 0; padding-bottom: 0.25rem; border-bottom: 1px solid #6272A4; width: 100%; text-align: right;">
                                    <i class="{{ $category['icon'] }}"></i> {{ $category['title'] }}
                                </h3>
                                @if(!empty($category['skills']))
                                    <div class="skill-list" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; color: #b0b0b0; line-height: 1.3; font-size: 0.9rem; width: 100%;">
                                        @foreach($category['skills'] as $skill)
                                            <div style="margin: 0.15rem 0; text-align: right;">{{ $skill['name'] }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            @media (max-width: 900px) {
                .skills-body {
                    grid-template-columns: 1fr !important;
                }
                .shapes-column {
                    display: none !important;
                }
                .skills-grid-wrapper {
                    grid-template-columns: 1fr !important;
                    gap: 1rem !important;
                }
            }
        </style>
        </div>
    </section>
    <section id="about-me" class="about-section py-5 my-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="pe-lg-5 anim-on-scroll">
                    <div class="d-flex align-items-center mb-4">
                        <h2 class="section-heading mb-0">#about-me</h2>
                        <div class="flex-grow-1 ms-3" style="height: 2px; background: var(--bs-primary);"></div>
                    </div>
                    <h3 class="h2 fw-bold mb-4">Hello, I'm Ben Tito Kyalo!</h3>
                    <div class="text-muted mb-4">
                        <p>I'm an Electrical and Electronics Engineer and IT Consultant with a strong passion for Open Source Software and DevOps. Currently pursuing a BSc in Electrical and Electronics Engineering, I specialize in developing robust IT solutions and infrastructure.</p>
                        <p>With expertise in server administration, database management, and full-stack development, I bridge the gap between hardware and software to create efficient, scalable solutions. My work focuses on implementing modern technologies to solve real-world problems.</p>
                    </div>
                    <a href="#" class="btn btn-outline-primary">
                        Read more about me <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative anim-on-scroll" data-aos="fade-left">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary bg-opacity-10 rounded-4" style="transform: rotate(3deg); z-index: -1;"></div>
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded-4" style="transform: rotate(-2deg); z-index: -1;"></div>
                    <img src="{{ asset('images/test-2.png') }}" alt="Ben Tito Kyalo" class="img-fluid rounded-4 shadow-lg position-relative" style="z-index: 1;">
                </div>
            </div>
        </div>
    </section>
    <section id="contacts" class="contact-section py-5 my-5">
        <div class="container">
            <div class="flex items-center mb-8">
                <h2 class="section-heading">#contacts</h2>
                <div class="h-px bg-gray-700 flex-1 ml-4"></div>
            </div>
            <p class="text-gray-400 mb-8">Get in touch with me</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6 anim-on-scroll">
                        <div class="h-100 p-4 p-lg-5 bg-dark rounded-4">
                            <h3 class="h4 mb-4">Let's work together</h3>
                            <p class="text-muted mb-4">I'm interested in freelance opportunities. However, if you have other requests or questions, don't hesitate to contact me.</p>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="fas fa-phone text-primary"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Phone</div>
                                    <a href="tel:+254757135612" class="text-white text-decoration-none">+254 757 135 612</a>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Email</div>
                                    <a href="mailto:benkyalo075@gmail.com" class="text-white text-decoration-none">benkyalo075@gmail.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 anim-on-scroll" data-aos-delay="100">
                        <div class="h-100 p-4 p-lg-5 bg-primary text-white rounded-4">
                            <h3 class="h4 mb-4">Send me a message</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label small mb-1">Your Name</label>
                                    <input type="text" class="form-control bg-dark bg-opacity-25 text-white border-0" id="name" placeholder="John Doe">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label small mb-1">Email Address</label>
                                    <input type="email" class="form-control bg-dark bg-opacity-25 text-white border-0" id="email" placeholder="john@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label small mb-1">Message</label>
                                    <textarea class="form-control bg-dark bg-opacity-25 text-white border-0" id="message" rows="4" placeholder="Hi Ben, I'd like to talk about..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-light btn-lg w-100 mt-3">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

<a href="#" class="back-to-top btn btn-primary btn-lg rounded-circle position-fixed bottom-0 end-0 m-4" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
    <i class="fas fa-arrow-up"></i>
</a>

@endsection

{{-- 
|--------------------------------------------------------------------------
| STYLES
|--------------------------------------------------------------------------
|
| Add @stack('styles') to your <head> in layouts/app.blade.php
|
--}}
@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        color: #e0e0e0;

    }
    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 2rem;
        margin-top: 2rem;
    }
    .hero-text h1 {
        font-size: 3rem;
        font-weight: 400;
        line-height: 1.3;
        margin: 0 0 1.5rem 0;
    }
    .hero-text .highlight {
        font-weight: 700;
        color: #a855f7;
    }
    .hero-text .subtitle {
        font-size: 1rem;
        color: #a0a0a0;
        margin-bottom: 2rem;
        max-width: 400px;
    }
    .contact-button {
        font-family: 'Fira Code', monospace;
        padding: 0.75rem 1.5rem;
        border: 1px solid #4d4d4d;
        background: transparent;
        color: #a0a0a0;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-block;
    }
    .contact-button:hover {
        border-color: #e0e0e0;
        color: #e0e0e0;
    }
    .hero-image-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .hero-image {
        max-width: 400px;
        width: 100%;
        z-index: 10;
        position: relative;
    }
    .deco-square {
        position: absolute;
        border: 1px solid #a855f7;
        opacity: 0.6;
        z-index: 1;
    }
    .square-1 { top: 30px; left: 40px; width: 120px; height: 120px; }
    .square-2 { top: 50px; left: 60px; width: 120px; height: 120px; }
    .deco-dots {
        position: absolute;
        width: 75px;
        height: 75px;
        background-image: radial-gradient(circle, #4d4d4d 2px, transparent 2px);
        background-size: 15px 15px;
        z-index: 1;
        right: 40px;
        bottom: 80px;
    }
    .status-box {
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 360px;
        border: 1px solid #4d4d4d;
        padding: 0.5rem 1rem;
        background-color: #242429;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Fira Code', monospace;
        z-index: 11;
    }
    .status-box .dot {
        width: 10px;
        height: 10px;
        background-color: #a855f7;
        border-radius: 50%;
    }
    .status-box strong {
        color: #e0e0e0;
    }
    @media (max-width: 992px) {
        .hero-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .hero-text .subtitle {
            margin-left: auto;
            margin-right: auto;
        }
    }

    /* Quote Section */
    .quote-container {
        position: relative;
        border: 1px solid #555;
        color: #e0e0e0;
        font-size: 1.4rem;
        font-family: 'Fira Code', monospace;
        max-width: 800px;
        margin: 0 auto;
        background: rgba(33, 33, 33, 0.5);
        padding: 3rem 4rem;
    }
    
    .quote-text {
        position: relative;
        z-index: 2;
        line-height: 1.6;
    }
    .quote-container::before {
        content: '“';
        position: absolute;
        top: -1.2rem;
        left: 0.5rem;
        font-size: 5rem;
        font-family: serif;
        color: #555;
    }
    .quote-container::after {
        content: '”';
        position: absolute;
        bottom: -3.8rem;
        right: 0.5rem;
        font-size: 5rem;
        font-family: serif;
        color: #555;
    }
    .quote-author {
        position: absolute;
        bottom: -2rem;
        right: 2rem;
        border: 1px solid #555;
        padding: 0.75rem 1.5rem;
        background-color: #242429;
        color: #e0e0e0;
        font-size: 1rem;
    }

    /* Projects Section */
    .projects-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 3rem;
    }
    .projects-header .heading-container {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .projects-header .line {
        height: 2px;
        width: 150px;
        background-color: #a855f7;
    }
    .projects-header .view-all-link {
        font-family: 'Fira Code', monospace;
        color: #e0e0e0;
        text-decoration: none;
    }
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 8rem;
    }
    .project-card {
        background-color: #212121;
        border: 1px solid #4d4d4d;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .card-visual {
        height: 250px;
        padding: 1.5rem;
        position: relative;
    }
    .card-info {
        padding: 1.5rem;
        border-top: 1px solid #4d4d4d;
    }
    .tech-stack {
        font-family: 'Fira Code', monospace;
        color: #a0a0a0;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .card-info .title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #e0e0e0;
    }
    .card-info .description {
        color: #a0a0a0;
        margin-bottom: 1.5rem;
    }
    .card-actions {
        display: flex;
        gap: 1rem;
    }
    .action-button {
        padding: 0.5rem 1rem;
        border: 1px solid #4d4d4d;
        border-radius: 4px;
        text-decoration: none;
        color: #a0a0a0;
        font-family: 'Fira Code', monospace;
        transition: all 0.3s ease;
    }
    .action-button:hover {
        border-color: #a855f7;
        color: #e0e0e0;
    }
    .card-1-visual { 
        display: flex; 
        justify-content: space-between; 
        gap: 1rem; 
        background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
        flex-direction: column;
    }
    .card-1-visual .logo { 
        background-color: #e96d2d; 
        color: #fff; 
        font-size: 0.9rem; 
        padding: 4px 8px; 
        border-radius: 6px; 
        display: inline-block; 
        margin-bottom: 1rem; 
        width: fit-content;
    }
    .card-1-visual .title { font-size: 2rem; line-height: 1; margin: 0; color: #fff; }
    .card-1-visual .subtitle { font-size: 0.8rem; color: #a0a0a0; margin-top: 0.5rem; }
    .feature-item { 
        border: 1px solid #4d4d4d; 
        border-radius: 8px; 
        padding: 0.5rem; 
        display: flex; 
        align-items: center; 
        gap: 0.5rem; 
        font-size: 0.8rem; 
        color: #a0a0a0; 
        margin-bottom: 0.5rem; 
        background-color: rgba(0, 0, 0, 0.2);
    }
    .feature-item svg { width: 16px; height: 16px; stroke: #a0a0a0; }
    .card-2-visual { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
        position: relative;
        overflow: hidden;
    }
    .deco-line { position: absolute; background-color: #238636; }
    .deco-line.top { top: 1.5rem; left: 1.5rem; width: 1px; height: 50px; }
    .deco-line.left { top: 1.5rem; left: 1.5rem; width: 50px; height: 1px; }
    .card-3-visual { 
        display: grid; 
        place-content: center; 
        background: linear-gradient(135deg, #46178f 0%, #2e0f5e 100%);
        height: 100%;
    }
    .card-3-visual h3 { 
        font-size: 2.5rem; 
        text-align: center; 
        line-height: 1.2; 
        margin: 0;
        color: #fff;
    }
    @media (max-width: 1024px) {
        .project-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .project-grid { grid-template-columns: 1fr; }
        .projects-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .projects-header .line { width: 100px; }
    }

    /* General & Utility Styles */
    .bg-dark-soft {
        background-color: rgba(255, 255, 255, 0.03);
    }
    .section-heading {
        position: relative;
        display: inline-block;
        font-weight: 600;
    }
    .section-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 50px;
        height: 3px;
        background: var(--bs-primary);
    }
    .back-to-top {
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    .back-to-top.visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .back-to-top:hover {
        transform: translateY(-5px) !important;
    }
    .anim-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }
    .anim-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: var(--bs-dark);
    }
    ::-webkit-scrollbar-thumb {
        background: var(--bs-primary);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #0d6efd;
    }
</style>
@endpush

{{-- 
|--------------------------------------------------------------------------
| SCRIPTS
|--------------------------------------------------------------------------
|
| Add @stack('scripts') before your closing </body> in layouts/app.blade.php
|
--}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Back to top button logic
        const backToTopButton = document.querySelector('.back-to-top');
        if (backToTopButton) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('visible');
                } else {
                    backToTopButton.classList.remove('visible');
                }
            });

            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Typewriter Effect
        class TypeWriter {
            constructor(txtElement, words, wait = 3000) {
                this.txtElement = txtElement;
                this.words = words;
                this.txt = '';
                this.wordIndex = 0;
                this.wait = parseInt(wait, 10);
                this.type();
                this.isDeleting = false;
            }

            type() {
                const current = this.wordIndex % this.words.length;
                const fullTxt = this.words[current];

                if (this.isDeleting) {
                    this.txt = fullTxt.substring(0, this.txt.length - 1);
                } else {
                    this.txt = fullTxt.substring(0, this.txt.length + 1);
                }

                this.txtElement.innerHTML = `<span class="highlight">${this.txt}</span>`;

                let typeSpeed = 100;

                if (this.isDeleting) {
                    typeSpeed /= 2;
                }

                if (!this.isDeleting && this.txt === fullTxt) {
                    typeSpeed = this.wait;
                    this.isDeleting = true;
                } else if (this.isDeleting && this.txt === '') {
                    this.isDeleting = false;
                    this.wordIndex++;
                    typeSpeed = 500;
                }

                setTimeout(() => this.type(), typeSpeed);
            }
        }

        function initTypewriter() {
            const txtElement = document.querySelector('.typewriter');
            if (txtElement) {
                try {
                    const wordsData = txtElement.getAttribute('data-words');
                    if(wordsData) {
                        let words = JSON.parse(wordsData);
                        words = words.map(word => word.trim());
                        const wait = parseInt(txtElement.getAttribute('data-wait') || 2000, 10);
                        new TypeWriter(txtElement, words, wait);
                    }
                } catch (e) {
                    console.error("Failed to parse typewriter words:", e);
                }
            }
        }
        
        // Initialize with a small delay
        setTimeout(initTypewriter, 500);
    });
</script>
@endpush