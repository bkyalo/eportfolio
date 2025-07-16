@props([
    'title' => '',
    'description' => '',
    'techStack' => '',
    'image' => 'images/projects/placeholder.jpg',
    'liveUrl' => '#',
    'codeUrl' => '#',
    'category' => 'Project',
    'accentColor' => 'purple'
])

<div class="project-card">
    <img class="card-image" src="{{ asset('storage/' . $image) }}" alt="{{ $title }}">

    <div class="card-tech-stack">
        {{ $techStack }}
    </div>
    
    <div class="card-info">
        <h2 class="title">{{ $title }}</h2>
        <p class="description">{{ $description }}</p>
        
        <div class="card-actions">
            @if($liveUrl !== '#')
            <a href="{{ $liveUrl }}" class="action-button btn-live" target="_blank" rel="noopener noreferrer">
                <span>Live <span class="text-mono">&lt;~&gt;</span></span>
            </a>
            @endif
            <a href="{{ $codeUrl }}" class="action-button btn-cached" target="_blank" rel="noopener noreferrer">
                <span>Code</span>
                <span class="text-mono">&gt;</span>
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
        border: 2px solid var(--border-color-secondary);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        background-color: #1a1a1a;
    }

    .card-tech-stack {
        font-family: var(--font-mono);
        color: var(--text-secondary);
        font-size: 0.9rem;
        padding: 12px 20px;
        border-bottom: 1px solid var(--border-color-secondary);
        background-color: rgba(255, 255, 255, 0.02);
    }

    .card-info {
        padding: 20px;
    }

    .card-info .title {
        color: var(--text-primary);
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .card-info .description {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0 0 20px 0;
        line-height: 1.5;
    }

    .card-actions {
        display: flex;
        gap: 12px;
        margin-top: 16px;
    }

    .action-button {
        flex: 1;
        padding: 10px 16px;
        border-radius: 4px;
        background-color: transparent;
        font-size: 0.95rem;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        border: 1px solid;
    }
    
    .btn-live {
        border-color: #a855f7;
        color: #a855f7;
    }
    
    .btn-live:hover {
        background-color: rgba(168, 85, 247, 0.1);
    }

    .btn-cached {
        border-color: var(--border-color-secondary);
        color: var(--text-secondary);
    }

    .btn-cached:hover {
        border-color: var(--text-secondary);
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
    }

    .text-mono {
        font-family: var(--font-mono);
    }
</style>
@endonce
