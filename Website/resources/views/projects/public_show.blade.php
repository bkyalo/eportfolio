@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Project Header -->
    <div class="relative pb-32 bg-gray-800">
        <div class="absolute inset-0">
            @if($project->image_path)
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}">
                <div class="absolute inset-0 bg-gray-800 mix-blend-multiply" aria-hidden="true"></div>
            @else
                <div class="absolute inset-0 bg-gradient-to-r from-blue-800 to-indigo-700"></div>
            @endif
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">
                {{ $project->title }}
            </h1>
            <p class="mt-6 max-w-3xl text-xl text-gray-300">
                {{ $project->brief_description }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                @foreach(explode(',', $project->stack) as $tech)
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ trim($tech) }}
                    </span>
                @endforeach
            </div>
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                @if($project->is_live && $project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        View Live Project
                    </a>
                @endif
                @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.167 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.154-1.11-1.461-1.11-1.461-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.14 20.16 22 16.416 22 12c0-5.523-4.477-10-10-10z"></path>
                        </svg>
                        View on GitHub
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Project Details -->
    <div class="relative -mt-12">
        <div class="max-w-7xl mx-auto px-4 pb-12 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="md:flex">
                    <div class="p-8 flex-1">
                        <div class="prose max-w-none">
                            <h2>About This Project</h2>
                            {!! nl2br(e($project->brief_description)) !!}
                            
                            @if($project->github_url || $project->live_url)
                                <div class="mt-8 pt-6 border-t border-gray-200">
                                    <h3>Project Links</h3>
                                    <ul>
                                        @if($project->live_url)
                                            <li>
                                                <strong>Live URL:</strong> 
                                                <a href="{{ $project->live_url }}" target="_blank" class="text-blue-600 hover:underline">
                                                    {{ $project->live_url }}
                                                </a>
                                            </li>
                                        @endif
                                        @if($project->github_url)
                                            <li>
                                                <strong>GitHub:</strong> 
                                                <a href="{{ $project->github_url }}" target="_blank" class="text-blue-600 hover:underline">
                                                    {{ $project->github_url }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-8 bg-gray-50 md:w-1/3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Project Details</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                              {{ $project->status === 'complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ str_replace('_', ' ', ucfirst($project->status)) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Technologies Used</h4>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach(explode(',', $project->stack) as $tech)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ trim($tech) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Project Type</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $project->is_small_project ? 'Small Project' : 'Featured Project' }}
                                </p>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Last Updated</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $project->updated_at->format('F j, Y') }}
                                </p>
                            </div>
                        </div>
                        
                        @auth
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.projects.edit', $project) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Edit Project
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Projects -->
    @if($relatedProjects->count() > 0)
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-8">More Projects</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($relatedProjects as $relatedProject)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            @if($relatedProject->image_path)
                                <div class="h-48 overflow-hidden">
                                    <img class="w-full h-full object-cover" 
                                         src="{{ asset('storage/' . $relatedProject->image_path) }}" 
                                         alt="{{ $relatedProject->title }}">
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900">{{ $relatedProject->title }}</h3>
                                <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                                    {{ $relatedProject->brief_description }}
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('projects.show', $relatedProject) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                        View project<span aria-hidden="true"> &rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- CTA Section -->
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
</div>
@endsection
