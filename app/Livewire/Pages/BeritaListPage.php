<?php

namespace App\Livewire\Pages;

use App\Models\Blog\Post;
use App\Models\Blog\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class BeritaListPage extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $categorySlug = null;
    public ?string $tag = null;
    public string $sortBy = 'terbaru'; // terbaru, terlama, popular

    protected $queryString = ['search', 'categorySlug' => ['as' => 'kategori'], 'tag', 'sortBy'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategorySlug()
    {
        $this->resetPage();
    }

    public function updatingTag()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function mount(?string $categorySlug = null)
    {
        $this->categorySlug = $categorySlug;
    }

    public function render()
    {
        // Get posts query
        $query = Post::with(['author', 'category', 'tags'])
            ->published();

        // Filter by category
        if ($this->categorySlug) {
            $category = Category::where('slug', $this->categorySlug)
                ->active()
                ->firstOrFail();

            $query->where('blog_category_id', $category->id);
        } else {
            $category = null;
        }

        // Filter by tag
        if ($this->tag) {
            $query->withAnyTags([$this->tag]);
        }

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content_overview', 'like', '%' . $this->search . '%')
                    ->orWhere('content_raw', 'like', '%' . $this->search . '%');
            });
        }

        // Sorting
        $query = match($this->sortBy) {
            'terlama' => $query->orderBy('published_at', 'asc'),
            'popular' => $query->orderBy('view_count', 'desc')->orderBy('published_at', 'desc'),
            default => $query->orderBy('published_at', 'desc'), // terbaru
        };

        // Paginate
        $posts = $query->paginate(12);

        // Get featured post (for hero section) — cached 5 min
        $featuredPost = Cache::remember('berita_featured_post', 300, function () {
            return Post::published()
                ->featured()
                ->orderBy('published_at', 'desc')
                ->first();
        });

        // Get all categories for sidebar — cached 10 min
        $categories = Cache::remember('berita_sidebar_categories', 600, function () {
            return Category::active()
                ->withCount(['posts' => function ($q) {
                    $q->published();
                }])
                ->orderBy('name')
                ->get();
        });

        // Get popular posts for sidebar — cached 10 min
        $popularPosts = Cache::remember('berita_sidebar_popular_posts', 600, function () {
            return Post::published()
                ->orderBy('view_count', 'desc')
                ->limit(5)
                ->get();
        });

        // Get popular tags — cached 10 min, uses efficient DB aggregation instead of loading all posts
        $popularTags = Cache::remember('berita_popular_tags', 600, function () {
            return \Spatie\Tags\Tag::query()
                ->join('taggables', 'tags.id', '=', 'taggables.tag_id')
                ->join('blog_posts', function ($join) {
                    $join->on('taggables.taggable_id', '=', 'blog_posts.id')
                         ->where('taggables.taggable_type', Post::class);
                })
                ->where('blog_posts.status', 'published')
                ->where('blog_posts.published_at', '<=', now())
                ->selectRaw('tags.*, COUNT(taggables.tag_id) as taggables_count')
                ->groupBy('tags.id')
                ->orderByDesc('taggables_count')
                ->take(20)
                ->get();
        });

        return view('livewire.pages.berita-list-page', [
            'posts' => $posts,
            'featuredPost' => $featuredPost,
            'categories' => $categories,
            'popularPosts' => $popularPosts,
            'popularTags' => $popularTags,
            'currentCategory' => $category ?? null,
        ])->layout('layouts.main', [
            'title' => $category ? $category->name . ' - Berita' : 'Berita',
            'metaDescription' => $category ? ($category->meta_description ?? $category->description) : 'Kumpulan berita dan artikel terkini Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => 'berita, artikel, kejaksaan tinggi kaltara, news'
        ]);
    }
}
