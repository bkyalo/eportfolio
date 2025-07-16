<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ben Tito - Electrical Engineer & Software Developer' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Social Sidebar -->
    <aside class="social-sidebar d-none d-lg-flex">
        <div class="d-flex flex-column gap-4">
            <a href="https://github.com/bkyalo" target="_blank" rel="noopener noreferrer" aria-label="GitHub" data-bs-toggle="tooltip" data-bs-placement="right" title="GitHub">
                <i class="fab fa-github"></i>
            </a>
            <a href="https://linkedin.com/in/yourprofile" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" data-bs-toggle="tooltip" data-bs-placement="right" title="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://x.com/bentitojr" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" data-bs-toggle="tooltip" data-bs-placement="right" title="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <div class="vertical-line"></div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <!-- Navigation -->
        <header class="header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="header-logo">Ben Tito</div>
                    <nav class="header-nav d-none d-md-flex align-items-center">
                        <a href="#home" class="{{ request()->is('/') ? 'active' : '' }}">#home</a>
                        <a href="#works">#projects</a>
                        <a href="#skills">#skills</a>
                        <a href="#about-me">#about-me</a>
                        <a href="#contacts">#contacts</a>
                        <span class="lang-switcher ms-3">EN</span>
                    </nav>
                    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <!-- Mobile Menu -->
                <div class="collapse d-md-none" id="mobileMenu">
                    <div class="d-flex flex-column gap-2 mt-3">
                        <a href="#home" class="nav-link {{ request()->is('/') ? 'active' : '' }}">#home</a>
                        <a href="#works" class="nav-link">#projects</a>
                        <a href="#skills" class="nav-link">#skills</a>
                        <a href="#about-me" class="nav-link">#about-me</a>
                        <a href="#contacts" class="nav-link">#contacts</a>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="text-muted">Language:</span>
                            <span class="lang-switcher">EN</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="site-footer bg-dark text-white py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="footer-info">
                            <h3 class="h4 mb-3">Ben Tito Kyalo <span class="d-block text-muted">benkyalo075@gmail.com</span></h3>
                            <p class="mb-0">Electrical Engineer & Software Developer</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="footer-media">
                            <h4 class="h5 mb-3">Media</h4>
                            <div class="footer-social-links d-flex gap-3">
                                <a href="https://github.com/bkyalo" target="_blank" rel="noopener noreferrer" class="text-white" aria-label="GitHub">
                                    <i class="fab fa-github fa-lg"></i>
                                </a>
                                <a href="https://x.com/bentitojr" target="_blank" rel="noopener noreferrer" class="text-white" aria-label="X (Twitter)">
                                    <i class="fab fa-twitter fa-lg"></i>
                                </a>
                                <a href="https://linkedin.com/in/yourprofile" target="_blank" rel="noopener noreferrer" class="text-white" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in fa-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-copyright text-center text-muted mt-4 pt-3 border-top border-secondary">
                    &copy; {{ date('Y') }} Ben Tito Kyalo. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Add intersection observer for scroll animations
            const animateOnScroll = document.querySelectorAll('.anim-on-scroll');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            animateOnScroll.forEach(element => {
                observer.observe(element);
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        const mobileMenu = document.getElementById('mobileMenu');
                        if (mobileMenu && mobileMenu.classList.contains('show')) {
                            const bsCollapse = new bootstrap.Collapse(mobileMenu, {toggle: false});
                            bsCollapse.hide();
                        }
                    }
                });
            });
            
            // Add active class to nav links on scroll
            const sections = document.querySelectorAll('section[id]');
            
            function onScroll() {
                const scrollPosition = window.scrollY + 100;
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');
                    
                    if (scrollPosition >= sectionTop && scrollPosition <= sectionTop + sectionHeight) {
                        document.querySelector(`.header-nav a[href*="${sectionId}"]`).classList.add('active');
                        document.querySelector(`#mobileMenu .nav-link[href*="${sectionId}"]`).classList.add('active');
                    } else {
                        const navLink = document.querySelector(`.header-nav a[href*="${sectionId}"]`);
                        const mobileNavLink = document.querySelector(`#mobileMenu .nav-link[href*="${sectionId}"]`);
                        
                        if (navLink && !navLink.getAttribute('href').endsWith('#home')) {
                            navLink.classList.remove('active');
                        }
                        if (mobileNavLink && !mobileNavLink.getAttribute('href').endsWith('#home')) {
                            mobileNavLink.classList.remove('active');
                        }
                    }
                });
                
                // Special case for home link
                if (scrollPosition < 100) {
                    document.querySelector('.header-nav a[href$="#home"], #mobileMenu .nav-link[href$="#home"]').classList.add('active');
                } else {
                    document.querySelectorAll('.header-nav a[href$="#home"], #mobileMenu .nav-link[href$="#home"]').forEach(el => {
                        if (!el.classList.contains('active')) return;
                        if (scrollPosition > document.querySelector('#home').offsetHeight) {
                            el.classList.remove('active');
                        }
                    });
                }
            }
            
            window.addEventListener('scroll', onScroll);
            onScroll(); // Run once on load
        });
    </script>
    
    @stack('scripts')
</body>
</html>