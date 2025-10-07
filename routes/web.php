<?php

use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\AboutUs;
use App\Livewire\Pages\GalleryPage;
use App\Livewire\Pages\PengumumanPage;
use App\Livewire\Pages\InfografisPage;
use App\Livewire\Pages\VideoGalleryPage;
use App\Livewire\Pages\ImageGalleryPage;
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

Route::get('/process', function () {
    return view('pages.process');
})->name('process');

Route::get('/projects', function () {
    return view('pages.projects');
})->name('projects');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Gallery Routes - Must be BEFORE dynamic pages
Route::get('/galeri', GalleryPage::class)->name('gallery');
Route::get('/galeri/video', VideoGalleryPage::class)->name('gallery.video');
Route::get('/galeri/gambar', ImageGalleryPage::class)->name('gallery.image');

// Information Routes - Must be BEFORE dynamic pages
Route::get('/informasi/pengumuman', PengumumanPage::class)->name('informasi.pengumuman');
Route::get('/informasi/infografis', InfografisPage::class)->name('informasi.infografis');

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

