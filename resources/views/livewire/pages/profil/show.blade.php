<div class="row px-xl-0 py-2 overflow-hidden">
    @livewire('components.header-details', [
        'title' => $profil->title,
        'badge' => 'Profil',
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Profil', 'url' => route('profil.index')],
            ['label' => $profil->title]
        ],
        'image' => asset('frontend/img/waves-2.svg'),
        'backgroundClass' => 'bg-primary',
        'titleClass' => 'text-secondary text-9 text-lg-12 font-weight-bold line-height-1 mb-2',
        'badgeClass' => 'badge bg-quaternary text-light rounded-pill text-uppercase font-weight-bold text-2-5 px-4 py-2 mb-3'
    ])

    <div class="container pb-5 pt-lg-5 mt-5">
        <div class="row">
            <div class="col-lg-8 order-2 order-lg-1">
                @if($profil->getFirstMediaUrl('featured_image'))
                    <div class="mb-4">
                        <img src="{{ $profil->getFirstMediaUrl('featured_image') }}"
                             alt="{{ $profil->title }}"
                             class="img-fluid border-radius-2 w-100">
                    </div>
                @endif

                <div class="prose prose-lg max-w-none">
                    {!! $profil->content !!}
                </div>

                @if($profil->getMedia('gallery')->count() > 0)
                    <div class="mt-5">
                        <h3 class="text-6 font-weight-semibold line-height-1 mb-4">Galeri</h3>
                        <div class="row g-3">
                            @foreach($profil->getMedia('gallery') as $media)
                                <div class="col-md-4 col-sm-6">
                                    <a href="{{ $media->getUrl() }}" class="d-block" data-lightbox="gallery" data-title="{{ $profil->title }}">
                                        <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}"
                                             alt="{{ $profil->title }}"
                                             class="img-fluid border-radius-2 hover-effect">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4 order-1 order-lg-2 pe-lg-5 mb-4 mb-lg-0">
                <div class="bg-grey-100 p-4 border-radius-2 mb-4">
                    <div class="m-3">
                        <h4 class="text-5 font-weight-semibold line-height-1 mb-4">Menu Profil</h4>
                        <ul class="nav nav-list nav-list-arrows flex-column mb-0">
                            @foreach(App\Models\Profil::active()->ordered()->get() as $item)
                                <li class="nav-item">
                                    <a href="{{ route('profil.show', $item->slug) }}"
                                       class="nav-link {{ $item->id === $profil->id ? 'active text-dark' : '' }}">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    }
    .prose h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
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
        color: #0066cc;
        text-decoration: none;
    }
    .prose a:hover {
        text-decoration: underline;
    }
    .prose blockquote {
        border-left: 4px solid #e5e7eb;
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
</style>
