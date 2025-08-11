<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Blog\Post;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Banner\Content as Banner;

class HomePage extends Component
{
    public $heroTitle = "Professional Accounting Services";
    public $heroSubtitle = "Expert financial solutions to drive your business forward with confidence and precision.";
    
    // Dynamic properties loaded from database
    public $heroBanner;
    public $services;
    public $latestPosts;
    public $featuredPosts;
    public $popularPosts;

    public $stats = [
        ['number' => '500+', 'label' => 'Happy Clients'],
        ['number' => '15+', 'label' => 'Years Experience'],
        ['number' => '98%', 'label' => 'Success Rate'],
        ['number' => '24/7', 'label' => 'Support']
    ];

    public function mount()
    {
        $this->loadHeroBanner();
        $this->loadServices();
        $this->loadLatestPosts();
        $this->loadFeaturedPosts();
        $this->loadPopularPosts();
    }

    private function loadHeroBanner()
    {
        // Load hero banner from banner_contents table
        $this->heroBanner = Banner::with('category')
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('slug', 'hero-banner')
                      ->where('is_active', true);
            })
            ->where(function ($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort')
            ->first();

        // Fallback to default values if no banner found
        if ($this->heroBanner) {
            $this->heroTitle = $this->heroBanner->title ?? $this->heroTitle;
            $this->heroSubtitle = $this->heroBanner->description ?? $this->heroSubtitle;
        }
    }

    private function loadServices()
    {
        // Load services from banner_contents with category slug = 'layanan'
        $this->services = Banner::with(['category', 'media'])
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('slug', 'layanan')
                      ->where('is_active', true);
            })
            ->where(function ($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort')
            ->get()
            ->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'description' => $banner->description,
                    'click_url' => $banner->click_url,
                    'click_url_target' => $banner->click_url_target ?? '_self',
                    'image' => $banner->getFirstMediaUrl() ?: null,
                    'image_thumb' => $banner->getFirstMediaUrl('thumb') ?: null,
                    'sort' => $banner->sort,
                    'impression_count' => $banner->impression_count,
                    'click_count' => $banner->click_count,
                ];
            })
            ->toArray();
    }

    private function loadLatestPosts()
    {
        // Load latest published blog posts
        $this->latestPosts = Post::with(['category', 'author', 'media'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content_overview' => $post->content_overview,
                    'published_at' => $post->published_at,
                    'reading_time' => $post->reading_time,
                    'view_count' => $post->view_count,
                    'category' => $post->category ? [
                        'name' => $post->category->name,
                        'slug' => $post->category->slug
                    ] : null,
                    'author' => $post->author ? [
                        'name' => $post->author->name ?? trim(($post->author->firstname ?? '') . ' ' . ($post->author->lastname ?? ''))
                    ] : null,
                    'featured_image' => $post->getFirstMediaUrl() ?: null,
                    'featured_image_thumb' => $post->getFirstMediaUrl('thumb') ?: null,
                ];
            })
            ->toArray();
    }
    private function loadPopularPosts()
    {
        // Load latest published blog posts
        $this->PopularPosts = Post::with(['category', 'author', 'media'])
            ->where('status', 'published')
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content_overview' => $post->content_overview,
                    'published_at' => $post->published_at,
                    'reading_time' => $post->reading_time,
                    'view_count' => $post->view_count,
                    'category' => $post->category ? [
                        'name' => $post->category->name,
                        'slug' => $post->category->slug
                    ] : null,
                    'author' => $post->author ? [
                        'name' => $post->author->name ?? trim(($post->author->firstname ?? '') . ' ' . ($post->author->lastname ?? ''))
                    ] : null,
                    'featured_image' => $post->getFirstMediaUrl() ?: null,
                    'featured_image_thumb' => $post->getFirstMediaUrl('thumb') ?: null,
                ];
            })
            ->toArray();
    }

    private function loadFeaturedPosts()
    {
        // Load featured blog posts
        $this->featuredPosts = Post::with(['category', 'author', 'media'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content_overview' => $post->content_overview,
                    'published_at' => $post->published_at,
                    'reading_time' => $post->reading_time,
                    'view_count' => $post->view_count,
                    'category' => $post->category ? [
                        'name' => $post->category->name,
                        'slug' => $post->category->slug
                    ] : null,
                    'author' => $post->author ? [
                        'name' => $post->author->name ?? trim(($post->author->firstname ?? '') . ' ' . ($post->author->lastname ?? ''))
                    ] : null,
                    'featured_image' => $post->getFirstMediaUrl() ?: null,
                    'featured_image_thumb' => $post->getFirstMediaUrl('thumb') ?: null,
                ];
            })
            ->toArray();
    }

    // Method to track banner clicks
    public function trackBannerClick($bannerId)
    {
        $banner = Banner::find($bannerId);
        if ($banner) {
            $banner->increment('click_count');
            
            // Redirect to the banner's click_url
            if ($banner->click_url) {
                if ($banner->click_url_target === '_blank') {
                    $this->js("window.open('{$banner->click_url}', '_blank')");
                } else {
                    return redirect($banner->click_url);
                }
            }
        }
    }

    public function render()
    {   
        return view('livewire.pages.home-page')
            ->layout('layouts.main', [
                'title' => 'Home - Professional Accounting Services',
                'metaDescription' => 'Professional accounting services to help your business grow. Expert financial solutions, tax planning, and business advisory services.',
                'metaKeywords' => 'accounting, tax planning, business advisory, payroll, financial services'
            ]);
    }
}