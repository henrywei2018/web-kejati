<div>
    <!-- Hero Section -->
    <section class="section bg-dark border-0 m-0 p-relative overflow-hidden" style="background-image: url({{ asset('frontend/img/demos/accounting-1/bg/bg-1.jpg') }}); background-size: cover; background-position: center;">
        <div class="custom-el-1 custom-pos-1 opacity-1">
            <img class="img-fluid opacity-5" src="{{ asset('frontend/img/demos/accounting-1/svg/waves-1.svg') }}" alt="">
        </div>
        <div class="container p-relative z-index-1 py-5 my-5">
            <div class="row align-items-center py-5 my-5">
                <div class="col-lg-6 py-5">
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="0">
                        <span class="badge bg-gradient-light-rgba-20 text-light rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-4">
                            <span class="d-inline-flex py-1 px-2">Professional Services</span>
                        </span>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                        <h1 class="text-9 text-lg-12 font-weight-semibold line-height-1 mb-2 text-light">{{ $heroTitle }}</h1>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                        <p class="text-4 text-light opacity-7 mb-4 pb-2">{{ $heroSubtitle }}</p>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
                        <a href="{{ route('contact') }}" class="btn btn-rounded btn-light btn-outline font-weight-bold text-3 btn-px-5 py-3 me-2">
                            Get Started Today
                        </a>
                        <a href="{{ route('services') }}" class="btn btn-rounded btn-transparent border-color-light-3 text-light font-weight-bold text-3 btn-px-5 py-3">
                            Our Services
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="800">
                        <img class="img-fluid" src="{{ asset('frontend/img/demos/accounting-1/hero-img.png') }}" alt="Professional Accounting Services">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section bg-light border-0 m-0">
        <div class="container">
            <div class="row py-4">
                @foreach($stats as $stat)
                <div class="col-sm-6 col-lg-3 text-center mb-4 mb-lg-0">
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="{{ $loop->index * 200 }}">
                        <div class="counter counter-text-color-dark">
                            <strong data-to="{{ str_replace(['%', '+'], '', $stat['number']) }}" data-append="{{ str_contains($stat['number'], '%') ? '%' : (str_contains($stat['number'], '+') ? '+' : '') }}" class="text-8 text-color-dark">{{ $stat['number'] }}</strong>
                            <label class="text-4 text-color-grey font-weight-medium">{{ $stat['label'] }}</label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section bg-tertiary border-0 m-0">
        <div class="container py-5">
            <div class="row">
                <div class="col text-center">
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="0">
                        <span class="badge bg-gradient-tertiary-dark text-light rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-4">
                            <span class="d-inline-flex py-1 px-2">Our Services</span>
                        </span>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                        <h2 class="text-9 text-lg-12 font-weight-semibold line-height-1 mb-2 text-light">What We Offer</h2>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                        <p class="text-4 text-light opacity-7 mb-5">Comprehensive financial solutions tailored to your business needs.</p>
                    </div>
                </div>
            </div>
            <div class="row py-4">
                @forelse($services as $service)
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="{{ $loop->index * 200 + 600 }}">
                        <div class="feature-box feature-box-style-2 bg-light border-radius-2 p-4 h-100 position-relative overflow-hidden">
                            @if($service['image'])
                            <div class="feature-box-image mb-3">
                                <img src="{{ $service['image'] }}" 
                                     alt="{{ $service['title'] }}" 
                                     class="img-fluid rounded" 
                                     style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            @endif
                            
                            <div class="feature-box-info">
                                <h4 class="font-weight-bold text-4 text-color-dark mb-2">{{ $service['title'] }}</h4>
                                @if($service['description'])
                                <p class="text-3 text-color-grey mb-3">{{ $service['description'] }}</p>
                                @endif
                                
                                @if($service['click_url'])
                                <button wire:click="trackBannerClick({{ $service['id'] }})" 
                                        class="btn btn-sm btn-outline btn-primary">
                                    Learn More
                                </button>
                                @endif
                            </div>
                            
                            <!-- Click overlay for tracking -->
                            @if($service['click_url'])
                            <a href="{{ $service['click_url'] }}" 
                               target="{{ $service['click_url_target'] }}"
                               wire:click="trackBannerClick({{ $service['id'] }})"
                               class="position-absolute top-0 start-0 w-100 h-100" 
                               style="z-index: 1;">
                               <span class="sr-only">{{ $service['title'] }}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <!-- Fallback if no services found -->
                <div class="col text-center">
                    <p class="text-light opacity-7">No services available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    @if(!empty($latestPosts))
    <!-- Latest News/Posts Section -->
    <section class="section bg-light border-0 m-0">
        <div class="container py-5">
            <div class="row">
                <div class="col text-center">
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="0">
                        <span class="badge bg-gradient-primary text-light rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-4">
                            <span class="d-inline-flex py-1 px-2">Latest News</span>
                        </span>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                        <h2 class="text-9 text-lg-12 font-weight-semibold line-height-1 mb-2">Stay Updated</h2>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                        <p class="text-4 text-color-grey mb-5">Latest insights and updates from our team.</p>
                    </div>
                </div>
            </div>
            <div class="row py-4">
                @foreach($latestPosts as $post)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="{{ $loop->index * 200 + 600 }}">
                        <article class="post post-medium bg-white border-radius-2 box-shadow-1 h-100">
                            @if($post['featured_image'])
                            <div class="post-image">
                                <a href="{{ route('artikel.post', $post['slug']) }}">
                                    <img src="{{ $post['featured_image'] }}" 
                                         alt="{{ $post['title'] }}" 
                                         class="img-fluid rounded-top"
                                         style="width: 100%; height: 200px; object-fit: cover;">
                                </a>
                            </div>
                            @endif
                            
                            <div class="post-content p-4">
                                @if($post['category'])
                                <div class="post-meta mb-2">
                                    <span class="badge bg-primary text-light">{{ $post['category']['name'] }}</span>
                                </div>
                                @endif
                                
                                <h4 class="post-title font-weight-bold text-4 mb-2">
                                    <a href="{{ route('artikel.post', $post['slug']) }}" class="text-color-dark text-decoration-none">
                                        {{ $post['title'] }}
                                    </a>
                                </h4>
                                
                                @if($post['content_overview'])
                                <p class="post-excerpt text-3 text-color-grey mb-3">
                                    {{ Str::limit($post['content_overview'], 120) }}
                                </p>
                                @endif
                                
                                <div class="post-meta d-flex justify-content-between align-items-center text-2">
                                    <span class="text-color-grey">
                                        {{ $post['published_at']->format('M d, Y') }}
                                    </span>
                                    @if($post['reading_time'])
                                    <span class="text-color-grey">
                                        {{ $post['reading_time'] }} min read
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="row">
                <div class="col text-center">
                    <a href="{{ route('artikel.index') }}" class="btn btn-outline btn-primary btn-rounded">View All News</a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="section bg-primary border-0 m-0">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-lg-8">
                    <div class="appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="0">
                        <h3 class="text-6 font-weight-semibold text-light mb-2">Ready to Transform Your Financial Management?</h3>
                        <p class="text-4 text-light opacity-7 mb-0">Contact us today for a free consultation and discover how we can help your business grow.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                        <a href="{{ route('contact') }}" class="btn btn-rounded btn-light font-weight-bold text-3 btn-px-5 py-3">
                            Get Free Consultation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>