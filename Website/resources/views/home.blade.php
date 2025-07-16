@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Hero Section -->
    <section id="home" class="hero-section py-5 py-lg-6">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-text">
                    <h1>{{ $contact->name ?? 'Ben Tito' }} is a <span class="highlight typewriter" data-words='[{{ $contact->tags ? collect(explode(',', $contact->tags))->map(fn($tag) => '"' . trim($tag) . '"')->implode(',') : '' }}]' data-wait="2000"></span></h1>
                    @if($contact->home_description)
                        <p class="subtitle">{{ $contact->home_description }}</p>
                    @else
                        <p class="subtitle">Bridging engineering and technology to create innovative solutions</p>
                    @endif
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

    <style>
        /* Hero Section */
        .hero-section {
            color: #e0e0e0;
            font-family: 'Inter', sans-serif;
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
    </style>

    <!-- Quote Section -->
    <section class="quote-section py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                @if($contact->saying)
                    <blockquote class="anim-on-scroll position-relative py-4">
                        <i class="fas fa-quote-left text-muted position-absolute" style="top: 0; left: -1.5rem; font-size: 3rem; opacity: 0.2;"></i>
                        <p class="h4 fst-italic mb-4">"{{ $contact->saying }}"</p>
                        @if($contact->saying_author)
                            <footer class="text-muted">— {{ $contact->saying_author }}</footer>
                        @endif
                        <i class="fas fa-quote-right text-muted position-absolute" style="bottom: 0; right: -1.5rem; font-size: 3rem; opacity: 0.2;"></i>
                    </blockquote>
                @endif
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="works" class="projects-section">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">My Portfolio</span>
                <h2>Featured Projects</h2>
                <p>Here are some of my recent projects that showcase my skills and expertise in various technologies.</p>
            </div>
            
            <div class="mt-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $index => $project)
                        <div class="project-card-wrapper" style="--index: {{ $index }}">
                            <x-project-card 
                                :title="$project['title']"
                                :description="$project['description']"
                                :techStack="$project['tech_stack']"
                                :image="$project['image']"
                                :liveUrl="$project['live_url']"
                                :codeUrl="$project['code_url']"
                                :accent="$project['accent'] ?? 'purple'"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="view-more">
                <a href="#" class="btn btn-outline-primary">
                    View All Projects <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Skills Section -->
    <section id="skills" class="skills-section py-5 my-5 bg-dark rounded-4">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-heading mb-3">#skills</h2>
                <p class="text-muted lead">Technical Proficiencies & Expertise</p>
            </div>
            
            <div class="row g-4">
                @foreach($skills as $category)
                <div class="col-md-6 col-lg-3">
                    <div class="skill-category h-100 p-4 rounded-3 bg-dark-soft">
                        <div class="skill-category-header d-flex align-items-center mb-4">
                            <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                <i class="{{ $category['icon'] }} text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">{{ $category['title'] }}</h3>
                        </div>
                        
                        @if(isset($category['skills']))
                        <div class="skills-list">
                            @foreach($category['skills'] as $skill)
                            <div class="skill-item mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small text-muted">{{ $skill['name'] }}</span>
                                    <span class="small text-muted">{{ $skill['level'] }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $skill['level'] }}%" 
                                         aria-valuenow="{{ $skill['level'] }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @elseif(isset($category['tags']))
                        <div class="skills-list d-flex flex-wrap gap-2">
                            @foreach($category['tags'] as $tag)
                            <span class="badge bg-dark text-white border border-secondary">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
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

    <!-- Contact Section -->
    <section id="contacts" class="contact-section py-5 my-5">
        <div class="text-center mb-5">
            <h2 class="section-heading anim-on-scroll">#contacts</h2>
            <p class="lead text-muted">Get in touch with me</p>
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
    
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top btn btn-primary btn-lg rounded-circle position-fixed bottom-0 end-0 m-4" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
        <i class="fas fa-arrow-up"></i>
    </a>
    
    <style>
        /* Custom styles for the home page */
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
        
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
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
        
        /* Animation classes */
        .anim-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        .anim-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Custom scrollbar */
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
    
    <script>
        // Back to top button
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.querySelector('.back-to-top');
            
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
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            const init = () => {
                const txtElement = document.querySelector('.typewriter');
                if (txtElement) {
                    let words = JSON.parse(txtElement.getAttribute('data-words'));
                    // Process words to ensure they're properly formatted
                    words = words.map(word => word.trim());
                    const wait = parseInt(txtElement.getAttribute('data-wait') || 2000, 10);
                    new TypeWriter(txtElement, words, wait);
                }
            };

            // Initialize with a small delay to ensure DOM is fully loaded
            setTimeout(init, 500);
        });
    </script>
@endsection