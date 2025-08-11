<header id="header" data-plugin-options="{'stickyScrollUp': true, 'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': false, 'stickyStartAt': 100, 'stickyHeaderContainerHeight': 100}">
    <div class="header-body border-top-0 h-auto box-shadow-none">
        <div class="container-fluid px-3 px-lg-5 p-static">
            <div class="row align-items-center py-3">
                <!-- Logo -->
                <div class="col-auto col-lg-2 col-xxl-3 me-auto me-lg-0">
                    <div class="header-logo" data-clone-element-to="#offCanvasLogo">
                        <a href="{{ route('home') }}">
                            <img alt="Porto" width="131" height="27" src="{{ asset('frontend/img/demos/accounting-1/logo.png') }}">
                        </a>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="col-auto col-lg-8 col-xxl-6 justify-content-lg-center">
                    <div class="header-nav header-nav-links justify-content-lg-center">
                        <div class="header-nav-main header-nav-main-text-capitalize header-nav-main-arrows header-nav-main-effect-2">
                            <nav class="collapse">
                                <ul class="nav nav-pills" id="mainNav">
                                    <li>
                                        <a href="{{ route('home') }}" class="nav-link {{ $currentRoute == 'home' ? 'active' : '' }}">
                                            Home
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="{{ route('services') }}" class="nav-link dropdown-toggle {{ str_starts_with($currentRoute, 'services') ? 'active' : '' }}">Services</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('services') }}" class="dropdown-item anim-hover-translate-right-5px transition-3ms bg-transparent text-color-hover-primary text-lg-2 py-lg-2">All Services</a></li>
                                            @forelse($serviceCategories as $category)
                                            <li><a href="{{ route('services.category', $category['slug']) }}" class="dropdown-item anim-hover-translate-right-5px transition-3ms bg-transparent text-color-hover-primary text-lg-2 py-lg-2">{{ $category['name'] }} ({{ $category['posts_count'] }})</a></li>
                                            @empty
                                            <li><a href="{{ route('services') }}" class="dropdown-item anim-hover-translate-right-5px transition-3ms bg-transparent text-color-hover-primary text-lg-2 py-lg-2">View Services</a></li>
                                            @endforelse
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{ route('about') }}" class="nav-link {{ $currentRoute == 'about' ? 'active' : '' }}">
                                            About
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('process') }}" class="nav-link {{ $currentRoute == 'process' ? 'active' : '' }}">
                                            Process
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('projects') }}" class="nav-link {{ $currentRoute == 'projects' ? 'active' : '' }}">
                                            Projects
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog') }}" class="nav-link {{ $currentRoute == 'blog' ? 'active' : '' }}">
                                            Blog
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}" class="nav-link {{ $currentRoute == 'contact' ? 'active' : '' }}">
                                            Contact
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="col-auto col-lg-2 col-xxl-3 d-none d-lg-flex justify-content-end pe-0">
                    <div class="header-nav-features">
                        <div class="header-nav-feature header-nav-features-search d-inline-flex">
                            <a href="{{ route('contact') }}" class="btn btn-rounded btn-dark font-weight-bold text-3 btn-px-3 py-2 me-2">
                                Get Started
                            </a>
                        </div>
                        <div class="header-nav-feature header-nav-features-cart d-inline-flex ms-2" id="headerNavCart">
                            <a href="#" class="header-nav-features-toggle text-decoration-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMain" aria-controls="offcanvasMain">
                                <i class="fas fa-bars header-nav-top-icon text-4 text-color-dark"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <div class="col-auto d-lg-none">
                    <button class="btn header-btn-collapse-nav" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMain" aria-controls="offcanvasMain">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>