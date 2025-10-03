<?php

use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\AboutUs;
use Illuminate\Support\Facades\Route;
use Lab404\Impersonate\Services\ImpersonateManager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomePage::class)->name('home');

// Services Routes
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/', function () {
        return view('pages.services');
    })->name('index');
    
    Route::get('/category/{category:slug}', function ($category) {
        return view('pages.services.category', compact('category'));
    })->name('category');
});

// Blog Routes
Route::prefix('artikel')->name('artikel.')->group(function () {
    Route::get('/', function () {
        return view('pages.blog.index');
    })->name('index');
    
    Route::get('/category/{category:slug}', function ($category) {
        return view('pages.blog.category', compact('category'));
    })->name('category');
    
    Route::get('/{post:slug}', function ($post) {
        // Increment view count
        $post->increment('view_count');
        return view('pages.blog.post', compact('post'));
    })->name('post');
});

// Other Pages
Route::get('/services', function () {
    return view('pages.services');
})->name('services');

Route::get('/blog', function () {
    return view('pages.blog.index');
})->name('blog');

Route::get('/about', AboutUs::class)->name('about');

// Profil Routes
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', function () {
        $profils = \App\Models\Profil::active()->parents()->ordered()->get();
        return view('pages.profil.index', compact('profils'));
    })->name('index');

    // Parent profil route: /profil/{parent_slug}
    Route::get('/{parent_slug}', function ($parent_slug) {
        $profil = \App\Models\Profil::where('slug', $parent_slug)
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->firstOrFail();

        $metaDescription = $profil->meta['meta_description'] ??
            strip_tags(substr($profil->content, 0, 160));

        $metaKeywords = $profil->meta['meta_keywords'] ?? $profil->title;

        return view('pages.profil.show-wrapper', [
            'profil' => $profil,
            'title' => $profil->title,
            'metaDescription' => $metaDescription,
            'metaKeywords' => $metaKeywords,
        ]);
    })->name('show');

    // Child profil route: /profil/{parent_slug}/{child_slug}
    Route::get('/{parent_slug}/{child_slug}', function ($parent_slug, $child_slug) {
        // Find parent first
        $parent = \App\Models\Profil::where('slug', $parent_slug)
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->firstOrFail();

        // Find child under this parent
        $profil = \App\Models\Profil::where('slug', $child_slug)
            ->where('is_active', true)
            ->where('parent_id', $parent->id)
            ->firstOrFail();

        $metaDescription = $profil->meta['meta_description'] ??
            strip_tags(substr($profil->content, 0, 160));

        $metaKeywords = $profil->meta['meta_keywords'] ?? $profil->title;

        return view('pages.profil.show-wrapper', [
            'profil' => $profil,
            'title' => $profil->title,
            'metaDescription' => $metaDescription,
            'metaKeywords' => $metaKeywords,
        ]);
    })->name('show.child');
});

Route::get('/process', function () {
    return view('pages.process');
})->name('process');

Route::get('/projects', function () {
    return view('pages.projects');
})->name('projects');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Dynamic Page Routes - Must be LAST to act as catch-all
// Parent page route: /{parent_slug}
Route::get('/{parent_slug}', function ($parent_slug) {
    $page = \App\Models\Page::where('slug', $parent_slug)
        ->where('is_active', true)
        ->whereNull('parent_id')
        ->firstOrFail();

    $metaDescription = $page->meta['meta_description'] ??
        strip_tags(substr($page->content, 0, 160));

    $metaKeywords = $page->meta['meta_keywords'] ?? $page->title;

    return view('pages.dynamic.show', [
        'page' => $page,
        'title' => $page->title,
        'metaDescription' => $metaDescription,
        'metaKeywords' => $metaKeywords,
    ]);
})->name('page.show');

// Child page route: /{parent_slug}/{child_slug}
Route::get('/{parent_slug}/{child_slug}', function ($parent_slug, $child_slug) {
    // Find parent first
    $parent = \App\Models\Page::where('slug', $parent_slug)
        ->where('is_active', true)
        ->whereNull('parent_id')
        ->firstOrFail();

    // Find child under this parent
    $page = \App\Models\Page::where('slug', $child_slug)
        ->where('is_active', true)
        ->where('parent_id', $parent->id)
        ->firstOrFail();

    $metaDescription = $page->meta['meta_description'] ??
        strip_tags(substr($page->content, 0, 160));

    $metaKeywords = $page->meta['meta_keywords'] ?? $page->title;

    return view('pages.dynamic.show', [
        'page' => $page,
        'title' => $page->title,
        'metaDescription' => $metaDescription,
        'metaKeywords' => $metaKeywords,
    ]);
})->name('page.show.child');

Route::get('impersonate/leave', function() {
    if(!app(ImpersonateManager::class)->isImpersonating()) {
        return redirect('/');
    }

    app(ImpersonateManager::class)->leave();

    return redirect(
        session()->pull('impersonate.back_to')
    );
})->name('impersonate.leave')->middleware('web');

