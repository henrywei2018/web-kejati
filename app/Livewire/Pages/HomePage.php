<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Blog\Post;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Banner\Content as Banner;
use Illuminate\Support\Collection;

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
        // Initialize as empty collection if no services found
        $this->services = collect([]);
        
        // Load services from banner_contents table
        $servicesData = Banner::with('category')
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where(function ($q) {
                    $q->where('slug', 'like', '%service%')
                      ->orWhere('slug', 'like', '%layanan%')
                      ->orWhere('name', 'like', '%service%')
                      ->orWhere('name', 'like', '%layanan%');
                })
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
            ->get();

        $this->services = $servicesData;
    }

    private function loadLatestPosts()
    {
        // Initialize as empty collection to prevent null errors
        $this->latestPosts = collect([]);
        
        try {
            $posts = Post::with(['category', 'author', 'media'])
                ->where('is_published', true)
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->take(10)
                ->get();

            $this->latestPosts = $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content_overview' => $post->content_overview ?? '',
                    'published_at' => $post->published_at,
                    'view_count' => $post->view_count ?? 0,
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
            });
        } catch (\Exception $e) {
            // Log the error and ensure we have a collection
            logger()->error('Error loading latest posts: ' . $e->getMessage());
            $this->latestPosts = collect([]);
        }
    }

    private function loadFeaturedPosts()
    {
        // Initialize as empty collection to prevent null errors
        $this->featuredPosts = collect([]);
        
        try {
            $posts = Post::with(['category', 'author', 'media'])
                ->where('is_published', true)
                ->where('published_at', '<=', now())
                ->where('is_featured', true) // Assuming you have this column
                ->orderBy('published_at', 'desc')
                ->take(5)
                ->get();

            $this->featuredPosts = $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content_overview' => $post->content_overview ?? '',
                    'published_at' => $post->published_at,
                    'view_count' => $post->view_count ?? 0,
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
            });
        } catch (\Exception $e) {
            // Log the error and ensure we have a collection
            logger()->error('Error loading featured posts: ' . $e->getMessage());
            $this->featuredPosts = collect([]);
        }
    }

    private function loadPopularPosts()
    {
        // Initialize as empty collection to prevent null errors
        $this->popularPosts = collect([]);
        
        try {
            $posts = Post::with(['category', 'author', 'media'])
                ->where('is_published', true)
                ->where('published_at', '<=', now())
                ->orderBy('view_count', 'desc')
                ->take(10)
                ->get();

            $this->popularPosts = $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content_overview' => $post->content_overview ?? '',
                    'published_at' => $post->published_at,
                    'view_count' => $post->view_count ?? 0,
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
            });
        } catch (\Exception $e) {
            // Log the error and ensure we have a collection
            logger()->error('Error loading popular posts: ' . $e->getMessage());
            $this->popularPosts = collect([]);
        }
    }

    // Method to get latest articles for JavaScript
    public function getLatestArticles()
    {
        return $this->latestPosts->map(function ($post) {
            return [
                'id' => $post['id'],
                'title' => $post['title'],
                'slug' => $post['slug'],
                'image_url' => $post['featured_image'] ?? asset('images/default-post.jpg'),
                'category' => $post['category']['name'] ?? 'Uncategorized',
                'published_at' => $post['published_at']->toISOString(),
                'view_count' => $post['view_count']
            ];
        })->toArray();
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