@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block">My Projects</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                A collection of my work and contributions to various projects.
            </p>
        </div>

        <!-- Project Filters -->
        <div class="mb-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('projects.index') }}" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ !request('filter') ? 'bg-blue-100 text-blue-800' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                All Projects
            </a>
            <a href="{{ route('projects.index', ['filter' => 'featured']) }}" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ request('filter') === 'featured' ? 'bg-blue-100 text-blue-800' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                Featured
            </a>
            <a href="{{ route('projects.index', ['filter' => 'small']) }}" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ request('filter') === 'small' ? 'bg-blue-100 text-blue-800' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                Small Projects
            </a>
        </div>

        <!-- Projects Grid -->
        @if($projects->count() > 0)
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($projects as $project)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white hover:shadow-xl transition-shadow duration-300">
                        @if($project->image_path)
                            <div class="h-48 overflow-hidden">
                                <img class="w-full h-full object-cover" 
                                     src="{{ asset('storage/' . $project->image_path) }}" 
                                     alt="{{ $project->title }}">
                            </div>
                        @endif
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium 
                                              {{ $project->is_small_project ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $project->is_small_project ? 'Small Project' : 'Featured' }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ $project->created_at->format('M Y') }}
                                    </span>
                                </div>
                                <a href="{{ route('projects.show', $project) }}" class="block mt-2">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $project->title }}</h3>
                                    <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                        {{ $project->brief_description }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex space-x-1">
                                        @foreach(explode(',', $project->stack) as $tech)
                                            @if($loop->index < 3)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ trim($tech) }}
                                                </span>
                                            @endif
                                        @endforeach
                                        @if(count(explode(',', $project->stack)) > 3)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                +{{ count(explode(',', $project->stack)) - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    @if($project->is_live && $project->live_url)
                                        <a href="{{ $project->live_url }}" target="_blank" 
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Live Demo
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No projects found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    There are no projects to display at the moment. Please check back later!
                </p>
                @auth
                    <div class="mt-6
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
        @endif
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
