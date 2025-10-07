<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="$currentCategory ? $currentCategory->name : 'Berita'"
        :subtitle="$currentCategory ? ($currentCategory->description ?? 'Kumpulan berita ' . $currentCategory->name) : 'Kumpulan berita dan artikel terkini Kejaksaan Tinggi Kalimantan Utara'"
        :badge="'Informasi'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita', 'url' => route('berita.index')],
            ['label' => $currentCategory ? $currentCategory->name : null, 'url' => null]
        ]"
    />

    {{-- Content Section --}}
    <div class="px-4 py-5">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8 mb-4 mb-lg-0">
                {{-- Featured Post (Only on main page) --}}
                @if($featuredPost && !$categorySlug && !$tag && !$search)
                    <div class="card border-0 shadow-lg rounded mb-5 overflow-hidden">
                        @if($featuredPost->hasFeaturedImage())
                            <div class="position-relative" style="height: 400px; overflow: hidden;">
                                <img src="{{ $featuredPost->getFeaturedImageUrl('large') }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;"
                                     alt="{{ $featuredPost->title }}">
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-star me-1"></i> Featured
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="card-body p-4">
                            @if($featuredPost->category)
                                <a href="{{ route('berita.category', $featuredPost->category->slug) }}"
                                   class="badge bg-secondary text-decoration-none">
                                    {{ $featuredPost->category->name }}
                                </a>
                            @endif
                            <h2 class="mt-3 mb-3">
                                <a href="{{ route('berita.show', $featuredPost->slug) }}"
                                   class="text-dark text-decoration-none">
                                    {{ $featuredPost->title }}
                                </a>
                            </h2>
                            <p class="text-muted mb-3">{{ $featuredPost->content_overview }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="far fa-calendar me-2"></i>
                                    <span>{{ $featuredPost->published_at->format('d F Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="far fa-clock me-2"></i>
                                    <span>{{ $featuredPost->reading_time }} menit baca</span>
                                    <span class="mx-2">•</span>
                                    <i class="far fa-eye me-2"></i>
                                    <span>{{ number_format($featuredPost->view_count) }} views</span>
                                </div>
                                <a href="{{ route('berita.show', $featuredPost->slug) }}"
                                   class="btn btn-danger">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Search and Filter --}}
                <div class="card border-0 shadow-sm rounded mb-4">
                    <div class="card-body">
                        <div class="row align-items-center g-3">
                            {{-- Search Input --}}
                            <div class="col-12 col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control border-start-0 ps-0"
                                        placeholder="Cari berita..."
                                        wire:model.live.debounce.500ms="search"
                                    >
                                </div>
                            </div>

                            {{-- Sort Dropdown --}}
                            <div class="col-12 col-md-4">
                                <select class="form-select" wire:model.live="sortBy">
                                    <option value="terbaru">Terbaru</option>
                                    <option value="terlama">Terlama</option>
                                    <option value="popular">Terpopuler</option>
                                </select>
                            </div>
                        </div>

                        {{-- Active Filters --}}
                        @if($search || $categorySlug || $tag)
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="text-muted small">Filter aktif:</span>
                                    @if($search)
                                        <span class="badge bg-light text-dark">
                                            Pencarian: "{{ $search }}"
                                            <button wire:click="$set('search', '')" class="btn-close btn-close-sm ms-1" style="font-size: 0.6rem;"></button>
                                        </span>
                                    @endif
                                    @if($categorySlug)
                                        <span class="badge bg-light text-dark">
                                            Kategori: {{ $currentCategory->name }}
                                            <button wire:click="$set('categorySlug', null)" class="btn-close btn-close-sm ms-1" style="font-size: 0.6rem;"></button>
                                        </span>
                                    @endif
                                    @if($tag)
                                        <span class="badge bg-light text-dark">
                                            Tag: {{ $tag }}
                                            <button wire:click="$set('tag', null)" class="btn-close btn-close-sm ms-1" style="font-size: 0.6rem;"></button>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Posts Grid --}}
                @if($posts->count() > 0)
                    <div class="row g-4">
                        @foreach($posts as $post)
                            <div class="col-12 col-md-6">
                                <article class="card border-0 shadow-sm rounded h-100 overflow-hidden post-card">
                                    @if($post->hasFeaturedImage())
                                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                                            <img src="{{ $post->getFeaturedImageUrl('medium') }}"
                                                 class="w-100 h-100"
                                                 style="object-fit: cover;"
                                                 alt="{{ $post->title }}">
                                            @if($post->category)
                                                <div class="position-absolute top-0 start-0 m-2">
                                                    <a href="{{ route('berita.category', $post->category->slug) }}"
                                                       class="badge bg-danger text-decoration-none">
                                                        {{ $post->category->name }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title mb-2">
                                            <a href="{{ route('berita.show', $post->slug) }}"
                                               class="text-dark text-decoration-none stretched-link">
                                                {{ Str::limit($post->title, 70) }}
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted small mb-3 flex-grow-1">
                                            {{ Str::limit($post->content_overview, 100) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center text-muted small">
                                            <div>
                                                <i class="far fa-calendar me-1"></i>
                                                {{ $post->published_at->format('d M Y') }}
                                            </div>
                                            <div>
                                                <i class="far fa-eye me-1"></i>
                                                {{ number_format($post->view_count) }}
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($posts->hasPages())
                        <div class="mt-5">
                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-newspaper fa-4x text-muted opacity-25 mb-3"></i>
                            <h5 class="text-muted">Tidak ada berita ditemukan</h5>
                            @if($search)
                                <p class="text-muted">Coba ubah kata kunci pencarian Anda</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Categories Widget --}}
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h4><i class="fas fa-folder me-2"></i>Kategori</h4>
                    </div>
                    <div class="widget-body">
                        <div class="category-list">
                            <a href="{{ route('berita.index') }}"
                               class="category-item {{ !$categorySlug ? 'active' : '' }}">
                                <span>Semua Berita</span>
                                <span class="category-count">{{ \App\Models\Blog\Post::published()->count() }}</span>
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('berita.category', $cat->slug) }}"
                                   class="category-item {{ $categorySlug === $cat->slug ? 'active' : '' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="category-count">{{ $cat->posts_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Popular Posts Widget --}}
                @if($popularPosts->count() > 0)
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <h4><i class="fas fa-fire me-2"></i>Berita Populer</h4>
                        </div>
                        <div class="widget-body">
                            @foreach($popularPosts as $popular)
                                <a href="{{ route('berita.show', $popular->slug) }}" class="news-item">
                                    @if($popular->hasFeaturedImage())
                                        <div class="news-thumbnail">
                                            <img src="{{ $popular->getFeaturedImageUrl('thumbnail') }}"
                                                 alt="{{ $popular->title }}">
                                        </div>
                                    @endif
                                    <div class="news-content">
                                        <h6 class="news-title">{{ $popular->title }}</h6>
                                        <div class="news-meta">
                                            <i class="far fa-eye"></i> {{ number_format($popular->view_count) }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Tags Widget --}}
                @if($popularTags->count() > 0)
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <h4><i class="fas fa-tags me-2"></i>Tag Populer</h4>
                        </div>
                        <div class="widget-body">
                            <div class="tag-cloud">
                                @foreach($popularTags as $popularTag)
                                    <a href="{{ route('berita.index', ['tag' => $popularTag->name]) }}"
                                       class="tag-item {{ $tag === $popularTag->name ? 'active' : '' }}">
                                        {{ $popularTag->name }} ({{ $popularTag->taggables_count }})
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .post-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .post-card .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            content: "";
        }

        /* Sidebar Widget Styles */
        .sidebar-widget {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 1rem;
            transition: box-shadow 0.3s ease;
        }

        .sidebar-widget:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .widget-header {
            background: linear-gradient(135deg, #05AC69 0%, #048B56 100%);
            padding: 0.75rem 1rem;
            border-bottom: 2px solid #D4AF37;
        }

        .widget-header h4 {
            color: white;
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.025em;
        }

        .widget-body {
            padding: 1rem;
        }

        /* Category List */
        .category-list {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.625rem 0.75rem;
            border-left: 3px solid transparent;
            border-radius: 0.25rem;
            text-decoration: none;
            color: #374151;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .category-item:hover {
            background: rgba(5, 172, 105, 0.08);
            border-left-color: #05AC69;
            padding-left: 1rem;
        }

        .category-item.active {
            background: linear-gradient(90deg, rgba(5, 172, 105, 0.15) 0%, rgba(5, 172, 105, 0.05) 100%);
            border-left-color: #05AC69;
            color: #05AC69;
            font-weight: 600;
        }

        .category-count {
            background: #f3f4f6;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
        }

        .category-item.active .category-count {
            background: #05AC69;
            color: white;
        }

        /* News Item */
        .news-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.625rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .news-item:hover {
            background: rgba(5, 172, 105, 0.05);
            transform: translateX(4px);
        }

        .news-item:last-child {
            margin-bottom: 0;
        }

        .news-thumbnail {
            flex-shrink: 0;
            width: 75px;
            height: 60px;
            border-radius: 0.375rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .news-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .news-item:hover .news-thumbnail img {
            transform: scale(1.1);
        }

        .news-content {
            flex: 1;
            min-width: 0;
        }

        .news-title {
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.35;
            color: #1f2937;
            margin: 0 0 0.25rem 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-meta {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* Tag Cloud */
        .tag-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem;
        }

        .tag-item {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            background: #f3f4f6;
            color: #374151;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.2s ease;
        }

        .tag-item:hover {
            background: rgba(5, 172, 105, 0.1);
            color: #05AC69;
        }

        .tag-item.active {
            background: #05AC69;
            color: white;
        }

        @media (max-width: 991px) {
            .widget-body {
                padding: 0.75rem;
            }

            .sidebar-widget {
                margin-bottom: 0.75rem;
            }
        }
    </style>
    @endpush
</div>
