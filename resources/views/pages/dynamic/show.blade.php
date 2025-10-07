<x-layouts.main :title="$title" :metaDescription="$metaDescription" :metaKeywords="$metaKeywords">
    @push('styles')
    <style>
        .prose {
            color: #333;
            line-height: 1.8;
        }
        .prose h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #1B5E20;
        }
        .prose h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            color: #1B5E20;
        }
        .prose p {
            margin-bottom: 1rem;
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
        }
        .prose a {
            color: #D4AF37;
            text-decoration: none;
        }
        .prose a:hover {
            text-decoration: underline;
            color: #1B5E20;
        }
        .prose blockquote {
            border-left: 4px solid #D4AF37;
            padding-left: 1rem;
            margin-left: 0;
            font-style: italic;
            color: #6b7280;
        }
        .hover-effect {
            transition: transform 0.3s ease;
        }
        .hover-effect:hover {
            transform: scale(1.05);
        }
        .sidebar-menu .nav-link {
            color: #263238;
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .sidebar-menu .nav-link:hover {
            background: rgba(27, 94, 32, 0.06);
            border-left-color: #D4AF37;
        }
        .sidebar-menu .nav-link.active {
            background: rgba(212, 175, 55, 0.1);
            border-left-color: #D4AF37;
            color: #1B5E20;
            font-weight: 600;
        }
    </style>
    @endpush

    <div class="row px-xl-0 py-2 overflow-hidden">
        @livewire('components.header-details', [
            'title' => $page->title,
            'badge' => ucfirst($page->type),
            'image' => $page->header_image_url ?: $page->featured_image_url ?: asset('frontend/img/accounting-1/generic/mask-image-4.png'),
            'headerIcon' => $page->header_icon_url,
            'backgroundClass' => 'bg-primary',
            'titleClass' => 'text-dark text-9 text-lg-12 font-weight-semibold line-height-1 mb-2',
            'badgeClass' => 'badge bg-color-dark-rgba-10 text-light rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-3'
        ])

        <div class="pb-5 pt-lg-5 mt-5">
            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">
                    @if($page->getFirstMediaUrl('featured_image'))
                        <div class="mb-4">
                            <img src="{{ $page->getFirstMediaUrl('featured_image') }}"
                                 alt="{{ $page->title }}"
                                 class="img-fluid border-radius-2 w-100">
                        </div>
                    @endif

                    <div class="prose prose-lg max-w-none">
                        {!! $page->content !!}
                    </div>

                    @if($page->getMedia('gallery')->count() > 0)
                        <div class="mt-5">
                            <h3 class="text-6 font-weight-semibold line-height-1 mb-4">Galeri</h3>
                            <div class="row g-3">
                                @foreach($page->getMedia('gallery') as $media)
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ $media->getUrl() }}" class="d-block" data-lightbox="gallery" data-title="{{ $page->title }}">
                                            <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}"
                                                 alt="{{ $page->title }}"
                                                 class="img-fluid border-radius-2 hover-effect">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4 order-1 order-lg-2 pe-lg-5 mb-4 mb-lg-0">
                    @php
                        // Get parent and siblings
                        $parentPage = $page->parent;
                        if (!$parentPage && $page->children->count() > 0) {
                            // This is a parent page with children
                            $menuItems = $page->children()->active()->ordered()->get();
                            $menuTitle = 'Sub Halaman';
                        } elseif ($parentPage) {
                            // This is a child page, show siblings
                            $menuItems = $parentPage->children()->active()->ordered()->get();
                            $menuTitle = $parentPage->title;
                        } else {
                            // No parent, no children - show pages of same type
                            $menuItems = App\Models\Page::active()->parents()->ofType($page->type)->ordered()->get();
                            $menuTitle = 'Menu ' . ucfirst($page->type);
                        }
                    @endphp

                    @if($menuItems->count() > 0)
                        <div class="bg-grey-100 p-4 border-radius-2 mb-4">
                            <div class="m-3">
                                <h4 class="text-5 font-weight-semibold line-height-1 mb-4">{{ $menuTitle }}</h4>
                                <ul class="nav nav-list nav-list-arrows flex-column mb-0 sidebar-menu">
                                    @foreach($menuItems as $item)
                                        <li class="nav-item">
                                            <a href="{{ $item->url }}"
                                               class="nav-link {{ $item->id === $page->id ? 'active text-dark' : '' }}">
                                                {{ $item->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
