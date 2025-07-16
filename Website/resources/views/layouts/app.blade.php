<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ben Tito')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Link to your compiled CSS file --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    
    {{-- Add your custom styles here or in the app.css file --}}
    <style>
        /* All the CSS from your original file goes here */
        :root {
            --bg-color: #0d1117;
            --text-color: #c9d1d9;
            /* ... (rest of your CSS) */
        }
        
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: var(--font-primary);
        }

        @tailwind base;
@tailwind components;
@tailwind utilities;

/* ====================
   GLOBAL VARIABLES & RESET
   ==================== */
   :root {
    /* Color Palette */
    --bg-color: #0d1117;
    --text-color: #c9d1d9;
    --text-color-light: #f0f6fc;
    --heading-color: #ffffff;
    --card-bg: #161b22;
    --border-color: #30363d;
    --accent-purple: #8250df;
    --accent-green: #238636;
    --accent-red: #da3633;
    
    /* Typography */
    --font-primary: 'Fira Code', monospace;
    --font-mono: 'Fira Code', monospace;
    
    /* Spacing */
    --space-xs: 0.5rem;
    --space-sm: 1rem;
    --space-md: 1.5rem;
    --space-lg: 2rem;
    --space-xl: 3rem;
    --space-xxl: 6rem; /* Added for consistency */

    /* Border Radius */
    --radius-sm: 0;
    --radius-md: 0;
    --radius-lg: 0;
}

/* Reset & Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
    font-size: 16px;
}

body {
    background-color: var(--bg-color);
    color: var(--text-color);
    font-family: var(--font-primary);
    line-height: 1.6;
    overflow-x: hidden;
    padding: 0 var(--space-md);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    font-feature-settings: 'calt' 1;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
    position: relative;
}

h1, h2, h3 {
    color: var(--heading-color);
    font-weight: 700;
}

section {
    padding: 6rem 0;
    position: relative;
}

.section-heading {
    font-family: var(--font-mono);
    font-size: 2rem;
    margin-bottom: 3rem;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
}

.section-heading::after {
    content: '';
    display: block;
    width: 80px;
    height: 2px;
    background-color: var(--accent-purple);
}

a {
    color: var(--text-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: var(--accent-purple);
}

/* --- Header & Navigation --- */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-md) 0;
    margin-bottom: var(--space-xl);
    border-bottom: 1px solid var(--border-color);
    position: relative;
}

.header-logo {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--heading-color);
    font-family: var(--font-mono);
    text-decoration: none;
    transition: all 0.3s ease;
}

.header-logo:hover {
    color: var(--accent-purple);
    transform: translateY(-1px);
}

.header-nav {
    display: flex;
    gap: var(--space-lg);
    align-items: center;
}

.header-nav a {
    color: var(--text-color);
    text-decoration: none;
    font-family: var(--font-mono);
    font-size: 0.95rem;
    transition: all 0.3s ease;
    position: relative;
    padding: var(--space-xs) 0;
}

.header-nav a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: var(--accent-purple);
    transition: width 0.3s ease;
}

.header-nav a:hover,
.header-nav a.active {
    color: var(--accent-purple);
}

.header-nav a:hover::after,
.header-nav a.active::after {
    width: 100%;
}

.lang-switcher {
    color: var(--text-color);
    font-family: var(--font-mono);
    cursor: pointer;
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
    z-index: 100;
}

.social-sidebar svg {
    width: 24px;
    height: 24px;
    fill: var(--text-color);
    transition: fill 0.3s ease;
}

.social-sidebar a:hover svg {
    fill: var(--accent-purple);
}

/* --- About Me Section --- */
.about-section {
    position: relative;
    padding: 4rem 0;
}

.about-content {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: var(--space-xl);
    align-items: center;
}

.about-text h3 {
    font-size: 2.2rem;
    color: var(--heading-color);
    margin-bottom: var(--space-md);
    line-height: 1.3;
    font-weight: 700;
    background: linear-gradient(135deg, #ffffff, #b4b4b4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.about-text p {
    margin-bottom: var(--space-md);
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-color-light);
    max-width: 90%;
}

.about-text p:last-of-type {
    margin-bottom: var(--space-lg);
}

.about-image {
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    border-radius: 0;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    transition: transform 0.5s ease, box-shadow 0.5s ease;
}

.about-image:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
}

.about-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.5s ease;
    border-radius: 0;
}

.about-image:hover img {
    transform: scale(1.05);
}

.about-image .dots {
    position: absolute;
    z-index: 1;
    width: 100px;
    height: 100px;
    background-image: radial-gradient(circle, var(--border-color) 1px, transparent 1px);
    background-size: 15px 15px;
}

/* --- Experience Section --- */
.experience-section {
    margin-bottom: var(--space-xxl);
    position: relative;
}

.experience-item {
    background: var(--card-bg); /* Adjusted background */
    border-radius: 0;
    padding: var(--space-lg);
    position: relative;
    border-left: 4px solid var(--accent-purple);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: var(--space-lg); /* Added margin for spacing */
}

.experience-item:hover {
    transform: translateX(10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    border-left-color: var(--accent-green);
}

.experience-item h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--heading-color);
}

.experience-item .company {
    color: var(--accent-green);
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0.25rem 0;
}

.experience-item .duration {
    color: var(--text-color);
    font-size: 0.9rem;
    font-family: var(--font-mono);
    margin-bottom: var(--space-sm);
}

.experience-item ul {
    list-style-type: none;
    padding-left: 0;
    margin-top: var(--space-sm);
}

.experience-item li {
    position: relative;
    padding-left: 2rem;
    margin-bottom: 0.75rem;
}

