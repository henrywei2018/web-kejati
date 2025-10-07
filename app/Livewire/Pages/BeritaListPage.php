<?php

namespace App\Livewire\Pages;

use App\Models\Blog\Post;
use App\Models\Blog\Category;
use Livewire\Component;
use Livewire\WithPagination;

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

        // Get featured post (for hero section)
        $featuredPost = Post::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->first();

        // Get all categories for sidebar
        $categories = Category::active()
            ->withCount(['posts' => function($q) {
                $q->published();
            }])
            ->orderBy('name')
            ->get();

        // Get popular posts for sidebar
        $popularPosts = Post::published()
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        // Get popular tags from published posts
        $allTags = Post::published()->with('tags')->get()->pluck('tags')->flatten();
        $popularTags = $allTags->groupBy('id')->map(function($tags) {
            $tag = $tags->first();
            $tag->taggables_count = $tags->count();
            return $tag;
        })->sortByDesc('taggables_count')->take(20);

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
