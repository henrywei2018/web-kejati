<?php

namespace App\Livewire\Pages;

use App\Models\Blog\Post;
use Livewire\Component;

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
        // Get related posts
        $relatedPosts = $this->post->getRelatedPosts(3);

        // Get previous and next posts
        $previousPost = $this->post->getPreviousPost();
        $nextPost = $this->post->getNextPost();

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
