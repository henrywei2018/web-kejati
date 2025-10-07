<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="$post->title"
        :subtitle="$post->content_overview"
        :badge="'Berita'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita', 'url' => route('berita.index')],
            ['label' => $post->category ? $post->category->name : null, 'url' => $post->category ? route('berita.category', $post->category->slug) : null],
            ['label' => Str::limit($post->title, 50), 'url' => null]
        ]"
    />

    {{-- Content Section --}}
    <div class="container py-5">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8 mb-4 mb-lg-0">
                {{-- Article --}}
                <article class="card border-0 shadow-sm rounded overflow-hidden">
                    {{-- Featured Image --}}
                    @if($post->hasFeaturedImage())
                        <div class="position-relative" style="height: 450px; overflow: hidden;">
                            <img src="{{ $post->getFeaturedImageUrl('large') }}"
                                 class="w-100 h-100"
                                 style="object-fit: cover;"
                                 alt="{{ $post->title }}">
                        </div>
                    @endif

                    <div class="card-body p-4 p-md-5">
                        {{-- Meta Info --}}
                        <div class="mb-4 pb-4 border-bottom">
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                @if($post->category)
                                    <a href="{{ route('berita.category', $post->category->slug) }}"
                                       class="badge bg-danger text-decoration-none py-2 px-3">
                                        {{ $post->category->name }}
                                    </a>
                                @endif
                                <div class="text-muted small">
                                    <i class="far fa-calendar me-1"></i>
                                    {{ $post->published_at->format('d F Y') }}
                                </div>
                                <div class="text-muted small">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $post->reading_time }} menit baca
                                </div>
                                <div class="text-muted small">
                                    <i class="far fa-eye me-1"></i>
                                    {{ number_format($post->view_count) }} views
                                </div>
                                @if($post->author)
                                    <div class="text-muted small">
                                        <i class="far fa-user me-1"></i>
                                        {{ $post->author->name }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Article Title --}}
                        <h1 class="mb-4">{{ $post->title }}</h1>

                        {{-- Article Content --}}
                        <div class="article-content mb-5">
                            {!! $post->content_html !!}
                        </div>

                        {{-- Tags --}}
                        @if($post->tags->count() > 0)
                            <div class="mb-4 pb-4 border-top pt-4">
                                <h6 class="mb-3">
                                    <i class="fas fa-tags text-danger me-2"></i>
                                    Tags:
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($post->tags as $tag)
                                        <a href="{{ route('berita.index', ['tag' => $tag->name]) }}"
                                           class="badge bg-light text-dark text-decoration-none py-2 px-3">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Share Buttons --}}
                        <div class="mb-4 pb-4 border-top pt-4">
                            <h6 class="mb-3">
                                <i class="fas fa-share-alt text-danger me-2"></i>
                                Bagikan:
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ $post->getFacebookShareUrl() }}"
                                   target="_blank"
                                   class="btn btn-primary btn-sm">
                                    <i class="fab fa-facebook-f me-1"></i>
                                    Facebook
                                </a>
                                <a href="{{ $post->getTwitterShareUrl() }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm text-white">
                                    <i class="fab fa-twitter me-1"></i>
                                    Twitter
                                </a>
                                <a href="{{ $post->getWhatsappShareUrl() }}"
                                   target="_blank"
                                   class="btn btn-success btn-sm">
                                    <i class="fab fa-whatsapp me-1"></i>
                                    WhatsApp
                                </a>
                                <a href="{{ $post->getLinkedinShareUrl() }}"
                                   target="_blank"
                                   class="btn btn-primary btn-sm"
                                   style="background: #0077b5; border-color: #0077b5;">
                                    <i class="fab fa-linkedin-in me-1"></i>
                                    LinkedIn
                                </a>
                            </div>
                        </div>

                        {{-- Navigation (Previous/Next Post) --}}
                        <div class="border-top pt-4">
                            <div class="row g-3">
                                @if($previousPost)
                                    <div class="col-md-6">
                                        <a href="{{ route('berita.show', $previousPost->slug) }}"
                                           class="text-decoration-none">
                                            <div class="card border h-100 post-nav-card">
                                                <div class="card-body">
                                                    <small class="text-muted d-block mb-2">
                                                        <i class="fas fa-arrow-left me-1"></i>
                                                        Berita Sebelumnya
                                                    </small>
                                                    <h6 class="mb-0 text-dark">{{ Str::limit($previousPost->title, 60) }}</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                                @if($nextPost)
                                    <div class="col-md-6 {{ !$previousPost ? 'ms-auto' : '' }}">
                                        <a href="{{ route('berita.show', $nextPost->slug) }}"
                                           class="text-decoration-none">
                                            <div class="card border h-100 post-nav-card">
                                                <div class="card-body text-end">
                                                    <small class="text-muted d-block mb-2">
                                                        Berita Selanjutnya
                                                        <i class="fas fa-arrow-right ms-1"></i>
                                                    </small>
                                                    <h6 class="mb-0 text-dark">{{ Str::limit($nextPost->title, 60) }}</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Related Posts --}}
                @if($relatedPosts->count() > 0)
                    <div class="mt-5">
                        <h4 class="mb-4">
                            <i class="fas fa-newspaper text-danger me-2"></i>
                            Berita Terkait
                        </h4>
                        <div class="row g-4">
                            @foreach($relatedPosts as $related)
                                <div class="col-md-4">
                                    <article class="card border-0 shadow-sm rounded h-100 overflow-hidden post-card">
                                        @if($related->hasFeaturedImage())
                                            <div class="position-relative" style="height: 150px; overflow: hidden;">
                                                <img src="{{ $related->getFeaturedImageUrl('medium') }}"
                                                     class="w-100 h-100"
                                                     style="object-fit: cover;"
                                                     alt="{{ $related->title }}">
                                            </div>
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title mb-2">
                                                <a href="{{ route('berita.show', $related->slug) }}"
                                                   class="text-dark text-decoration-none stretched-link">
                                                    {{ Str::limit($related->title, 60) }}
                                                </a>
                                            </h6>
                                            <div class="text-muted small mt-auto">
                                                <i class="far fa-calendar me-1"></i>
                                                {{ $related->published_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Author Info --}}
                @if($post->author)
                    <div class="card border-0 shadow-sm rounded mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-user text-danger me-2"></i>
                                Tentang Penulis
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center me-3"
                                     style="width: 60px; height: 60px; font-size: 1.5rem;">
                                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $post->author->name }}</h6>
                                    @if($post->author->email)
                                        <small class="text-muted">{{ $post->author->email }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Table of Contents (if long article) --}}
                @if($post->reading_time > 5)
                    <div class="card border-0 shadow-sm rounded mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-list text-danger me-2"></i>
                                Daftar Isi
                            </h5>
                            <div id="toc" class="toc-content small">
                                {{-- TOC will be generated via JavaScript --}}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Back to List --}}
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body text-center">
                        <a href="{{ route('berita.index') }}"
                           class="btn btn-outline-danger w-100">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Daftar Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }

        .article-content h2,
        .article-content h3,
        .article-content h4 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .article-content blockquote {
            border-left: 4px solid #dc3545;
            padding-left: 1.5rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #666;
        }

        .article-content ul,
        .article-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .article-content code {
            background: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .article-content pre {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1.5rem 0;
        }

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

        .post-nav-card {
            transition: all 0.3s ease;
        }

        .post-nav-card:hover {
            border-color: #dc3545 !important;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
        }

        .toc-content a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .toc-content a:hover {
            color: #dc3545;
            padding-left: 0.5rem;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Generate Table of Contents from article headings
        document.addEventListener('DOMContentLoaded', function() {
            const articleContent = document.querySelector('.article-content');
            const tocContainer = document.getElementById('toc');

            if (articleContent && tocContainer) {
                const headings = articleContent.querySelectorAll('h2, h3');

                if (headings.length > 0) {
                    const tocList = document.createElement('div');

                    headings.forEach((heading, index) => {
                        // Add ID to heading for anchor links
                        const headingId = `heading-${index}`;
                        heading.id = headingId;

                        // Create TOC link
                        const link = document.createElement('a');
                        link.href = `#${headingId}`;
                        link.textContent = heading.textContent;

                        if (heading.tagName === 'H3') {
                            link.style.paddingLeft = '1rem';
                            link.style.fontSize = '0.9em';
                        }

                        tocList.appendChild(link);
                    });

                    tocContainer.appendChild(tocList);
                } else {
                    tocContainer.parentElement.parentElement.style.display = 'none';
                }
            }
        });
    </script>
    @endpush
</div>
