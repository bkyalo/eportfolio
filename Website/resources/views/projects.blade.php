@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block">/projects</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                List of my projects
            </p>
        </div>

        <!-- Complete Apps Section -->
        <section id="complete-apps" class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">#complete-apps</h2>
                <div class="h-px bg-gray-200 flex-1 ml-4"></div>
            </div>
            
            @php
                $completeApps = $projects->where('is_small_project', false);
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
        <section id="small-projects">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">#small-projects</h2>
                <div class="h-px bg-gray-200 flex-1 ml-4"></div>
            </div>
            
            @php
                $smallProjects = $projects->where('is_small_project', true);
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
</div>

<!-- Call to Action -->
<div class="bg-blue-700">
    <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            <span class="block">Have a project in mind?</span>
            <span class="block">Let's work together.</span>
        </h2>
        <p class="mt-4 text-lg leading-6 text-blue-200">
            I'm always open to discussing product design work or partnership opportunities.
        </p>
        <a href="#contact" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 sm:w-auto">
            Get in touch
        </a>
    </div>
</div>
@endsection
