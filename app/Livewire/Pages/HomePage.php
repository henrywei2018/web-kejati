<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Blog\Post;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Banner\Content as Banner;
use TomatoPHP\FilamentMediaManager\Models\Folder;
use TomatoPHP\FilamentMediaManager\Models\Media;
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
    
    // TomatoPHP Collections - corrected naming
    public $latestInfografis;  // from 'infografis' collection
    public $publikasi;         // from 'laporan-tahunan' collection  
    public $pengumuman;         // from 'pengumuman' collection

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

        if ($this->heroBanner) {
            $this->heroTitle = $this->heroBanner->title ?? $this->heroTitle;
            $this->heroSubtitle = $this->heroBanner->description ?? $this->heroSubtitle;
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
            logger()->error('Error loading latest posts: ' . $e->getMessage());
            $this->latestPosts = collect([]);
        }
    }

    private function loadFeaturedPosts()
    {
        $this->featuredPosts = collect([]);
        
        try {
            $posts = Post::with(['category', 'author', 'media'])
                ->where('is_published', true)
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
                    'featured_image' => $post->getFirstMediaUrl() ?: null,
                    'featured_image_thumb' => $post->getFirstMediaUrl('thumb') ?: null,
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
            logger()->error('Error loading popular posts: ' . $e->getMessage());
            $this->popularPosts = collect([]);
        }
    }

    /**
     * Load Infografis from TomatoPHP 'infografis' collection
     */
    private function loadLatestInfografis()
    {
        $this->latestInfografis = collect([]);
        
        try {
            // Get the infografis folder by collection name
            $infografisFolder = Folder::where('collection', 'infografis')
                ->where('is_hidden', false)
                ->first();

            if ($infografisFolder) {
                // Get media files from the infografis collection
                $mediaFiles = Media::where('folder_id', $infografisFolder->id)
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();

                $this->latestInfografis = $mediaFiles->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'title' => $media->name ?? 'Untitled Infographic',
                        'judul' => $media->alt ?? $media->name ?? 'Untitled Infographic',
                        'slug' => $this->generateSlug($media),
                        'description' => $media->description ?? '',
                        'created_at' => $media->created_at,
                        'file_url' => $media->getUrl(),
                        'thumb_url' => $this->getMediaThumb($media),
                        'mime_type' => $media->mime_type,
                        'size' => $media->size,
                        'is_image' => str_starts_with($media->mime_type, 'image/'),
                    ];
                });
            }
        } catch (\Exception $e) {
            logger()->error('Error loading infografis: ' . $e->getMessage());
            $this->latestInfografis = collect([]);
        }
    }

    /**
     * Load Publikasi from TomatoPHP 'laporan-tahunan' collection
     */
    private function loadPublikasi()
    {
        $this->publikasi = collect([]);
        
        try {
            // Get the laporan-tahunan folder by collection name
            $publikasiFolder = Folder::where('collection', 'laporan-tahunan')
                ->where('is_hidden', false)
                ->first();

            if ($publikasiFolder) {
                // Get media files from the laporan-tahunan collection
                $mediaFiles = Media::where('folder_id', $publikasiFolder->id)
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();

                $this->publikasi = $mediaFiles->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'title' => $media->name ?? 'Untitled Publication',
                        'judul' => $media->alt ?? $media->name ?? 'Untitled Publication',
                        'slug' => $this->generateSlug($media),
                        'description' => $media->description ?? '',
                        'publication_date' => $media->created_at->format('F Y'),
                        'created_at' => $media->created_at,
                        'file_url' => $media->getUrl(),
                        'mime_type' => $media->mime_type,
                        'size' => $media->size,
                        'is_pdf' => $media->mime_type === 'application/pdf',
                    ];
                });
            }
        } catch (\Exception $e) {
            logger()->error('Error loading publikasi: ' . $e->getMessage());
            $this->publikasi = collect([]);
        }
    }

    /**
     * Load Daftar Informasi Publik from TomatoPHP 'pengumuman' collection
     */
    private function loadPengumuman()
    {
        $this->pengumuman = collect([]);
        
        try {
            // Get the pengumuman folder by collection name
            $pengumumanFolder = Folder::where('collection', 'pengumuman')
                ->where('is_hidden', false)
                ->first();

            if ($pengumumanFolder) {
                // Get media files from the pengumuman collection
                $mediaFiles = Media::where('folder_id', $pengumumanFolder->id)
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();

                $this->pengumuman = $mediaFiles->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'title' => $media->name ?? 'Untitled Document',
                        'judul' => $media->alt ?? $media->name ?? 'Untitled Document',
                        'slug' => $this->generateSlug($media),
                        'description' => $media->description ?? '',
                        'publication_date' => $media->created_at->format('F Y'),
                        'created_at' => $media->created_at,
                        'file_url' => $media->getUrl(),
                        'mime_type' => $media->mime_type,
                        'size' => $media->size,
                        'is_pdf' => $media->mime_type === 'application/pdf',
                    ];
                });
            }
        } catch (\Exception $e) {
            logger()->error('Error loading daftar DIP: ' . $e->getMessage());
            $this->pengumuman = collect([]);
        }
    }

    /**
     * Helper Methods for TomatoPHP Media
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