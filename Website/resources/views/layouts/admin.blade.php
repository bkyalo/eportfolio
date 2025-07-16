<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar Toggle -->
        <div class="bg-white border-bottom d-md-none">
            <div class="container-fluid">
                <button class="btn btn-link text-dark py-3" id="sidebarToggle">
                    <i class="fas fa-bars me-2"></i> Menu
                </button>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="bg-white border-end sidebar-transition" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom p-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold">Admin Panel</span>
                <button class="btn btn-sm btn-link d-md-none text-dark p-0" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                
                <!-- Projects Dropdown -->
                <div class="list-group-item p-0">
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->routeIs('projects.*') ? 'active' : '' }}" 
                       data-bs-toggle="collapse" href="#projectsSubmenu" role="button">
                        <span><i class="fas fa-project-diagram me-2"></i> Projects</span>
                        <i class="fas fa-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('projects.*') ? 'show' : '' }}" id="projectsSubmenu">
                        <div class="list-group list-group-flush bg-light">
                            <a href="{{ route('projects.index') }}" 
                               class="list-group-item list-group-item-action {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                                <i class="fas fa-list-ul me-2"></i> All Projects
                            </a>
                            <a href="{{ route('projects.create') }}" 
                               class="list-group-item list-group-item-action {{ request()->routeIs('projects.create') ? 'active' : '' }}">
                                <i class="fas fa-plus-circle me-2"></i> Add New Project
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('fun-facts.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('fun-facts.*') ? 'active' : '' }}">
                    <i class="fas fa-lightbulb me-2"></i> Fun Facts
                </a>
            </div>
            <div class="border-top p-3 mt-auto">
                <div class="d-flex align-items-center">
                    <img src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=200&d=mp" 
                         alt="User" class="rounded-circle me-2" width="36" height="36">
                    <div>
                        <div class="fw-bold text-truncate" style="max-width: 150px;">{{ auth()->user()->name }}</div>
                        <a href="{{ route('profile.edit') }}" class="text-decoration-none small text-muted">
                            View profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <!-- Top navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom d-none d-md-block">
                <div class="container-fluid">
                    <button class="btn btn-link text-dark" id="sidebarToggleDesktop">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h5 mb-0">@yield('title')</h1>
                </div>
            </nav>

            <!-- Page content -->
            <div class="container-fluid p-3 p-md-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom Admin JS -->
    <script src="{{ asset('js/admin.js') }}"></script>
    
    <script>
        // Toggle sidebar on mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarToggleDesktop = document.getElementById('sidebarToggleDesktop');
        const closeSidebar = document.getElementById('closeSidebar');
        const wrapper = document.getElementById('wrapper');
        const sidebar = document.getElementById('sidebar-wrapper');
        
        // Mobile toggle
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.style.marginLeft = '0';
                sidebar.style.boxShadow = '0 0 15px rgba(0,0,0,0.1)';
            });
        }
        
        // Desktop toggle
        if (sidebarToggleDesktop) {
            sidebarToggleDesktop.addEventListener('click', function() {
                wrapper.classList.toggle('toggled');
            });
        }
        
        // Close sidebar on mobile
        if (closeSidebar) {
            closeSidebar.addEventListener('click', function() {
                sidebar.style.marginLeft = '-15rem';
                sidebar.style.boxShadow = 'none';
            });
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const isClickInsideSidebar = sidebar.contains(e.target);
            const isClickOnToggle = (sidebarToggle && sidebarToggle.contains(e.target));
            
            if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 768) {
                sidebar.style.marginLeft = '-15rem';
                sidebar.style.boxShadow = 'none';
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                wrapper.classList.remove('toggled');
                sidebar.style.marginLeft = '0';
                sidebar.style.boxShadow = 'none';
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
