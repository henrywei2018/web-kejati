<?php

namespace App\Livewire\Pages;

use App\Models\Blog\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class BeritaDetailPage extends Component
{
    public Post $post;

    public function mount(string $slug)
    {
        // Get the post by slug
        $this->post = Post::with(['author', 'category', 'tags'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Track view
        $this->post->trackView();
    }

    public function render()
    {
        // Cache keyed by slug so CacheInvalidationService::clearBeritaCaches($slug) can target it precisely
        $slug = $this->post->slug;
        $relatedPosts = Cache::remember("berita_related_{$slug}", 600, fn() => $this->post->getRelatedPosts(3));
        $previousPost = Cache::remember("berita_prev_{$slug}", 600, fn() => $this->post->getPreviousPost());
        $nextPost     = Cache::remember("berita_next_{$slug}", 600, fn() => $this->post->getNextPost());

        return view('livewire.pages.berita-detail-page', [
            'relatedPosts' => $relatedPosts,
            'previousPost' => $previousPost,
            'nextPost' => $nextPost,
        ])->layout('layouts.main', [
            'title' => $this->post->meta_title ?? $this->post->title,
            'metaDescription' => $this->post->meta_description ?? $this->post->content_overview,
            'metaKeywords' => implode(', ', $this->post->tags->pluck('name')->toArray()),
        ]);
    }
}
