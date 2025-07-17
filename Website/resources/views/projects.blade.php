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
        <section class="about-section">
            <div class="about-text">
                <h2 class="section-heading">/projects</h2>
                <p class="mt-4 text-gray-400">
                    List of my projects
                </p>
            </div>
        </section>

        <div class="mt-12">

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
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($completeApps as $project)
                        <x-project-card 
                            :title="$project->title"
                            :description="$project->brief_description"
                            :techStack="$project->stack"
                            :image="$project->image_path"
                            :liveUrl="$project->live_url"
                            :isLive="$project->is_live"
                            :codeUrl="$project->code_url"
                            :accent="'blue'"
                        />
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
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($smallProjects as $project)
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
                        />
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
        
            @auth
                <div class="mt-12 text-center">
                    <a href="{{ route('admin.projects.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New Project
                    </a>
                </div>
            @endauth
        </div>
    </main>
</div>
@endsection
