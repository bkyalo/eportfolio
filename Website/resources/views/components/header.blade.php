<header class="header">
    <a href="{{ route('home') }}" class="header-logo">Ben Tito</a>
    <nav class="header-nav">
        <a href="{{ route('home') }}#home" class="{{ request()->is('/') ? 'active' : '' }}">#home</a>
        <a href="{{ route('home') }}#works">#projects</a>
        <a href="{{ route('home') }}#skills">#skills</a>
        <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">#about-me</a>
        <a href="{{ route('contact') }}">#contacts</a>
        <span class="lang-switcher">EN</span>
    </nav>
</header>