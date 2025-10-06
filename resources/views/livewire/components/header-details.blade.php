<div>
<div class="page-header py-0 {{ $backgroundClass }} px-3 px-xl-0 border-radius-2 p-relative mb-5">
    <div class="overflow-hidden p-absolute top-0 left-0 bottom-0 h-100 w-100">
        <div class="custom-el-5 custom-pos-4">
            <img class="img-fluid opacity-2 opacity-hover-2" src="{{ asset('frontend/img/waves.svg') }}" alt="">
        </div>
    </div>

    <div class="container p-relative z-index-1 mt-4 py-2">
        <div class="row align-items-center py-4">
            <div class="col-8 col-md-7">
                @if($showBadge && !empty($badge))
                    <div class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="{{ $animationDelay1 }}">
                        <span class="{{ $badgeClass }}">
                            <span class="d-inline-flex py-1 px-2">{{ $badge }}</span>
                        </span>
                    </div>
                @endif

                <div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="{{ $animationDelay2 }}">
                    <h1 class="{{ $titleClass }}">{{ $title }}</h1>
                </div>

                @if($showBreadcrumbs && count($breadcrumbs) > 0)
                    <div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="{{ $animationDelay2 }}">
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb breadcrumb-hierarchical mb-0">
                                @foreach($breadcrumbs as $index => $crumb)
                                    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                        @if($loop->last)
                                            <span class="text-dark font-weight-semibold">{{ $crumb['label'] }}</span>
                                        @else
                                            <a href="{{ $crumb['url'] ?? '#' }}" class="text-dark text-decoration-none opacity-7 opacity-hover-10 transition-opacity">
                                                {{ $crumb['label'] }}
                                            </a>
                                            <i class="fas fa-chevron-right mx-2 text-3 opacity-5"></i>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    </div>
                @else
                    {{-- Debug: Show if breadcrumbs is empty --}}
                    {{-- <div class="text-white-50 small">No breadcrumbs (Debug: {{ count($breadcrumbs ?? []) }} items)</div> --}}
                @endif
            </div>

            @if($showImage)
                <div class="col-4 col-md-5 p-relative">
                    @if($showIcon)
                        <div class="opacity-2 p-absolute w-100 rotate-r-50 custom-pos-5 d-none d-lg-block">
                            @if(!empty($headerIcon))
                                <img src="{{ $headerIcon }}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary w-100'}" />
                            @else
                                <img src="{{ asset('frontend/img/accounting-1/icons/icon-1.svg') }}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary w-100'}" />
                            @endif
                        </div>
                    @endif

                    @if(!empty($image))
                        <div class="custom-mask-img custom-mask-img-4 custom-el-6">
                            <img src="{{ $image }}"
                                loading="lazy"
                                class="img-fluid"
                                alt="{{ $title }}" />
                        </div>
                    @else
                        <div class="custom-mask-img custom-mask-img-4 custom-el-6">
                            <img src="{{ asset('frontend/img/accounting-1/generic/mask-image-4.png') }}"
                                loading="lazy"
                                class="img-fluid"
                                alt="Header Image" />
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Breadcrumb Hierarchical Styling */
.breadcrumb-hierarchical {
    background: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
    list-style: none;
}

.breadcrumb-hierarchical .breadcrumb-item {
    display: inline-flex;
    align-items: center;
    font-size: 0.95rem;
}

.breadcrumb-hierarchical .breadcrumb-item + .breadcrumb-item::before {
    display: none !important;
}

.breadcrumb-hierarchical .breadcrumb-item a {
    transition: all 0.3s ease;
}

.breadcrumb-hierarchical .breadcrumb-item a:hover {
    color: #1B5E20 !important;
    opacity: 1 !important;
}

.breadcrumb-hierarchical .breadcrumb-item.active span {
    color: #1B5E20 !important;
}

.breadcrumb-hierarchical .fa-chevron-right {
    font-size: 0.7rem;
    color: #6b7280;
}

/* Responsive breadcrumb */
@media (max-width: 767px) {
    .breadcrumb-hierarchical {
        font-size: 0.85rem;
    }

    .breadcrumb-hierarchical .fa-chevron-right {
        margin-left: 0.5rem !important;
        margin-right: 0.5rem !important;
    }
}
</style>
</div>