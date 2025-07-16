@props([
    'title' => '',
    'description' => '',
    'techStack' => '',
    'image' => 'images/projects/placeholder.jpg',
    'liveUrl' => '#',
    'codeUrl' => '#',
    'category' => 'Project',
    'accent' => 'purple' // purple, green, or red
])

<div class="project-card group" data-accent="{{ $accent }}">
    <div class="card-image-container overflow-hidden">
        <img class="card-image w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
             src="{{ asset('storage/' . $image) }}" 
             alt="{{ $title }}">
    </div>

    <div class="card-tech-stack px-4 py-3 border-b border-border-color bg-gray-900/30">
        <span class="text-sm font-mono text-gray-400">{{ $techStack }}</span>
    </div>
    
    <div class="card-info p-5 flex flex-col h-full">
        <h2 class="title text-xl font-bold mb-2 text-gray-100">{{ $title }}</h2>
        <p class="description text-gray-400 mb-4 flex-grow">{{ $description }}</p>
        
        <div class="card-actions mt-auto">
            @if($liveUrl !== '#')
            <a href="{{ $liveUrl }}" 
               class="action-button btn-live group/btn" 
               target="_blank" 
               rel="noopener noreferrer">
                <span>Live <span class="text-mono">&lt;~&gt;</span></span>
                <span class="opacity-0 group-hover/btn:opacity-100 ml-2 transition-opacity duration-300">→</span>
            </a>
            @endif
            <a href="{{ $codeUrl }}" 
               class="action-button btn-cached group/btn" 
               target="_blank" 
               rel="noopener noreferrer">
                <span>Code</span>
                <span class="opacity-0 group-hover/btn:opacity-100 ml-2 transition-opacity duration-300">→</span>
            </a>
        </div>
    </div>
</div>

@once
<style>
    .project-card {
        background-color: var(--card-bg);
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .project-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(145deg, transparent 0%, rgba(130, 80, 223, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border-color: var(--accent-purple);
    }

    .project-card:hover::before {
        opacity: 1;
    }

    .project-card[data-accent="red"] {
        border-color: var(--border-color);
    }

    .project-card[data-accent="red"]:hover {
        border-color: var(--accent-red);
    }

    .project-card[data-accent="green"] {
        border-color: var(--border-color);
    }

    .project-card[data-accent="green"]:hover {
        border-color: var(--accent-green);
    }

    .card-image-container {
        height: 200px;
        position: relative;
        overflow: hidden;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .project-card:hover .card-image {
        transform: scale(1.05);
    }

    .card-tech-stack {
        font-family: var(--font-mono);
        color: var(--text-secondary);
        font-size: 0.9rem;
        padding: 12px 20px;
        border-bottom: 1px solid var(--border-color);
        background-color: rgba(22, 27, 34, 0.7);
        backdrop-filter: blur(5px);
        position: relative;
        z-index: 2;
    }

    .card-info {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: var(--card-bg);
        position: relative;
        z-index: 2;
    }

    .card-info .title {
        color: var(--heading-color);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 12px 0;
        line-height: 1.3;
        transition: color 0.3s ease;
    }

    .project-card:hover .title {
        color: var(--accent-purple);
    }

    .project-card[data-accent="red"]:hover .title {
        color: var(--accent-red);
    }

    .project-card[data-accent="green"]:hover .title {
        color: var(--accent-green);
    }

    .card-info .description {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0 0 24px 0;
        line-height: 1.6;
        flex-grow: 1;
    }

    .card-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    .action-button {
        flex: 1;
        padding: 10px 16px;
        border-radius: 6px;
        background-color: transparent;
        font-size: 0.95rem;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background-color: currentColor;
        transition: width 0.3s ease;
        z-index: -1;
        opacity: 0.1;
    }

    .action-button:hover::before {
        width: 100%;
    }
    
    .btn-live {
        border-color: var(--accent-purple);
        color: var(--accent-purple);
    }
    
    .btn-live:hover {
        background-color: rgba(130, 80, 223, 0.1);
        transform: translateY(-2px);
    }

    .project-card[data-accent="red"] .btn-live {
        border-color: var(--accent-red);
        color: var(--accent-red);
    }

    .project-card[data-accent="red"] .btn-live:hover {
        background-color: rgba(218, 54, 51, 0.1);
    }

    .project-card[data-accent="green"] .btn-live {
        border-color: var(--accent-green);
        color: var(--accent-green);
    }

    .project-card[data-accent="green"] .btn-live:hover {
        background-color: rgba(35, 134, 54, 0.1);
    }

    .btn-cached {
        border-color: var(--border-color);
        color: var(--text-secondary);
    }

    .btn-cached:hover {
        border-color: var(--text-color);
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        transform: translateY(-2px);
    }

    .text-mono {
        font-family: var(--font-mono);
    }

    /* Animation for the card entry */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .project-card {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    /* Staggered animation for cards */
    .projects-grid .project-card {
        animation-delay: calc(var(--index) * 0.1s);
    }
</style>
@endonce