.experience-item li::before {
    content: '▹';
    position: absolute;
    left: 0;
    color: var(--accent-purple);
    font-size: 1.2rem;
}

/* ====================
   SKILLS SECTION
   ==================== */
.skills-section {
    position: relative;
    overflow: hidden;
}

.skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: var(--space-lg);
    margin-top: var(--space-xl);
}

.skill-category {
    background: var(--card-bg);
    border-radius: 0;
    padding: var(--space-lg);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid var(--border-color);
}

.skill-category:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    border-color: var(--accent-purple);
}

.skill-category h3 {
    color: var(--heading-color);
    font-size: 1.3rem;
    margin-bottom: var(--space-lg);
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    padding-bottom: var(--space-sm);
    border-bottom: 1px solid var(--border-color);
}

.skill-category h3 i {
    color: var(--accent-purple);
    font-size: 1.5rem;
}

.skills-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.skill-tag {
    background: var(--bg-color);
    color: var(--text-color-light);
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-family: var(--font-mono);
    border: 1px solid var(--border-color);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* ====================
   PUBLICATIONS SECTION
   ==================== */
.publications-section {
    padding: 6rem 0;
    background-color: var(--bg-color);
}

.publications-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: flex-start;
}

.books-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.book-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.book-card:hover {
    transform: translateY(-5px);
    border-color: var(--accent-purple);
}

.book-cover {
    position: relative;
    padding-top: 140%; /* Aspect ratio for book covers */
    background: #30363d;
}

.book-cover img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-info {
    padding: 1.5rem;
    flex-grow: 1;
}

.book-info h3 {
    font-size: 1.3rem;
    margin: 0 0 0.5rem 0;
}

.book-info .publisher {
    color: var(--accent-green);
    font-size: 0.95rem;
    font-family: var(--font-mono);
    margin-bottom: 0.5rem;
}

.book-info .isbn {
    color: var(--text-color);
    font-size: 0.85rem;
    font-family: var(--font-mono);
    opacity: 0.8;
}

.publication-description {
    position: sticky;
    top: 2rem;
}

.publication-description .subtitle {
    font-size: 1.5rem;
    color: var(--accent-green);
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.description-content p {
    margin-bottom: 1.25rem;
    line-height: 1.7;
    color: var(--text-color-light);
}


/* --- Fun Facts Section --- */
.fun-facts-section {
    position: relative;
    padding-bottom: 6rem;
}

.facts-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    max-width: 100%;
}

.fact-item {
    border: 1px solid var(--border-color);
    padding: 0.5rem 1rem;
    color: var(--text-color);
    font-size: 0.9rem;
    font-family: var(--font-mono);
    background: var(--card-bg);
    transition: all 0.3s ease;
}

.fact-item:hover {
    border-color: var(--accent-purple);
    color: var(--text-color-light);
}


/* --- The Drawings --- */
.drawing {
    position: absolute;
    z-index: -1;
    opacity: 0.7;
    display: none; /* Hidden by default, enable for larger screens */
}

@media (min-width: 1024px) {
    .drawing {
        display: block;
    }
}

.dots {
    width: 75px;
    height: 75px;
    background-image: radial-gradient(circle, var(--border-color) 1px, transparent 1px);
    background-size: 15px 15px;
}

.shape {
    border: 1px solid var(--border-color);
    background: transparent;
}

.purple-shape {
    border-color: var(--accent-purple);
    opacity: 0.6;
}

.drawing-1 { top: 20px; right: 150px; }
.drawing-2 { top: 100px; left: -40px; width: 100px; height: 100px; }
.drawing-3 { top: 150px; right: 80px; }
.drawing-3 .shape-1 { width: 90px; height: 90px; position: relative; }
.drawing-3 .shape-2 { width: 90px; height: 90px; top: 20px; left: 20px; position: absolute; }
.drawing-4 { bottom: -20px; right: 120px; }
.drawing-5 { bottom: -50px; right: -20px; }

/* --- Footer --- */
.footer-wrapper {
    border-top: 1px solid var(--border-color);
    margin-top: var(--space-xl);
}

.site-footer {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: var(--font-mono);
}

.footer-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-info h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.footer-info h3 span {
    color: #8b949e;
}

.footer-info p {
    color: #8b949e;
    margin: 0;
}

.footer-media h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.footer-social-links {
    display: flex;
    gap: 1rem;
}

.footer-social-links a {
    color: var(--text-color);
    transition: color 0.3s ease;
}

.footer-social-links a:hover {
    color: var(--accent-purple);
}

.footer-social-links svg {
    width: 24px;
    height: 24px;
    fill: currentColor;
}

.footer-copyright {
    text-align: center;
    color: #8b949e;
    font-size: 0.9rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

/* --- Responsive Adjustments --- */
@media (max-width: 1024px) {
    .publications-layout {
        grid-template-columns: 1fr;
    }
    .publication-description {
        position: static;
        margin-top: 2rem;
    }
}

@media (max-width: 768px) {
    .about-content {
        grid-template-columns: 1fr;
    }
    .header-nav {
        display: none; /* Example: hide for a mobile menu */
    }
    .books-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 600px) {
    .books-grid {
        grid-template-columns: 1fr;
    }
    .book-card {
        max-width: 300px;
        margin: 0 auto;
    }
    .footer-top {
        flex-direction: column;
    }
}
    </style>
</head>
<body>

    <aside class="social-sidebar">
        <a href="https://github.com/bkyalo" target="_blank"><i class="fab fa-github"></i></a>
        <a href="https://x.com/bentitojr" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://facebook.com/tito.kyalo" target="_blank"><i class="fab fa-facebook"></i></a>
    </aside>

    <div class="container">
        @include('components.header')

        <main>
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    {{-- Link to your compiled JS file --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>