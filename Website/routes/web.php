<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FunFactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [App\Http\Controllers\PortfolioController::class, 'index'])->name('home');

// Contact Form Routes
Route::controller(\App\Http\Controllers\ContactPageController::class)->group(function () {
    Route::get('/contact', 'show')->name('contact');
    Route::post('/contact', 'store')->name('contact.submit');
    Route::get('/thank-you', 'thankYou')->name('contact.thank-you');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');
    
    // About Myself Management
    Route::prefix('about-myself')->name('about-myself.')->group(function () {
        // View About Myself
        Route::get('/', [App\Http\Controllers\SiteContactController::class, 'show'])->name('show');
        
        // Edit About Myself
        Route::middleware('auth')->group(function () {
            Route::get('/edit', [App\Http\Controllers\SiteContactController::class, 'edit'])->name('edit');
            Route::put('/', [App\Http\Controllers\SiteContactController::class, 'update'])->name('update');
            Route::delete('/photo', [App\Http\Controllers\SiteContactController::class, 'destroyPhoto'])->name('photo.destroy');
        });
    });
    
    // Contact Submissions Management
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('/submissions', [App\Http\Controllers\ContactSubmissionController::class, 'index'])
            ->name('submissions.index');
        Route::get('/submissions/{submission}', [App\Http\Controllers\ContactSubmissionController::class, 'show'])
            ->name('submissions.show');
        Route::delete('/submissions/{submission}', [App\Http\Controllers\ContactSubmissionController::class, 'destroy'])
            ->name('submissions.destroy');
        Route::post('/submissions/{submission}/read', [App\Http\Controllers\ContactSubmissionController::class, 'markAsRead'])
            ->name('submissions.read');
        Route::post('/submissions/{submission}/unread', [App\Http\Controllers\ContactSubmissionController::class, 'markAsUnread'])
            ->name('submissions.unread');
    });
    
        // Work Experience Management
    Route::prefix('work-experience')->name('work-experience.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'store'])->name('store');
        Route::get('/{workExperience}', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'show'])->name('show');
        Route::get('/{workExperience}/edit', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'edit'])->name('edit');
        Route::put('/{workExperience}', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'update'])->name('update');
        Route::delete('/{workExperience}', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'destroy'])->name('destroy');
        Route::patch('/{workExperience}/toggle-visibility', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/update-order', [\App\Http\Controllers\Admin\WorkExperienceController::class, 'updateOrder'])->name('update-order');
    });
    
    // Fun Facts Management
    Route::prefix('fun-facts')->name('fun-facts.')->group(function () {
        Route::get('/', [FunFactController::class, 'index'])->name('index');
        Route::post('/', [FunFactController::class, 'store'])->name('store');
        Route::put('/{funFact}', [FunFactController::class, 'update'])->name('update');
        Route::delete('/{funFact}', [FunFactController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-visibility', [FunFactController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/reorder', [FunFactController::class, 'reorder'])->name('reorder');
    });
    
    // Projects Routes
    Route::prefix('projects')->name('projects.')->group(function () {
        // Public view
        Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])->name('index');
        
        // Admin CRUD (protected by auth middleware)
        Route::middleware(['auth'])->group(function () {
            Route::get('/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\ProjectController::class, 'store'])->name('store');
            Route::get('/{project}/edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('edit');
            Route::put('/{project}', [App\Http\Controllers\ProjectController::class, 'update'])->name('update');
            Route::delete('/{project}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('destroy');
        });
        
        // Public show route (must be last to avoid conflicts)
        Route::get('/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('show');
    });
    
    // Skills Management Routes
    Route::prefix('skills')->name('skills.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SkillController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\SkillController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\SkillController::class, 'store'])->name('store');
        Route::get('/{skill}', [App\Http\Controllers\Admin\SkillController::class, 'show'])->name('show');
        Route::get('/{skill}/edit', [App\Http\Controllers\Admin\SkillController::class, 'edit'])->name('edit');
        Route::put('/{skill}', [App\Http\Controllers\Admin\SkillController::class, 'update'])->name('update');
        Route::delete('/{skill}', [App\Http\Controllers\Admin\SkillController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [App\Http\Controllers\Admin\SkillController::class, 'reorder'])->name('reorder');
    });

    // Media Gallery Routes
    Route::resource('media-gallery', \App\Http\Controllers\Admin\MediaGalleryController::class);
    Route::post('media-gallery/reorder', [\App\Http\Controllers\Admin\MediaGalleryController::class, 'reorder'])->name('media-gallery.reorder');

    // Skill Categories Management Routes
    Route::prefix('skill-categories')->name('skill-categories.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SkillCategoryController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\SkillCategoryController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\SkillCategoryController::class, 'store'])->name('store');
        Route::get('/{skillCategory}', [App\Http\Controllers\Admin\SkillCategoryController::class, 'show'])->name('show');
        Route::get('/{skillCategory}/edit', [App\Http\Controllers\Admin\SkillCategoryController::class, 'edit'])->name('edit');
        Route::put('/{skillCategory}', [App\Http\Controllers\Admin\SkillCategoryController::class, 'update'])->name('update');
        Route::delete('/{skillCategory}', [App\Http\Controllers\Admin\SkillCategoryController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [App\Http\Controllers\Admin\SkillCategoryController::class, 'reorder'])->name('reorder');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Project Routes
    Route::resource('projects', ProjectController::class)->except(['show']);
    
    // Public project view (separate from resource to avoid auth middleware)
    Route::get('projects/{project}', [ProjectController::class, 'show'])
         ->name('projects.show');
         
    // Publication Routes
    Route::resource('publications', PublicationController::class);
});

// Public project views (moved to /portfolio/projects for public access)
Route::get('portfolio/projects', [\App\Http\Controllers\PortfolioController::class, 'projects'])
     ->name('projects.public.index');
Route::get('portfolio/projects/{project:slug}', [\App\Http\Controllers\PortfolioController::class, 'showProject'])
     ->name('projects.public.show');

require __DIR__.'/auth.php';
