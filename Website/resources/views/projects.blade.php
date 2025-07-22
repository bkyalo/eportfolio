@extends('layouts.app')

@section('content')
{{-- Debug output --}}
@php
    \Log::info('Projects in View:', [
        'all_projects_count' => $projects->count(),
        'all_projects' => $projects->toArray(),
        'complete_apps' => $projects->where('is_small_project', false)->where('is_public', true)->toArray(),
        'small_projects' => $projects->where('is_small_project', true)->where('is_public', true)->toArray()
    ]);
@endphp

<div class="main-container">
    <main>
        <section class="about-section" style="margin-bottom: 1.5rem;">
            <div class="about-text">
                <h2 class="section-heading">/projects</h2>
                <p class="mt-4 text-gray-400">
                    List of my projects
                </p>
            </div>
        </section>

        <!-- Complete Apps Section -->
        <section id="complete-apps" class="mb-16">
            <div class="flex items-center mb-8">
                <h2 class="section-heading">#complete-apps</h2>
                <div class="h-px bg-gray-700 flex-1 ml-4"></div>
            </div>
            
            @php
                $completeApps = $projects->filter(function($project) {
                    return $project->is_small_project == 0 && $project->is_public == 1;
                });
            @endphp
            
            @if($completeApps->count() > 0)
                <div class="project-grid">
                    @foreach($completeApps as $index => $project)
                        <div class="project-card-wrapper" style="--index: {{ $index }}">
                            <x-project-card 
                                :title="$project->title"
                                :description="$project->brief_description"
                                :techStack="$project->stack"
                                :image="$project->image_path"
                                :liveUrl="$project->live_url"
                                :isLive="$project->is_live"
                                :codeUrl="$project->code_url"
                                :accent="'blue'"
                                :likes="$project->likes"
                                :slug="$project->slug"
                            />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 px-4 bg-gray-50 rounded-lg">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4.5L4 7m16 0l-8 4.5M4 7v10l8 4.5m0-18.5l8 4.5m-8-4.5v18.5m8-13.5v10l8-4.5v-10l-8 4.5z" />
                        </svg>
                    </span>
                    <h3 class="mt-2 text-sm font-medium text-gray-600">No complete apps yet</h3>
                </div>
            @endif
        </section>

        <!-- Small Projects Section -->
        <section id="small-projects" class="mt-16">
            <div class="flex items-center mb-8">
                <h2 class="section-heading">#small-projects</h2>
                <div class="h-px bg-gray-700 flex-1 ml-4"></div>
            </div>
            
            @php
                $smallProjects = $projects->filter(function($project) {
                    return $project->is_small_project == 1 && $project->is_public == 1;
                });
            @endphp
            
            @if($smallProjects->count() > 0)
                <div class="project-grid">
                    @foreach($smallProjects as $index => $project)
                        <div class="project-card-wrapper" style="--index: {{ $index }}">
                            <x-project-card 
                                :title="$project->title"
                                :description="$project->brief_description"
                                :techStack="$project->stack"
                                :image="$project->image_path"
                                :liveUrl="$project->live_url"
                                :isLive="$project->is_live"
                                :codeUrl="$project->code_url"
                                :accent="'purple'"
                                :hideImage="true"
                                :likes="$project->likes"
                                :slug="$project->slug"
                            />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 px-4 bg-gray-50 rounded-lg">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </span>
                    <h3 class="mt-2 text-sm font-medium text-gray-600">No small projects yet</h3>
                </div>
            @endif
        </section>
        </div>
    </main>
</div>
@endsection

@push('styles')
<style>
    /* Project Grid Styles */
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        width: 100%;
    }

    .project-card-wrapper {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
        animation-delay: calc(var(--index) * 0.1s);
    }

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

    /* Project Card Styles */
    .project-card {
        background-color: #1e1e2e;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #2d2d3a;
    }

    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .card-image-container {
        position: relative;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        overflow: hidden;
    }

    .card-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .project-card:hover .card-image {
        transform: scale(1.05);
    }

    .card-tech-stack {
        padding: 0.75rem 1rem;
        background-color: rgba(30, 30, 46, 0.8);
        border-bottom: 1px solid #2d2d3a;
    }

    .card-tech-stack span {
        font-family: 'Fira Code', monospace;
        font-size: 0.8rem;
        color: #a9b1d6;
    }

    .card-info {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-info h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: #cdd6f4;
    }

    .card-info p {
        color: #a6adc8;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .card-actions {
        margin-top: auto;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background-color: #45475a;
        color: #cdd6f4;
        border-radius: 4px;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .action-button:hover {
        background-color: #585b70;
        color: #ffffff;
    }

    .action-button .text-mono {
        font-family: 'Fira Code', monospace;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .project-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

document.addEventListener('DOMContentLoaded', function() {
    // Add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle like button clicks
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const projectSlug = this.getAttribute('data-project-slug');
            const icon = this.querySelector('svg');
            const isLiked = this.classList.contains('text-yellow-400');
            
            // Don't allow multiple likes
            if (isLiked) return;
            
            // Visual feedback
            this.classList.add('animate-ping-once');
            
            // Send AJAX request to like the project
            fetch(`/projects/${projectSlug}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    this.classList.add('text-yellow-400');
                    icon.setAttribute('fill', 'currentColor');
                    this.setAttribute('title', 'You liked this project');
                    
                    // Set a cookie to remember the like
                    setCookie(`liked_project_${projectSlug}`, '1', 365);
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        this.classList.remove('animate-ping-once');
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.classList.remove('animate-ping-once');
            });
        });
    });
});
</script>

<style>
    /* Animation for like button */
    .animate-ping-once {
        animation: ping 0.5s cubic-bezier(0, 0, 0.2, 1);
    }
    
    @keyframes ping {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        75%, 100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }
    
    /* Style for the like button */
    .like-button {
        transition: all 0.2s ease;
    }
    
    .like-button:hover {
        transform: scale(1.1);
    }
    
    .like-button:active {
        transform: scale(0.95);
    }
</style>
@endpush
