<div>
    <!-- Hero Section -->
    <div class="row px-xl-0 py-2 overflow-hidden">
        {{-- main banner --}}
        <div class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn owl-theme manual nav-style-1 nav-arrows-thin nav-inside nav-inside-plus nav-dark nav-lg nav-font-size-lg rounded-nav nav-borders show-nav-hover mb-0"
            data-plugin-options="{'autoplay': true, 'autoplayTimeout': 7000}"
            data-dynamic-height="['750px','750px','750px','750px','750px']" style="height: 750px;">
            <div class="owl-stage-outer">
                <div class="owl-stage">

                    @if($heroBanner && $heroBanner->isNotEmpty())
                        @foreach($heroBanner as $banner)
                            <!-- Carousel Slide -->
                            <div class="owl-item p-relative border-radius-2 overflow-hidden">
                                @if($banner->hasImage())
                                    <div class="background-image-wrapper p-absolute z-index-1 top-0 left-0 right-0 bottom-0 overlay overlay-color-dark overlay-show overlay-op-6"
                                        data-appear-animation="kenBurnsToLeft" data-appear-animation-duration="30s"
                                        data-carousel-onchange-show
                                        style="background-image: url({{ $banner->getImageUrl('large') }}); background-size: cover; background-position: center;">
                                    </div>
                                @else
                                    <div class="bg-primary border-radius-2 p-relative z-index-1 overflow-hidden">
                                        <div class="custom-el-2 custom-pos-1">
                                            <img class="img-fluid opacity-2 opacity-hover-2"
                                                src="img/demos/accounting-1/svg/waves.svg" alt="">
                                        </div>
                                    </div>
                                @endif

                                <div class="container {{ $banner->hasImage() ? 'text-color-light' : '' }} p-relative z-index-2">
                                    <div class="row justify-content-center align-items-center mh-750px py-5">
                                        <div class="col-lg-8 text-center">
                                            @if($banner->title)
                                                <div class="appear-animation" data-appear-animation="fadeInUpShorter"
                                                    data-appear-animation-delay="400">
                                                    <h1 class="text-10 text-lg-12 font-weight-semibold line-height-1 {{ $banner->hasImage() ? 'text-color-light' : '' }}">
                                                        {{ $banner->title }}
                                                    </h1>
                                                </div>
                                            @endif

                                            @if($banner->description)
                                                <div class="appear-animation" data-appear-animation="fadeInUpShorter"
                                                    data-appear-animation-delay="600">
                                                    <p class="text-4 text-lg-5 line-height-5 {{ $banner->hasImage() ? 'text-light' : 'text-dark opacity-7' }} mb-4">
                                                        {{ $banner->description }}
                                                    </p>
                                                </div>
                                            @endif

                                            @if($banner->click_url)
                                                <div class="appear-animation" data-appear-animation="fadeInUpShorter"
                                                    data-appear-animation-delay="800">
                                                    <a href="{{ $banner->click_url }}"
                                                       @if($banner->click_url_target === '_blank') target="_blank" @endif
                                                       class="btn btn-light btn-effect-2 transition-3ms border-0 btn-rounded btn-xl text-3 py-4 btn-with-arrow-solid mt-3">
                                                        <strong class="d-inline-flex text-dark font-weight-medium text-3-5 text-lg-4 me-3 px-3">
                                                            Selengkapnya
                                                        </strong>
                                                        <span class="bg-transparent box-shadow-6">
                                                            <i class="fa-solid fa-arrow-right text-dark"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback Slide if no banner -->
                        <div class="owl-item p-relative overflow-hidden">
                            <div class="bg-primary border-radius-2 p-relative z-index-1 overflow-hidden">
                                <div class="container p-relative z-index-2">
                                    <div class="row justify-content-center align-items-center mh-750px py-5">
                                        <div class="col-lg-8 text-center">
                                            <h1 class="text-10 text-lg-12 font-weight-semibold line-height-1">
                                                Kejaksaan Tinggi Kalimantan Utara
                                            </h1>
                                            <p class="text-4 text-lg-5 line-height-5 text-dark opacity-7 mb-4">
                                                Melayani dengan Integritas, Menegakkan Keadilan
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <div class="owl-nav">
                <button type="button" role="presentation" class="owl-prev" aria-label="Previous"></button>
                <button type="button" role="presentation" class="owl-next" aria-label="Next"></button>
            </div>
        </div>
        {{-- floating banner on bottom right overlaped main banner --}}
        <div class="container pt-2 pb-4 carousel-half-full-width-wrapper carousel-half-full-width-right" style="margin-top: -110px;">
            <div class="owl-carousel owl-theme carousel-half-full-width-right mb-2"
                data-plugin-options="{'responsive': {'0': {'items': 1}, '768': {'items': 3}, '992': {'items': 4}, '1200': {'items': 5}}, 'loop': true, 'nav': false, 'dots': false, 'margin': 20}">

                @if($layananServices && $layananServices->isNotEmpty())
                    @foreach($layananServices as $service)
                        <div class="box-shadow-7 border-radius-2 overflow-hidden">
                            <span class="thumb-info thumb-info-no-overlay thumb-info-show-hidden-content-hover">
                                <span class="thumb-info-wrapper overlay overlay-show overlay-gradient-bottom-content border-radius-0 rounded-top">
                                    @if($service->click_url)
                                        <a href="{{ $service->click_url }}"
                                           @if($service->click_url_target === '_blank') target="_blank" @endif
                                           title="{{ $service->title }}">
                                    @endif
                                        @if($service->hasImage())
                                            <img src="{{ $service->getImageUrl('medium') }}" loading="lazy"
                                                class="img-fluid" alt="{{ $service->title }}"
                                                style="aspect-ratio: 4/3; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="aspect-ratio: 4/3;">
                                                <i class="fas fa-briefcase fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    @if($service->click_url)
                                        </a>
                                    @endif
                                </span>
                                <span class="thumb-info-content">
                                    <span class="thumb-info-content-inner bg-light p-4">
                                        <h4 class="text-5 mb-2">{{ Str::limit($service->title, 30) }}</h4>
                                        @if($service->description)
                                            <p class="line-height-7 text-3 mb-0">{{ Str::limit($service->description, 80) }}</p>
                                        @endif
                                        @if($service->click_url)
                                            <span class="thumb-info-content-inner-hidden p-absolute d-block w-100 py-3">
                                                <a href="{{ $service->click_url }}"
                                                   @if($service->click_url_target === '_blank') target="_blank" @endif
                                                   class="text-uppercase text-color-secondary text-color-hover-primary font-weight-semibold text-decoration-underline">
                                                    Lihat Detail
                                                </a>
                                                <a href="{{ $service->click_url }}"
                                                   @if($service->click_url_target === '_blank') target="_blank" @endif
                                                   class="btn btn-light btn-rounded box-shadow-7 btn-xl border-0 text-3 p-0 btn-with-arrow-solid p-absolute right-0 transform3dx-n100 bottom-7">
                                                    <span class="p-static bg-transparent transform-none">
                                                        <i class="fa-solid fa-arrow-right text-dark"></i>
                                                    </span>
                                                </a>
                                            </span>
                                        @endif
                                    </span>
                                </span>
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="box-shadow-7 border-radius-2 overflow-hidden">
                        <div class="text-center py-5 bg-light">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Layanan</h5>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
    
    <div class="px-xl-0 py-1">
        <div class="row pb-1 pt-2">
            <div class="d-flex align-items-center justify-content-between py-3" style="height: 52px;">
                <h5 class="text-4 flex-shrink-0 d-flex align-items-center m-0">
                    <strong
                        class="font-weight-bold rounded-3 text-1 px-3 text-light py-2 bg-primary text-nowrap d-inline-flex align-items-center" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;">
                        Berita terkini
                    </strong>
                </h5>

                <div class="divider divider-primary divider-sm mx-4 flex-grow-1 align-self-center">

                </div>

                <a href="/artikel"
                    class="btn btn-outline btn-primary  rounded-3  font-weight-bold text-3 px-5 py-2">Lihat
                    Semua</a>
            </div>
            
            <div class="col-lg-5 py-2">
                <!-- Most Popular Articles Section -->
                <div>
                    <article id="article-content"
                        class="card rounded-3 border-0 thumb-info thumb-info-no-borders thumb-info-bottom-info thumb-info-bottom-info-dark overflow-hidden">
                        <div class="thumb-info-wrapper thumb-info-wrapper-opacity-1 position-relative"
                            style="height: 460px; overflow: hidden;">
                            <a id="article-link" href="#">
                                <span class="thumb-info-action-icon thumb-info-action-icon-light"><i
                                        class="fas fa-eye text-dark"></i></span>
                            </a>
                            @if($popularPosts && $popularPosts->isNotEmpty())
                                <img id="article-image"
                                     src="{{ $popularPosts->first()['featured_image'] ?? asset('img/default-blog-image.jpg') }}"
                                     class="img-fluid"
                                     style="height: 100%; width: 100%; object-fit: cover;"
                                     alt="{{ $popularPosts->first()['title'] ?? 'Berita Terpopuler' }}">
                            @else
                                <img id="article-image" src="{{ asset('img/default-blog-image.jpg') }}" class="img-fluid"
                                    style="height: 100%; width: 100%; object-fit: cover;" alt="Berita Terpopuler">
                            @endif
                            <div
                                class="thumb-info-title position-absolute bottom-0 w-100 bg-black bg-opacity-50 text-white px-4 py-3 rounded-bottom">
                                <div id="article-category"
                                    class="thumb-info-type bg-dark px-2 py-1 d-inline-block rounded mb-2">
                                    @if($popularPosts && $popularPosts->isNotEmpty() && isset($popularPosts->first()['category']))
                                        {{ $popularPosts->first()['category']['name'] }}
                                    @else
                                        Berita
                                    @endif
                                </div>
                                <h2 id="article-title" class="font-weight-bold text-light line-height-1 text-5 mb-1">
                                    @if($popularPosts && $popularPosts->isNotEmpty())
                                        {{ Str::limit($popularPosts->first()['title'], 80) }}
                                    @else
                                        Belum Ada Berita Terpopuler
                                    @endif
                                </h2>
                                <div class="d-flex justify-content-between align-items-center text-light mt-3">
                                    <p id="article-meta" class="text-uppercase text-1 text-light opacity-8 mb-0">
                                        @if($popularPosts && $popularPosts->isNotEmpty())
                                            <time pubdate datetime="{{ $popularPosts->first()['published_at'] }}">
                                                {{ \Carbon\Carbon::parse($popularPosts->first()['published_at'])->format('d M Y') }}
                                            </time>
                                            <span class="opacity-8 d-inline-block px-2 text-light">|</span>
                                            {{ $popularPosts->first()['view_count'] ?? 0 }} <i class="icon-book-open icons"> kali dibaca</i>
                                        @else
                                            <time pubdate datetime="">-</time>
                                            <span class="opacity-8 d-inline-block px-2 text-light">|</span>
                                            0 <i class="icon-book-open icons"> kali dibaca</i>
                                        @endif
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center owl-nav">
                                        <button id="prev-article" class="btn btn-tertiary btn-sm">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <span id="article-counter" class="text-light small px-2">
                                            @if($popularPosts && $popularPosts->isNotEmpty())
                                                Berita 1 dari {{ $popularPosts->count() }}
                                            @else
                                                Berita 0 dari 0
                                            @endif
                                        </span>
                                        <button id="next-article" class="btn btn-tertiary btn-sm">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                // Parse the JSON data from PHP - using popularPosts (most viewed)
                                const articles = @json($popularPosts);
                                const totalArticles = articles.length;

                                if (totalArticles === 0) {
                                    console.warn('No popular articles available.');
                                    return;
                                }

                                let currentIndex = 0;

                                // DOM Elements
                                const articleImage = document.getElementById('article-image');
                                const articleLink = document.getElementById('article-link');
                                const articleCategory = document.getElementById('article-category');
                                const articleTitle = document.getElementById('article-title');
                                const articleMeta = document.getElementById('article-meta');
                                const articleCounter = document.getElementById('article-counter');
                                const prevButton = document.getElementById('prev-article');
                                const nextButton = document.getElementById('next-article');

                                const updateArticleContent = (index) => {
                                    const article = articles[index];

                                    if (!article) {
                                        console.warn(`No article found at index ${index}`);
                                        return;
                                    }

                                    // Access array elements using bracket notation
                                    articleImage.src = article['featured_image'] || '{{ asset('img/default-blog-image.jpg') }}';
                                    articleLink.href = `/berita/${article['slug']}`;
                                    articleImage.alt = article['title'];
                                    articleCategory.textContent = article['category'] ? article['category']['name'] : 'Uncategorized';
                                    articleTitle.textContent = article['title'];

                                    const publishDate = new Date(article['published_at']).toLocaleDateString('id-ID', {
                                        year: 'numeric',
                                        month: 'short',
                                        day: 'numeric'
                                    });

                                    articleMeta.innerHTML = `
							<time pubdate datetime="${article['published_at']}">
								${publishDate}
							</time>
							<span class="opacity-8 d-inline-block px-2 text-light">|</span>
							${article['view_count']} <i class="icon-book-open icons"> kali dibaca</i>
						`;

                                    articleCounter.textContent = `Berita ${index + 1} dari ${totalArticles}`;

                                    // Debug log
                                    console.log('Updated article:', article);
                                };

                                const navigate = (direction) => {
                                    if (direction === 'next') {
                                        currentIndex = (currentIndex + 1) % totalArticles;
                                    } else if (direction === 'prev') {
                                        currentIndex = (currentIndex - 1 + totalArticles) % totalArticles;
                                    }
                                    updateArticleContent(currentIndex);
                                };

                                // Event Listeners
                                prevButton.addEventListener('click', () => navigate('prev'));
                                nextButton.addEventListener('click', () => navigate('next'));

                                // Initialize first article
                                updateArticleContent(currentIndex);

                                // Debug log
                                console.log('Initial popular articles data:', articles);
                            });
                        </script>
                    @endpush
                </div>
            </div>
            <!-- Right Column -->
            <div class="col-lg-4 py-2">
                <div class="tabs">
                    <ul class="nav nav-tabs nav-justified flex-column flex-md-row" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#popular10" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">Populer</a>
                        </li>
                        <li class="nav-item active" role="presentation">
                            <a class="nav-link active" href="#recent10" data-bs-toggle="tab" aria-selected="true"
                                role="tab">Terbaru</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="popular10" class="tab-pane" role="tabpanel">
                            @foreach ($this->popularPosts as $post)
                                <div class="col-md-12 col-lg-12 appear-animation animated fadeInUpShorter appear-animation-visible"
                                    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600"
                                    style="animation-delay: 600ms;">
                                    <div
                                        class="card card-text-color-hover-light border-0 bg-color-hover-primary transition-2ms ">
                                        <div class="card-body"
                                            style="	padding-top: 10px; padding-bottom: 10px; padding-right: 10px; padding-left: 10px;">
                                            <h4
                                                class="card-title mb-1 text-4 line-height-1 font-weight-bold transition-2ms">
                                                <a href="{{ route('berita.show', $post['slug']) }}"
                                                    class="text-decoration-none text-primary">
                                                    {{ Str::words($post['title'], 10, '...') }}
                                                </a>
                                            </h4>
                                            @php
                                                $date = \Carbon\Carbon::parse($post['published_at'])->locale('id');
                                            @endphp
                                            <div
                                                class="p-absolute bottom-2 right-1 d-flex justify-content-end py-1 px-1 z-index-3">
                                                <p class="text-uppercase text-1 text-color-default mb-0 px-2">
                                                    {{ $date->diffForHumans() }}
                                                </p>
                                                <span
                                                    class="text-center bg-primary rounded-2 text-color-light font-weight-semibold line-height-1 px-1 py-1">
                                                    <span class="position-relative text-2 z-index-2">
                                                        {{ $date->format('d') }}
                                                        <span class="d-block text-0 positive-ls-2">
                                                            {{ $date->format('M') }}
                                                        </span>
                                                    </span>
                                                </span>
                                            </div>
                                            <p class="text-uppercase text-1 text-color-default mb-0">
                                                {{ $post['view_count'] }} <i class="icon-book-open icons"> Baca</i>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        <div id="recent10" class="tab-pane active show" role="tabpanel">
                            @foreach ($latestPosts as $post)
                                <div class="col-md-12 col-lg-12 appear-animation animated fadeInUpShorter appear-animation-visible"
                                    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600"
                                    style="animation-delay: 600ms;">
                                    <div
                                        class="card card-text-color-hover-light border-0 bg-color-hover-primary transition-2ms ">
                                        <div class="card-body"
                                            style="
									padding-top: 10px;
									padding-bottom: 10px;
									padding-right: 10px;
									padding-left: 10px;
									">
                                            <h4
                                                class="card-title mb-1 text-4 line-height-1 font-weight-bold transition-2ms">
                                                <a href="{{ route('berita.show', $post['slug']) }}"
                                                    class="text-decoration-none text-primary">
                                                    {{ Str::words($post['title'], 10, '...') }}
                                                </a>
                                            </h4>
                                            @php
                                                $date = \Carbon\Carbon::parse($post['published_at'])->locale('id');
                                            @endphp
                                            <div
                                                class="p-absolute bottom-2 right-1 d-flex justify-content-end py-1 px-1 z-index-3">
                                                <p class="text-uppercase text-1 text-color-default mb-0 px-2">
                                                    {{ $date->diffForHumans() }}
                                                </p>
                                                <span
                                                    class="text-center bg-primary rounded-2 text-color-light font-weight-semibold line-height-1 px-1 py-1">
                                                    <span class="position-relative text-2 z-index-2">
                                                        {{ $date->format('d') }}
                                                        <span class="d-block text-0 positive-ls-2">
                                                            {{ $date->format('M') }}
                                                        </span>
                                                    </span>
                                                </span>
                                            </div>
                                            <p class="text-uppercase text-1 text-color-default mb-0">
                                                {{ $post['view_count'] }} <i class="icon-book-open icons"> Baca</i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 py-2">                
				<div class="igwrapper rounded-3">
								<style>
									.igwrapper {
										background: #fff;
										position: relative;
										width: 316px;
										border-radius: 80px;
										box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
									}

									.igwrapper iframe {
										border: 0;
										position: relative;
										z-index: 2;
										width: 100% !important;
										min-width: 300x !important;
									}

									.igwrapper a {
										color: rgba(0, 0, 0, 0);
										position: absolute;
										left: 0;
										top: 0;
										z-index: 0;
									}

									.instagram-media {
										min-width: 300px !important;
										width: 300px !important;
									}
								</style>
								<script async src="https://www.instagram.com/embed.js"></script>
								<blockquote class="instagram-media"
									data-instgrm-permalink="https://www.instagram.com/kejati_kalimantan_utara/"
									data-instgrm-version="14"
									style="background:#FFF; border:0; border-radius:16px; box-shadow:none; margin:0; padding:0;">
								</blockquote>
				</div>
            </div>
        </div>
    </div>
    <div class="px-xl-0 py-8">
        <div class="row">
            <div class="col-lg-8 p-4">
                <!-- Bagian infografis -->
                <div class="heading heading-border heading-middle-border mt-3 pt-6">
                    <h3 class="text-4">
                        <strong
                            class="font-weight-bold rounded-3 text-1 px-3 text-light py-2 bg-primary" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;">Infografis</strong>
                    </h3>
                </div>
                <div class="row pb-1">
                    @if (isset($latestInfografis) && $latestInfografis && $latestInfografis->isNotEmpty())
                        <div class="col-lg-5 pb-1">
                            @php $firstInfographic = $latestInfografis->first(); @endphp
                            @if ($firstInfographic)
                                <article
                                    class="thumb-info thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
                                    <div class="row">
                                        <div class="col">
                                            <div class="large-image-frame" style="cursor: pointer;" wire:click="showMediaDetail({{ $firstInfographic['id'] }})">
                                                <img src="{{ $firstInfographic['file_url'] }}"
                                                    alt="{{ $firstInfographic['title'] }}">
                                                <div class="image-overlay" style="background: linear-gradient(135deg, #f5dc00 0%, #c0b301 100%); color: white; border: none;">
                                                    <div class="overlay-content">
                                                        <span class="date">
                                                            {{ $firstInfographic['created_at']->format('F d, Y') }}
                                                        </span>
                                                        <h4>{{ $firstInfographic['judul'] }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            @if ($latestInfografis->count() > 1)
                                @foreach ($latestInfografis->skip(1) as $infographic)
                                    <article
                                        class="thumb-info thumb-info-no-zoom bg-transparent border-radius-0 pb-4 mb-2"
                                        style="cursor: pointer;"
                                        wire:click="showMediaDetail({{ $infographic['id'] }})">
                                        <div class="row align-items-center pb-1">
                                            <div class="col-sm-4">
                                                <div class="small-image-frame">
                                                    <img src="{{ $infographic['file_url'] }}"
                                                        alt="{{ $infographic['title'] }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-7 ps-sm-0">
                                                <div class="thumb-info-caption-text">
                                                    <div class="d-inline-block text-default text-1 float-none text-color-default">
                                                        {{ $infographic['created_at']->format('F d, Y') }}
                                                    </div>
                                                    <h4
                                                        class="d-block pb-2 line-height-2 text-3 text-dark font-weight-bold mb-0 text-color-dark">
                                                        {{ $infographic['judul'] }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            @endif
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-chart-bar fa-3x text-muted"></i>
                                </div>
                                <h5 class="text-muted">Belum Ada Infografis</h5>
                                <p class="text-muted">Infografis akan segera ditampilkan di sini.</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="pb-6 text-center">
                    <a href="{{ url('/infografis') }}"
                        class="btn btn-primary btn-outline rounded-3 font-weight-bold text-3 px-5 py-2">
                        Lihat Semua
                    </a>
                </div>

                <!-- Bagian Publikasi -->
                <div class="heading heading-border heading-middle-border mt-3 pt-6">
                    <h3 class="text-4">
                        <strong
                            class="font-weight-bold rounded-3 text-1 px-3 text-light py-2 bg-primary" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;">Publikasi</strong>
                    </h3>
                </div>
                <div class="row pb-1">
                    <div class="col">
                        @if (isset($publikasi) && $publikasi && $publikasi->isNotEmpty())
                            <div class="owl-carousel owl-theme stage-margin rounded-nav nav-dark nav-icon-1 nav-size-md nav-position-1 owl-loaded owl-drag owl-carousel-init"
                                data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 2}, '979': {'items': 2}, '1199': {'items': 3}}, 'margin': 10, 'loop': true, 'nav': true, 'dots': false, 'stagePadding': 40}">

                                @foreach ($publikasi as $item)
                                    <div class="item">
                                        <div class="featured-box h-100" style="cursor: pointer;" wire:click="showMediaDetail({{ $item['id'] }})">
                                            <div class="box-content">
                                                <div class="pdf-icon text-center mb-3">
                                                    @if ($item['is_pdf'])
                                                        <i class="far fa-file-pdf fa-3x text-danger"></i>
                                                    @else
                                                        <i class="far fa-file fa-3x text-primary"></i>
                                                    @endif
                                                </div>
                                                <h5 class="text-center">
                                                    {{ Str::limit($item['title'], 50) }}
                                                </h5>
                                                <p class="text-center text-muted">
                                                    {{ $item['publication_date'] }}
                                                </p>
                                                <div class="item-footer">
                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;" title="Lihat Detail">
                                                        <i class="fas fa-eye me-1"></i> Lihat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- Empty State --}}
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="far fa-file-pdf fa-3x text-muted"></i>
                                </div>
                                <h5 class="text-muted">Belum Ada Publikasi</h5>
                                <p class="text-muted">Publikasi dan laporan akan segera tersedia di sini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pb-6 text-center">
                    <a href="{{ url('/publikasi') }}"
                        class="btn btn-primary btn-outline rounded-3 font-weight-bold text-3 px-5 py-2">
                        Lihat Semua
                    </a>
                </div>

                <!-- Bagian Pengumuman -->
                <div class="heading heading-border heading-middle-border mt-3 pt-6">
                    <h3 class="text-4">
                        <strong
                            class="font-weight-bold rounded-3 text-1 px-3 text-light py-2 " style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;">Pengumuman</strong>
                    </h3>
                </div>
                <div class="row pb-1">
                    <div class="col">
                        @if (isset($pengumuman) && $pengumuman && $pengumuman->isNotEmpty())
                            <div class="owl-carousel owl-theme stage-margin rounded-nav nav-dark nav-icon-1 nav-size-md nav-position-1 owl-loaded owl-drag owl-carousel-init"
                                data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 2}, '979': {'items': 2}, '1199': {'items': 3}}, 'margin': 10, 'loop': true, 'nav': true, 'dots': false, 'stagePadding': 40}">

                                @foreach ($pengumuman as $item)
                                    <div class="item">
                                        <div class="featured-box h-100" style="cursor: pointer;" wire:click="showMediaDetail({{ $item['id'] }})">
                                            <div class="box-content">
                                                <div class="pdf-icon text-center mb-3">
                                                    @if ($item['is_pdf'])
                                                        <i class="far fa-file-pdf fa-3x text-danger"></i>
                                                    @else
                                                        <i class="fas fa-info-circle fa-3x text-primary"></i>
                                                    @endif
                                                </div>
                                                <h5 class="text-center">
                                                    {{ Str::limit($item['title'], 50) }}
                                                </h5>
                                                <p class="text-center text-muted">
                                                    {{ $item['publication_date'] }}
                                                </p>
                                                <div class="item-footer">
                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;" title="Lihat Detail">
                                                        <i class="fas fa-eye me-1"></i> Lihat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- Empty State --}}
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-info-circle fa-3x text-muted"></i>
                                </div>
                                <h5 class="text-muted">Belum Ada Pengumuman</h5>
                                <p class="text-muted">Pengumuman akan segera tersedia di sini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pb-3 text-center">
                    <a href="{{ url('/pengumuman') }}"
                        class="btn btn-primary btn-outline rounded-3 font-weight-bold text-3 px-5 py-2" >
                        Lihat Semua
                    </a>
                </div>

            </div>
            <div class="col-lg-4 order-2 order-lg-0 mt-4 mt-lg-0">
                <div class="bg-grey-100 p-2 border-radius-2 mb-4">
                    <div class="m-3">
                        <h4 class="text-5 font-weight-semibold line-height-1 mb-4">Layanan Kami</h4>

                        @if($layananServices && $layananServices->isNotEmpty())
                            <ul class="nav nav-list nav-list-arrows flex-column mb-0">
                                @foreach($layananServices as $index => $service)
                                    <li class="nav-item">
                                        <a href="{{ $service->click_url ?? '#' }}"
                                           class="nav-link {{ $index === 0 ? 'active' : '' }} text-dark"
                                           @if($service->click_url_target === '_blank') target="_blank" @endif>
                                            {{ $service->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-3">
                                <p class="text-muted mb-0">Belum Ada Layanan</p>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="bg-primary text-light p-4 border-radius-2 mb-4" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;">
                    
                        <h4 class="text-5 font-weight-semibold line-height-1 mb-4 text-light">Kepala Kejaksaan Tinggi</h4>

                        @if($kepalaKejaksaan)
                            <a href="{{ url('/organisasi/pegawai') }}" class="d-block text-decoration-none">
                                <div class="border-radius-2 overflow-hidden">
                                    <span class="thumb-info thumb-info-no-overlay thumb-info-show-hidden-content-hover">
                                        <span class="thumb-info-wrapper border-radius-0 rounded-top">
                                            @if($kepalaKejaksaan->getFirstMediaUrl('photo'))
                                                <img src="{{ $kepalaKejaksaan->getFirstMediaUrl('photo') }}"
                                                    loading="lazy" class="img-fluid" alt="{{ $kepalaKejaksaan->name }}"
                                                    style="aspect-ratio: 3/4; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                     style="aspect-ratio: 3/4;">
                                                    <i class="fas fa-user fa-5x text-muted"></i>
                                                </div>
                                            @endif
                                        </span>
                                        <span class="thumb-info-content">
                                            <span class="thumb-info-content-inner bg-light p-4">
                                                <h4 class="text-5 mb-1">{{ $kepalaKejaksaan->name }}</h4>
                                                <p class="line-height-7 text-3 mb-0">{{ $kepalaKejaksaan->position ?? 'Kepala Kejaksaan Tinggi' }}</p>
                                                @if($kepalaKejaksaan->social_media && count($kepalaKejaksaan->social_media) > 0)
                                                    <span class="thumb-info-content-inner-hidden p-absolute d-block w-100 py-3">
                                                        <ul class="social-icons social-icons-clean social-icons-medium">
                                                            @foreach($kepalaKejaksaan->social_media as $social)
                                                                <li class="social-icons-{{ strtolower($social['platform']) }}">
                                                                    <a href="{{ $social['url'] }}" target="_blank" title="{{ ucfirst($social['platform']) }}">
                                                                        <i class="fab fa-{{ strtolower($social['platform']) == 'x' ? 'x-twitter' : strtolower($social['platform']) }}"></i>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </span>
                                                @endif
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            </a>
                        @else
                            <div class="border-radius-2 overflow-hidden">
                                <div class="text-center py-5 bg-light">
                                    <i class="fas fa-user fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Data Tidak Tersedia</p>
                                </div>
                            </div>
                        @endif
{{-- 
                        <div class="d-flex flex-column pt-4">
                            <div class="pe-4">
                                <div class="feature-box feature-box-secondary align-items-center">
                                    <div class="feature-box-icon feature-box-icon-lg p-static box-shadow-7">
                                        <img src="img/icons/phone-2.svg" width="30" height="30"
                                            alt="" data-icon
                                            data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
                                    </div>
                                    <div class="feature-box-info ps-2">
                                        <strong
                                            class="d-block text-uppercase text-color-secondary p-relative top-2">Call
                                            Us</strong>
                                        <a href="tel:1234567890"
                                            class="text-decoration-none font-secondary text-5 font-weight-semibold text-color-light text-color-hover-primary transition-2ms negative-ls-05 ws-nowrap p-relative bottom-2">800
                                            123 4567</a>
                                    </div>
                                </div>
                            </div>
                            <div class="pe-4 pt-4">
                                <div class="feature-box feature-box-secondary align-items-center">
                                    <div class="feature-box-icon feature-box-icon-lg p-static box-shadow-7">
                                        <img src="img/icons/email.svg" width="30" height="30" alt=""
                                            data-icon
                                            data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
                                    </div>
                                    <div class="feature-box-info ps-2">
                                        <strong
                                            class="d-block text-uppercase text-color-secondary p-relative top-2">Send
                                            E-mail</strong>
                                        <a href="mailto:you@domain.com"
                                            class="text-decoration-none font-secondary text-5 font-weight-semibold text-color-light text-color-hover-primary transition-2ms negative-ls-05 ws-nowrap p-relative bottom-2">you@domain.com</a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Our Teams -->
    <div class="bg-primary px-xl-0 py-8 border-radius-2 text-light p-relative overflow-hidden" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;" >
        <div class="custom-el-3 custom-pos-2 opacity-1">
            <img class="img-fluid opacity-5" src="" alt="">
        </div>
        <div class="container p-relative z-index-1">
            <div class="row align-items-center py-2">
                <div class="col py-2">
                                        <div class="appear-animation" data-appear-animation="fadeInUpShorter"
                        data-appear-animation-delay="200">
                        <h2 class="text-9 text-lg-12 font-weight-semibold line-height-1 mb-2 text-light">Pejabat Kejati</h2>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter"
                        data-appear-animation-delay="400">
                        <p class="pe-lg-5 text-light opacity-7">Daftar Pejabat di Lingkungan Kejaksaan Tinggi Kalimantan Utara</p>
                    </div>
                    <div class="pt-2 pb-4">

                        <div class="carousel-half-full-width-wrapper carousel-half-full-width-right">
                            <div class="owl-carousel owl-theme carousel-half-full-width-right nav-bottom nav-bottom-align-left nav-lg nav-transparent nav-borders-light nav-arrow-light rounded-nav mb-2"
                                data-plugin-options="{'responsive': {'0': {'items': 1}, '768': {'items': 3}, '992': {'items': 4}, '1200': {'items': 5}}, 'loop': true, 'nav': true, 'dots': false, 'margin': 20}">

                                @if (isset($employees) && $employees && $employees->isNotEmpty())
                                    @foreach ($employees as $employee)
                                        <a href="{{ url('/organisasi/pegawai') }}" class="d-block text-decoration-none">
                                            <div class="box-shadow-7 border-radius-2 overflow-hidden" style="cursor: pointer;">
                                                <span class="thumb-info thumb-info-no-overlay thumb-info-show-hidden-content-hover">
                                                    <span class="thumb-info-wrapper overlay overlay-show overlay-gradient-bottom-content border-radius-0 rounded-top">
                                                        @if($employee->getFirstMediaUrl('photo'))
                                                            <img src="{{ $employee->getFirstMediaUrl('photo') }}"
                                                                loading="lazy" class="img-fluid" alt="{{ $employee->name }}"
                                                                style="aspect-ratio: 3/4; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                                 style="aspect-ratio: 3/4;">
                                                                <i class="fas fa-user fa-4x text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </span>
                                                    <span class="thumb-info-content">
                                                        <span class="thumb-info-content-inner bg-light p-4">
                                                            <h4 class="text-5 mb-2">{{ Str::limit($employee->name, 25) }}</h4>
                                                            @if($employee->position)
                                                                <p class="line-height-7 text-3 mb-0">{{ Str::limit($employee->position, 50) }}</p>
                                                            @endif
                                                            @if($employee->employment_status)
                                                                <span class="badge mt-2
                                                                    @if($employee->employment_status === 'PNS') bg-success
                                                                    @elseif($employee->employment_status === 'PPPK') bg-info
                                                                    @elseif($employee->employment_status === 'Honorer') bg-warning
                                                                    @else bg-secondary
                                                                    @endif" style="font-size: 0.7rem;">
                                                                    {{ $employee->employment_status }}
                                                                </span>
                                                            @endif
                                                            <span class="thumb-info-content-inner-hidden p-absolute d-block w-100 py-3">
                                                                <span class="text-uppercase text-color-secondary text-color-hover-primary font-weight-semibold text-decoration-underline">
                                                                    Lihat Semua Pegawai
                                                                </span>
                                                                <span class="btn btn-light btn-rounded box-shadow-7 btn-xl border-0 text-3 p-0 btn-with-arrow-solid p-absolute right-0 transform3dx-n100 bottom-7">
                                                                    <span class="p-static bg-transparent transform-none">
                                                                        <i class="fa-solid fa-arrow-right text-dark"></i>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="box-shadow-7 border-radius-2 overflow-hidden">
                                        <div class="text-center py-5 bg-light">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum Ada Data Pegawai</h5>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .featured-box {
            background: #FFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease;
        }

        .featured-box:hover {
            transform: translateY(-3px);
        }

        .box-content {
            padding: 20px;
            min-height: 220px;
            display: flex;
            flex-direction: column;
        }

        h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .item-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
            justify-content: space-around;
        }

        .date {
            font-size: 0.85rem;
            color: #666;
        }

        .btn-danger {
            background-color: #ff0000;
            border-color: #ff0000;
        }

        .owl-nav button {
            width: 30px !important;
            height: 30px !important;
            background: rgba(255, 255, 255, 0.7) !important;
            border-radius: 50% !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .owl-nav button span {
            color: #333;
        }
    </style>
    <style>
        .large-image-frame {
            display: block;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 380px;
        }

        .small-image-frame {
            display: block;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 100px;
            max-width: 200px;
        }

        .large-image-frame img,
        .small-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Hover effects only for large image */
        .large-image-frame img {
            transition: all 0.3s ease;
        }

        .large-image-frame:hover img {
            transform: scale(1.1);
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(239, 13, 13, 0.9), transparent);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .large-image-frame:hover .image-overlay {
            opacity: 1;
        }

        .overlay-content {
            position: relative;
            z-index: 2;
        }

        .overlay-content .date {
            font-size: 0.8rem;
            display: block;
            margin-bottom: 1px;
            color: #fff;
        }

        .overlay-content h4 {
            font-size: 1.2rem;
            margin: 0;
            color: #fff;
            font-weight: bold;
        }

        .large-image-frame a {
            text-decoration: none;
            display: block;
            height: 100%;
        }
    </style>

    {{-- Detail Modal for Media Preview --}}
    @if($detailMedia)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.7);" wire:click.self="closeMediaDetail">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                    {{-- Modal Header with Gradient --}}
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; padding: 1.5rem;">
                        <div>
                            <h5 class="modal-title fw-bold mb-1" style="color: white;">
                                <i class="fas fa-file-alt me-2"></i>
                                {{ $detailMedia->getCustomProperty('title') ?? $detailMedia->name }}
                            </h5>
                            <small style="color: rgba(255,255,255,0.9);">
                                <i class="far fa-calendar me-1"></i>
                                {{ $detailMedia->created_at->format('d F Y, H:i') }} WIB
                            </small>
                        </div>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeMediaDetail"></button>
                    </div>
                    <div class="modal-body px-4 pt-4 pb-3">
                        {{-- Preview Content --}}
                        @if($detailMedia->mime_type === 'application/pdf')
                            {{-- PDF Preview --}}
                            <div class="text-center mb-3">
                                <iframe
                                    src="{{ $detailMedia->getUrl() }}"
                                    class="w-100 shadow"
                                    style="height: 70vh; border: none; border-radius: 0.75rem; border: 4px solid #05AC69;">
                                </iframe>
                            </div>
                        @elseif(str_starts_with($detailMedia->mime_type, 'image/'))
                            {{-- Image Preview --}}
                            <div class="text-center mb-3">
                                <img
                                    src="{{ $detailMedia->getUrl() }}"
                                    alt="{{ $detailMedia->name }}"
                                    class="img-fluid shadow"
                                    style="max-height: 70vh; border-radius: 0.75rem; border: 4px solid #05AC69;">
                            </div>
                        @else
                            {{-- Other File Types --}}
                            <div class="text-center py-5">
                                <i class="far fa-file fa-4x mb-3" style="color: #05AC69; opacity: 0.3;"></i>
                                <p class="text-muted">Preview tidak tersedia untuk tipe file ini.</p>
                            </div>
                        @endif

                        {{-- Description --}}
                        @if($detailMedia->getCustomProperty('description'))
                            <div class="mb-3 mt-4">
                                <h6 class="fw-bold mb-2">
                                    <i class="fas fa-info-circle me-2" style="color: #05AC69;"></i>
                                    Deskripsi
                                </h6>
                                <div class="text-dark" style="font-size: 0.9rem; line-height: 1.6;">
                                    {{ $detailMedia->getCustomProperty('description') }}
                                </div>
                            </div>
                        @endif

                        {{-- File Info --}}
                        <div class="mt-3 pt-3 border-top">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-file-alt me-2" style="color: #05AC69;"></i>
                                Informasi File
                            </h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-file me-1"></i>Nama File</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ $detailMedia->file_name }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-file-code me-1"></i>Tipe</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ strtoupper($detailMedia->extension ?? 'N/A') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-weight-hanging me-1"></i>Ukuran</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ $this->formatBytes($detailMedia->size) }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-calendar me-1"></i>Tanggal Upload</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ $detailMedia->created_at->format('d F Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 bg-light">
                        <a href="{{ $detailMedia->getUrl() }}" download="{{ $detailMedia->file_name }}" class="btn btn-sm" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; border: none;">
                            <i class="fas fa-download me-1"></i> Download File
                        </a>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="closeMediaDetail">
                            <i class="fas fa-times me-1"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
