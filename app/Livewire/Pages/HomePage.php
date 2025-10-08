<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Blog\Post;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Banner\Content as Banner;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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

    // Spatie Media Collections
    public $latestInfografis;  // from 'infografis' collection
    public $publikasi;         // from 'publikasi' collection
    public $pengumuman;         // from 'pengumuman' collection

    // Employees
    public $employees;
    public $kepalaKejaksaan;

    // Services/Layanan
    public $layananServices;

    // Modal state
    public $detailMedia = null;

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
        
        // Load TomatoPHP Collections
        $this->loadLatestInfografis();
        $this->loadPublikasi();
        $this->loadPengumuman();
        $this->loadEmployees();
        $this->loadKepalaKejaksaan();
        $this->loadLayananServices();
    }

    private function loadHeroBanner()
    {
        // Load hero banners from main-hero category
        $this->heroBanner = collect([]);

        try {
            // Find main-hero category
            $mainHeroCategory = \App\Models\Banner\Category::active()
                ->where('slug', 'main-hero')
                ->first();

            if ($mainHeroCategory) {
                // Get all active banner contents from main-hero category
                $banners = Banner::active()
                    ->where('banner_category_id', $mainHeroCategory->id)
                    ->orderBy('sort', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get();

                $this->heroBanner = $banners;
            }
        } catch (\Exception $e) {
            logger()->error('Error loading main-hero banners: ' . $e->getMessage());
            $this->heroBanner = collect([]);
        }
    }

    private function loadServices()
    {
        $this->services = collect([]);
        
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
        $this->latestPosts = collect([]);

        try {
            $posts = Post::with(['category', 'author', 'media'])
                ->where('status', 'published')
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
                    'featured_image' => $post->getFirstMediaUrl('featured') ?: null,
                    'featured_image_thumb' => $post->getFirstMediaUrl('featured', 'thumbnail') ?: null,
                ];
            });
        } catch (\Exception $e) {
            logger()->error('Error loading latest posts: ' . $e->getMessage());
            $this->latestPosts = collect([]);
        }
    }

    private function loadFeaturedPosts()
    {
        $this->featuredPosts = collect([]);

        try {
            $posts = Post::with(['category', 'author', 'media'])
                ->where('status', 'published')
                ->where('published_at', '<=', now())
                ->where('is_featured', true)
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
                    'featured_image' => $post->getFirstMediaUrl('featured') ?: null,
                    'featured_image_thumb' => $post->getFirstMediaUrl('featured', 'thumbnail') ?: null,
                ];
            });
        } catch (\Exception $e) {
            logger()->error('Error loading featured posts: ' . $e->getMessage());
            $this->featuredPosts = collect([]);
        }
    }

    private function loadPopularPosts()
    {
        $this->popularPosts = collect([]);

        try {
            $posts = Post::with(['category', 'author', 'media'])
                ->where('status', 'published')
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
                    'featured_image' => $post->getFirstMediaUrl('featured') ?: null,
                    'featured_image_thumb' => $post->getFirstMediaUrl('featured', 'thumbnail') ?: null,
                ];
            });
        } catch (\Exception $e) {
            logger()->error('Error loading popular posts: ' . $e->getMessage());
            $this->popularPosts = collect([]);
        }
    }

    /**
     * Load Infografis from Spatie Media Library 'infografis' collection
     */
    private function loadLatestInfografis()
    {
        $this->latestInfografis = collect([]);

        try {
            // Get media files from the 'infografis' collection using Spatie Media Library
            $mediaFiles = Media::where('collection_name', 'infografis')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            $this->latestInfografis = $mediaFiles->map(function ($media) {
                return [
                    'id' => $media->id,
                    'title' => $media->getCustomProperty('title') ?? $media->name ?? 'Untitled Infographic',
                    'judul' => $media->getCustomProperty('title') ?? $media->name ?? 'Untitled Infographic',
                    'slug' => $this->generateSlug($media),
                    'description' => $media->getCustomProperty('description') ?? '',
                    'created_at' => $media->created_at,
                    'file_url' => $media->getUrl(),
                    'thumb_url' => $this->getMediaThumb($media),
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'is_image' => str_starts_with($media->mime_type ?? '', 'image/'),
                ];
            });
        } catch (\Exception $e) {
            logger()->error('Error loading infografis: ' . $e->getMessage());
            $this->latestInfografis = collect([]);
        }
    }

    /**
     * Load Publikasi from Spatie Media Library 'laporan-publikasi' collection
     */
    private function loadPublikasi()
    {
        $this->publikasi = collect([]);

        try {
            // Get media files from the 'laporan-publikasi' collection using Spatie Media Library
            $mediaFiles = Media::where('collection_name', 'laporan-publikasi')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            $this->publikasi = $mediaFiles->map(function ($media) {
                return [
                    'id' => $media->id,
                    'title' => $media->getCustomProperty('title') ?? $media->name ?? 'Untitled Publication',
                    'judul' => $media->getCustomProperty('title') ?? $media->name ?? 'Untitled Publication',
                    'slug' => $this->generateSlug($media),
                    'description' => $media->getCustomProperty('description') ?? '',
                    'publication_date' => $media->created_at->format('F Y'),
                    'created_at' => $media->created_at,
                    'file_url' => $media->getUrl(),
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'is_pdf' => $media->mime_type === 'application/pdf',
                ];
            });
        } catch (\Exception $e) {
            logger()->error('Error loading publikasi: ' . $e->getMessage());
            $this->publikasi = collect([]);
        }
    }

    /**
     * Load Pengumuman from Spatie Media Library 'pengumuman' collection
     */
    private function loadPengumuman()
    {
        $this->pengumuman = collect([]);

        try {
            // Get media files from the 'pengumuman' collection using Spatie Media Library
            $mediaFiles = Media::where('collection_name', 'pengumuman')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            $this->pengumuman = $mediaFiles->map(function ($media) {
                return [
                    'id' => $media->id,
                    'title' => $media->getCustomProperty('title') ?? $media->name ?? 'Untitled Document',
                    'judul' => $media->getCustomProperty('title') ?? $media->name ?? 'Untitled Document',
                    'slug' => $this->generateSlug($media),
                    'description' => $media->getCustomProperty('description') ?? '',
                    'publication_date' => $media->created_at->format('F Y'),
                    'created_at' => $media->created_at,
                    'file_url' => $media->getUrl(),
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'is_pdf' => $media->mime_type === 'application/pdf',
                ];
            });
        } catch (\Exception $e) {
            logger()->error('Error loading pengumuman: ' . $e->getMessage());
            $this->pengumuman = collect([]);
        }
    }

    /**
     * Helper Methods for Spatie Media Library
     */
    private function generateSlug($media)
    {
        $name = $media->name ?? $media->file_name ?? 'untitled';
        return \Str::slug($name) . '-' . $media->id;
    }

    private function getMediaThumb($media)
    {
        // Try to get thumbnail, fallback to original
        try {
            return $media->getUrl('thumb') ?? $media->getUrl();
        } catch (\Exception $e) {
            return $media->getUrl();
        }
    }

    public function getMediaUrl($item)
    {
        if (is_array($item)) {
            return $item['file_url'] ?? '#';
        }
        return $item->getUrl() ?? '#';
    }

    public function getMediaThumbUrl($item)
    {
        if (is_array($item)) {
            return $item['thumb_url'] ?? $item['file_url'] ?? asset('images/placeholder.jpg');
        }
        return $this->getMediaThumb($item);
    }

    public function hasPdf($item)
    {
        if (is_array($item)) {
            return $item['is_pdf'] ?? false;
        }
        return $item->mime_type === 'application/pdf';
    }

    public function getPdfUrl($item)
    {
        return $this->getMediaUrl($item);
    }

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

    public function trackBannerClick($bannerId)
    {
        $banner = Banner::find($bannerId);
        if ($banner) {
            $banner->increment('click_count');
            
            if ($banner->click_url) {
                if ($banner->click_url_target === '_blank') {
                    $this->js("window.open('{$banner->click_url}', '_blank')");
                } else {
                    return redirect($banner->click_url);
                }
            }
        }
    }

    public function trackMediaDownload($mediaId)
    {
        try {
            $media = Media::find($mediaId);
            if ($media) {
                logger()->info("Media downloaded: {$media->name} (ID: {$mediaId})");
                // You can add more tracking logic here
            }
        } catch (\Exception $e) {
            logger()->error('Error tracking media download: ' . $e->getMessage());
        }
    }

    /**
     * Show media detail in modal
     */
    public function showMediaDetail($mediaId)
    {
        $this->detailMedia = Media::find($mediaId);
    }

    /**
     * Close media detail modal
     */
    public function closeMediaDetail()
    {
        $this->detailMedia = null;
    }

    /**
     * Format bytes to human readable size
     */
    public function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Load Featured Employees
     */
    private function loadEmployees()
    {
        $this->employees = collect([]);

        try {
            // Get featured/active employees
            $employees = \App\Models\Employee::active()
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();

            $this->employees = $employees;
        } catch (\Exception $e) {
            logger()->error('Error loading employees: ' . $e->getMessage());
            $this->employees = collect([]);
        }
    }

    /**
     * Load Kepala Kejaksaan Tinggi
     */
    private function loadKepalaKejaksaan()
    {
        $this->kepalaKejaksaan = null;

        try {
            // Get employee with department "Kepala Kejaksaan Tinggi"
            $kepala = \App\Models\Employee::active()
                ->where('department', 'Kepala Kejaksaan Tinggi')
                ->first();

            $this->kepalaKejaksaan = $kepala;
        } catch (\Exception $e) {
            logger()->error('Error loading Kepala Kejaksaan: ' . $e->getMessage());
            $this->kepalaKejaksaan = null;
        }
    }

    /**
     * Load Layanan Services from Banner Category
     */
    private function loadLayananServices()
    {
        $this->layananServices = collect([]);

        try {
            // Find Layanan category
            $layananCategory = \App\Models\Banner\Category::active()
                ->where('slug', 'layanan')
                ->first();

            if ($layananCategory) {
                // Get all active banner contents from Layanan category
                $services = \App\Models\Banner\Content::active()
                    ->where('banner_category_id', $layananCategory->id)
                    ->orderBy('sort', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get();

                $this->layananServices = $services;
            }
        } catch (\Exception $e) {
            logger()->error('Error loading Layanan services: ' . $e->getMessage());
            $this->layananServices = collect([]);
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