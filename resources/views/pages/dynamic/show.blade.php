<x-layouts.main :title="$title" :metaDescription="$metaDescription" :metaKeywords="$metaKeywords">
    @push('styles')
    <style>
        .prose {
            color: #374151;
            line-height: 1.7;
            font-size: 1rem;
        }
        .prose h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            color: #05AC69;
            line-height: 1.3;
        }
        .prose h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1.25rem;
            margin-bottom: 0.625rem;
            color: #05AC69;
            line-height: 1.3;
        }
        .prose h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            color: #05AC69;
            line-height: 1.4;
        }
        .prose h4 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-top: 0.875rem;
            margin-bottom: 0.375rem;
            color: #05AC69;
        }
        .prose p {
            margin-bottom: 0.875rem;
            text-align: justify;
        }
        .prose ul, .prose ol {
            margin-bottom: 0.875rem;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.375rem;
        }
        .prose a {
            color: #D4AF37;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: all 0.2s ease;
        }
        .prose a:hover {
            border-bottom-color: #D4AF37;
            color: #05AC69;
        }
        .prose blockquote {
            border-left: 4px solid #D4AF37;
            padding: 0.75rem 1rem;
            margin: 1rem 0;
            background: #f9fafb;
            font-style: italic;
            color: #6b7280;
            border-radius: 0 0.375rem 0.375rem 0;
        }
        .prose img {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .prose table {
            width: 100%;
            margin: 1rem 0;
            border-collapse: collapse;
        }
        .prose th,
        .prose td {
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
        }
        .prose th {
            background: #f9fafb;
            font-weight: 600;
            color: #05AC69;
        }

        .page-content-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .featured-image-wrapper {
            position: relative;
            border-radius: 0.75rem;
            overflow: hidden;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .featured-image-wrapper img {
            width: 100%;
            height: auto;
            display: block;
        }

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

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            color: #374151;
            padding: 0.625rem 0.75rem;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            text-decoration: none;
            margin-bottom: 0.125rem;
            border-radius: 0.25rem;
        }

        .sidebar-menu .nav-link:hover {
            background: rgba(212, 175, 55, 0.08);
            border-left-color: #D4AF37;
            padding-left: 1rem;
        }

        .sidebar-menu .nav-link.active {
            background: linear-gradient(90deg, rgba(5, 172, 105, 0.15) 0%, rgba(5, 172, 105, 0.05) 100%);
            border-left-color: #05AC69;
            color: #05AC69;
            font-weight: 600;
        }

        .sidebar-menu .nav-link.active::before {
            content: "›";
            font-size: 1.25rem;
            margin-right: 0.375rem;
            color: #05AC69;
        }

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

        .news-date {
            font-size: 0.75rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .news-date::before {
            content: "📅";
            font-size: 0.7rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 0.75rem;
            margin-top: 1.25rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }

        .gallery-item img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        @media (max-width: 991px) {
            .page-content-card {
                padding: 1rem;
            }

            .prose {
                font-size: 0.95rem;
            }

            .sidebar-widget {
                margin-bottom: 0.75rem;
            }

            .widget-body {
                padding: 0.75rem;
            }
        }
    </style>
    @endpush

    <div class="row px-xl-0 py-2 overflow-hidden">
        @php
            // Build breadcrumbs
            $breadcrumbs = [
                ['label' => 'Beranda', 'url' => url('/')]
            ];

            if ($page->navigation) {
                $breadcrumbs[] = ['label' => $page->navigation->label, 'url' => '#'];
            } elseif ($page->parent) {
                $breadcrumbs[] = ['label' => $page->parent->title, 'url' => $page->parent->url];
            }

            $breadcrumbs[] = ['label' => $page->title, 'url' => null];
        @endphp

        @livewire('components.header-details', [
            'title' => $page->title,
            'badge' => ucfirst($page->type),
            'image' => $page->header_image_url ?: $page->featured_image_url ?: asset('frontend/img/accounting-1/generic/mask-image-4.png'),
            'headerIcon' => $page->header_icon_url,
            'backgroundClass' => 'bg-primary',
            'titleClass' => 'text-dark text-9 text-lg-12 font-weight-semibold line-height-1 mb-2',
            'badgeClass' => 'badge bg-color-dark-rgba-10 text-light rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-3',
            'breadcrumbs' => $breadcrumbs
        ])

        <div class="px-4 pb-5 pt-lg-5 mt-5">

            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">
                    <div class="page-content-card">
                        @if($page->getFirstMediaUrl('featured_image'))
                            <div class="featured-image-wrapper">
                                <img src="{{ $page->getFirstMediaUrl('featured_image') }}"
                                     alt="{{ $page->title }}"
                                     class="img-fluid w-100">
                            </div>
                        @endif

                        <div class="prose max-w-none">
                            {!! $page->content !!}
                        </div>

                        @if($page->getMedia('gallery')->count() > 0)
                            <div class="mt-5 pt-4 border-top">
                                <h3 class="text-6 font-weight-bold line-height-1 mb-4 text-primary">
                                    <i class="fas fa-images me-2"></i>Galeri
                                </h3>
                                <div class="gallery-grid">
                                    @foreach($page->getMedia('gallery') as $media)
                                        <a href="{{ $media->getUrl() }}" class="gallery-item" data-lightbox="gallery" data-title="{{ $page->title }}">
                                            <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}"
                                                 alt="{{ $page->title }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 order-1 order-lg-2 mb-4 mb-lg-0">
                    @php
                        // Priority 1: Pages from the same navigation parent
                        if ($page->navigation_id) {
                            $menuItems = App\Models\Page::active()
                                ->where('navigation_id', $page->navigation_id)
                                ->ordered()
                                ->get();
                            $menuTitle = $page->navigation->label;
                        }
                        // Priority 2: Pages from the same parent page
                        elseif ($page->parent_id) {
                            $parentPage = $page->parent;
                            $menuItems = $parentPage->children()->active()->ordered()->get();
                            $menuTitle = $parentPage->title;
                        }
                        // Priority 3: If this is a parent page with children
                        elseif ($page->children->count() > 0) {
                            $menuItems = $page->children()->active()->ordered()->get();
                            $menuTitle = 'Sub Halaman';
                        }
                        // Priority 4: No related pages
                        else {
                            $menuItems = collect();
                            $menuTitle = '';
                        }
                    @endphp

                    @if($menuItems->count() > 0)
                        <div class="sidebar-widget">
                            <div class="widget-header">
                                <h4>{{ $menuTitle }}</h4>
                            </div>
                            <div class="widget-body">
                                <ul class="sidebar-menu">
                                    @foreach($menuItems as $item)
                                        <li class="nav-item">
                                            <a href="{{ $item->url }}"
                                               class="nav-link {{ $item->id === $page->id ? 'active' : '' }}">
                                                {{ $item->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Latest News Widget --}}
                    @php
                        $latestNews = App\Models\Blog\Post::published()
                            ->latest('published_at')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($latestNews->count() > 0)
                        <div class="sidebar-widget">
                            <div class="widget-header">
                                <h4>Berita Terbaru</h4>
                            </div>
                            <div class="widget-body">
                                @foreach($latestNews as $news)
                                    <a href="{{ route('berita.show', $news->slug) }}" class="news-item">
                                        @if($news->hasFeaturedImage())
                                            <div class="news-thumbnail">
                                                <img src="{{ $news->getFeaturedImageUrl('thumbnail') }}"
                                                     alt="{{ $news->title }}">
                                            </div>
                                        @endif
                                        <div class="news-content">
                                            <h6 class="news-title">{{ $news->title }}</h6>
                                            <div class="news-date">{{ $news->published_at->format('d M Y') }}</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '#!') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Configure lightbox
        if (typeof lightbox !== 'undefined') {
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'albumLabel': 'Gambar %1 dari %2',
                'fadeDuration': 300,
                'imageFadeDuration': 300
            });
        }

        // Add copy code button to code blocks
        document.querySelectorAll('pre code').forEach((block) => {
            const button = document.createElement('button');
            button.className = 'btn btn-sm btn-outline-secondary copy-code-btn';
            button.textContent = 'Salin';
            button.style.cssText = 'position: absolute; top: 5px; right: 5px; font-size: 0.75rem;';

            const pre = block.parentElement;
            pre.style.position = 'relative';
            pre.appendChild(button);

            button.addEventListener('click', () => {
                navigator.clipboard.writeText(block.textContent).then(() => {
                    button.textContent = 'Tersalin!';
                    setTimeout(() => {
                        button.textContent = 'Salin';
                    }, 2000);
                });
            });
        });

        // Reading progress indicator
        const createProgressBar = () => {
            const progressBar = document.createElement('div');
            progressBar.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 0%;
                height: 3px;
                background: linear-gradient(90deg, #D4AF37 0%, #05AC69 100%);
                z-index: 9999;
                transition: width 0.1s ease;
            `;
            document.body.appendChild(progressBar);

            window.addEventListener('scroll', () => {
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight - windowHeight;
                const scrolled = window.scrollY;
                const progress = (scrolled / documentHeight) * 100;
                progressBar.style.width = progress + '%';
            });
        };

        // Only show progress bar if content is long enough
        if (document.documentElement.scrollHeight > window.innerHeight * 2) {
            createProgressBar();
        }

        // Add fade-in animation for images
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    imageObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.prose img, .gallery-item').forEach(img => {
            img.style.opacity = '0';
            img.style.transform = 'translateY(20px)';
            img.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            imageObserver.observe(img);
        });
    </script>
    @endpush
</x-layouts.main>
