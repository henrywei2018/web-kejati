<header id="header"
    data-plugin-options="{'stickyScrollUp': true, 'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': false, 'stickyStartAt': 140, 'stickyHeaderContainerHeight': 100}">

    {{-- Top Bar --}}
    <div class="header-top bg-dark py-2" data-sticky-header-style="{'minResolution': 0}" data-sticky-header-style-active="{'background-color': 'transparent'}" data-sticky-header-style-deactive="{'background-color': 'rgb(25, 25, 25)'}">
        <div class="container-fluid px-3 px-lg-5">
            <div class="row align-items-center">
                <div class="col-auto d-none d-md-block">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-3">
                            <a href="tel:+6281234567890" class="text-white text-decoration-none text-2 opacity-8 opacity-hover-10 transition-opacity">
                                <i class="fas fa-phone me-2"></i>
                                <span>+62 812-3456-7890</span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="mailto:info@kejati-kaltara.go.id" class="text-white text-decoration-none text-2 opacity-8 opacity-hover-10 transition-opacity">
                                <i class="fas fa-envelope me-2"></i>
                                <span>info@kejati-kaltara.go.id</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col text-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-2">
                            <a href="#" class="text-white text-decoration-none opacity-8 opacity-hover-10 transition-opacity" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="list-inline-item me-2">
                            <a href="#" class="text-white text-decoration-none opacity-8 opacity-hover-10 transition-opacity" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item me-2">
                            <a href="#" class="text-white text-decoration-none opacity-8 opacity-hover-10 transition-opacity" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-white text-decoration-none opacity-8 opacity-hover-10 transition-opacity" target="_blank">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    <div class="header-body border-top-0 h-auto bg-white shadow-sm">
        <div class="container-fluid px-3 px-lg-5 p-static">
            <div class="row align-items-center py-3">
                <div class="col-auto col-lg-2 col-xxl-3 me-auto me-lg-0">
                    <div class="header-logo" data-clone-element-to="#offCanvasLogo">
                        <a href="demo-accounting-1.html">
                            <img alt="Porto" width="131" height="27" src="img/demos/accounting-1/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-auto col-lg-8 col-xxl-6 justify-content-lg-center">
                    <div class="header-nav header-nav-links justify-content-lg-center">
                        <div
                            class="header-nav-main header-nav-main-text-capitalize header-nav-main-arrows header-nav-main-effect-2">
                            <nav class="collapse">
                                <ul class="nav nav-pills" id="mainNav">
                                    @foreach($mainMenu as $item)
                                        @if(isset($item['children']) && count($item['children']) > 0)
                                            {{-- Menu dengan Dropdown --}}
                                            <li class="dropdown">
                                                <a href="{{ $item['url'] }}"
                                                   class="nav-link dropdown-toggle {{ $item['active'] ? 'active' : '' }}">
                                                    {{ $item['label'] }}
                                                </a>
                                                <ul class="dropdown-menu">
                                                    @foreach($item['children'] as $child)
                                                        <li>
                                                            <a href="{{ $child['url'] }}"
                                                               class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2 {{ $child['active'] ? 'active' : '' }}">
                                                                {{ $child['label'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            {{-- Menu Biasa --}}
                                            <li>
                                                <a href="{{ $item['url'] }}"
                                                   class="nav-link {{ $item['active'] ? 'active' : '' }}">
                                                    {{ $item['label'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-auto col-lg-2 col-xxl-3">
                    <div class="d-flex justify-content-end align-items-center">
                        {{-- <div class="d-none d-sm-flex d-lg-none d-xxl-flex">
                            <img src="img/icons/phone-2.svg" width="24" height="24" alt="" data-icon
                                data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary pe-1'}" />
                            <a href="tel:1234567890"
                                class="text-decoration-none font-secondary text-4 font-weight-semibold text-color-dark text-color-hover-primary transition-2ms negative-ls-05 ws-nowrap">800
                                123 4567</a>
                        </div> --}}
                        <a href="demo-accounting-1-contact.html"
                            class="btn btn-rounded btn-secondary box-shadow-7 font-weight-medium px-3 py-2 text-2-5 btn-swap-1 ms-3 d-none d-md-flex"
                            data-clone-element="1">
                            <span>Login <i class="fa-solid fa-arrow-right ms-2"></i></span>
                        </a>
                        <button class="btn header-btn-collapse-nav rounded-pill" data-bs-toggle="offcanvas"
                            href="#offcanvasMain" role="button" aria-controls="offcanvasMain">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    /* ========== Modern Navigation Styles ========== */

    /* Main Navigation */
    .header-nav-main .nav-link {
        color: #1a202c !important;
        font-weight: 500;
        font-size: 15px;
        padding: 10px 18px !important;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    /* Active State - Modern with underline */
    .header-nav-main .nav-link.active {
        color: #0066cc !important;
        background: linear-gradient(135deg, rgba(0, 102, 204, 0.05) 0%, rgba(0, 102, 204, 0.1) 100%) !important;
        font-weight: 600;
    }

    .header-nav-main .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 18px;
        right: 18px;
        height: 3px;
        background: linear-gradient(90deg, #0066cc 0%, #0099ff 100%);
        border-radius: 2px;
    }

    /* Hover State */
    .header-nav-main .nav-link:hover {
        color: #0066cc !important;
        background: rgba(0, 102, 204, 0.05) !important;
        transform: translateY(-2px);
    }

    /* Dropdown Menu Modern Style */
    .dropdown-menu {
        border: none !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12) !important;
        border-radius: 12px !important;
        padding: 8px !important;
        margin-top: 8px !important;
        min-width: 220px;
    }

    .dropdown-menu .dropdown-item {
        border-radius: 8px !important;
        padding: 10px 16px !important;
        font-size: 14px !important;
        color: #4a5568 !important;
        transition: all 0.2s ease !important;
        margin-bottom: 2px;
    }

    .dropdown-menu .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(0, 102, 204, 0.08) 0%, rgba(0, 102, 204, 0.12) 100%) !important;
        color: #0066cc !important;
        transform: translateX(4px) !important;
        padding-left: 20px !important;
    }

    /* Active Dropdown Item */
    .dropdown-menu .dropdown-item.active {
        background: linear-gradient(135deg, #0066cc 0%, #0099ff 100%) !important;
        color: white !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
    }

    .dropdown-menu .dropdown-item.active:hover {
        transform: translateX(0) !important;
        padding-left: 16px !important;
    }

    /* Dropdown Arrow */
    .dropdown-toggle::after {
        transition: transform 0.3s ease;
    }

    .dropdown.show .dropdown-toggle::after {
        transform: rotate(180deg);
    }

    /* Top Bar Animations */
    .opacity-8 {
        opacity: 0.8;
    }

    .opacity-10,
    .opacity-hover-10:hover {
        opacity: 1;
    }

    .transition-opacity {
        transition: opacity 0.3s ease;
    }

    /* Mobile Menu Button */
    .header-btn-collapse-nav {
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        color: #2d3748;
        padding: 10px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .header-btn-collapse-nav:hover {
        background: #0066cc;
        color: white;
        border-color: #0066cc;
    }

    /* Search/Action Button */
    .btn-rounded.btn-secondary {
        background: linear-gradient(135deg, #0066cc 0%, #0099ff 100%) !important;
        border: none !important;
        color: white !important;
        font-weight: 500 !important;
        padding: 10px 24px !important;
        border-radius: 50px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3) !important;
    }

    .btn-rounded.btn-secondary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4) !important;
    }

    /* Smooth transitions */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* ========== Responsive Styles ========== */
    @media (max-width: 991px) {
        /* Hide top bar on mobile */
        .header-top {
            display: none;
        }

        /* Adjust main nav spacing */
        .header-body {
            padding: 0.75rem 0;
        }

        .header-nav-main .nav-link {
            padding: 12px 16px !important;
        }
    }

    @media (max-width: 767px) {
        /* Stack logo and menu button */
        .header-logo img {
            max-width: 100px;
        }
    }

    /* Sticky Header Enhancement */
    .header-nav-main.sticky {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    /* Print-friendly */
    @media print {
        .header-top,
        .header-btn-collapse-nav,
        .btn-rounded {
            display: none !important;
        }
    }
    </style>
</header>
