<header id="header"
    data-plugin-options="{'stickyScrollUp': true, 'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': false, 'stickyStartAt': 100}">

    {{-- Top Bar --}}
    <div class="header-top py-2" style="background: #1B5E20;">
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
                <div class="col-auto col-lg-2 col-xxl-2 me-auto me-lg-0">
                    <div class="header-logo" data-clone-element-to="#offCanvasLogo">
                        <a href="demo-accounting-1.html">
                            <img alt="Logo kejati-kaltara" width="40" height="38" src="{{ asset('img/logo-kejati.png') }}">
                        </a>
                    </div>
                </div>
                <div class="col-auto col-lg-8 col-xxl-8 justify-content-lg-center">
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
                                                        @if(isset($child['children']) && count($child['children']) > 0)
                                                            {{-- Nested dropdown (child with sub-children) --}}
                                                            <li class="dropdown-submenu">
                                                                <a href="{{ $child['url'] }}"
                                                                   class="dropdown-item dropdown-toggle {{ $child['active'] ? 'active' : '' }}">
                                                                    {{ $child['label'] }}
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    @foreach($child['children'] as $subChild)
                                                                        <li>
                                                                            <a href="{{ $subChild['url'] }}"
                                                                               class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2 {{ $subChild['active'] ? 'active' : '' }}">
                                                                                {{ $subChild['label'] }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            {{-- Regular child item --}}
                                                            <li>
                                                                <a href="{{ $child['url'] }}"
                                                                   class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2 {{ $child['active'] ? 'active' : '' }}">
                                                                    {{ $child['label'] }}
                                                                </a>
                                                            </li>
                                                        @endif
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
                            class="btn btn-rounded btn-secondary box-shadow-7 font-weight-medium px-2 py-1 text-2 btn-swap-1 ms-2 d-none d-lg-flex"
                            data-clone-element="1">
                            <span>Login <i class="fa-solid fa-arrow-right ms-1"></i></span>
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
    /* ========== Kejaksaan RI Navigation Styles - Enhanced ========== */

    /* Top Bar - Kejaksaan Green */
    .header-top {
        background: #1B5E20 !important;
        transition: all 0.3s ease;
    }

    .header-top a {
        transition: all 0.3s ease;
    }

    .header-top a:hover {
        color: #FDD835 !important;
    }

    /* Top bar visibility control - Override plugin behavior */
    .header-top {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        max-height: 100px !important;
        overflow: visible !important;
        transition: all 0.3s ease !important;
    }

    /* Hide top bar ONLY when header has sticky class */
    #header.sticky .header-top,
    #header.header-effect-shrink.sticky .header-top {
        max-height: 0 !important;
        opacity: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        overflow: hidden !important;
    }

    /* Ensure top bar shows when NOT sticky */
    #header:not(.sticky) .header-top,
    #header.header-effect-shrink:not(.sticky) .header-top {
        max-height: 100px !important;
        opacity: 1 !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
        overflow: visible !important;
    }

    /* Main Navigation - Compact & Professional */
    .header-nav-main .nav-link {
        color: #263238 !important;
        font-weight: 500;
        font-size: 13.5px;
        padding: 10px 14px !important;
        border-radius: 0 !important;
        transition: all 0.3s ease;
        position: relative;
        background: transparent !important;
        border-bottom: 2px solid transparent;
        white-space: nowrap;
    }

    /* Remove default nav-pills active state */
    .nav-pills .nav-link.active {
        background: transparent !important;
    }

    /* Active State - Clean Gold Underline */
    .header-nav-main .nav-link.active {
        color: #1B5E20 !important;
        font-weight: 600;
        border-bottom-color: #D4AF37 !important;
    }

    /* Hover State - Smooth Gold Underline */
    .header-nav-main .nav-link:hover:not(.active) {
        color: #1B5E20 !important;
        border-bottom-color: #FDD835 !important;
    }

    /* Dropdown Toggle - Only parent gets active state */
    .header-nav-main .dropdown .nav-link.dropdown-toggle.active {
        color: #1B5E20 !important;
        font-weight: 600;
        border-bottom-color: #D4AF37 !important;
    }

    /* Dropdown Hover - Only show underline on hover */
    .header-nav-main .dropdown:hover .nav-link.dropdown-toggle:not(.active) {
        color: #1B5E20 !important;
        border-bottom-color: #FDD835 !important;
    }

    /* Dropdown Menu - Compact Professional Style */
    .dropdown-menu {
        border: 1px solid rgba(27, 94, 32, 0.1) !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12) !important;
        border-radius: 6px !important;
        padding: 6px 8px 8px 8px !important;
        margin-top: 2px !important;
        min-width: 200px;
        max-width: 280px;
    }

    /* Extend dropdown hover area */
    .dropdown::after {
        content: '';
        position: absolute;
        bottom: -4px; /* Bridge area */
        left: 0;
        right: 0;
        height: 4px;
        background: transparent;
        pointer-events: auto;
    }

    /* Smooth dropdown appearance */
    .dropdown-menu {
        animation: fadeInDown 0.2s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-menu .dropdown-item {
        border-radius: 4px !important;
        padding: 7px 12px !important;
        font-size: 13px !important;
        color: #263238 !important;
        transition: all 0.2s ease !important;
        margin-bottom: 2px;
        font-weight: 500;
        background: transparent !important;
        white-space: normal;
        line-height: 1.4;
    }

    /* Dropdown Item Hover - Clean */
    .dropdown-menu .dropdown-item:hover {
        background: rgba(27, 94, 32, 0.06) !important;
        color: #1B5E20 !important;
        transform: translateX(2px) !important;
    }

    /* Active Dropdown Item - Compact indicator */
    .dropdown-menu .dropdown-item.active {
        background: rgba(212, 175, 55, 0.1) !important;
        color: #1B5E20 !important;
        font-weight: 600;
        position: relative;
        padding-left: 16px !important;
    }

    .dropdown-menu .dropdown-item.active::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 16px;
        background: #D4AF37;
        border-radius: 1.5px;
    }

    .dropdown-menu .dropdown-item.active:hover {
        background: rgba(212, 175, 55, 0.15) !important;
        transform: translateX(2px) !important;
    }

    /* Dropdown Arrow Animation - Compact */
    .dropdown-toggle::after {
        transition: transform 0.3s ease;
        margin-left: 6px;
        font-size: 0.7em;
    }

    .dropdown.show .dropdown-toggle::after {
        transform: rotate(180deg);
    }

    /* Multi-column dropdown for many items */
    .dropdown-menu.dropdown-menu-large {
        min-width: 400px;
        max-width: 600px;
    }

    @media (min-width: 992px) {
        /* Auto multi-column if more than 8 items */
        .dropdown-menu:has(> li:nth-child(9)) {
            column-count: 2;
            column-gap: 16px;
            min-width: 380px;
            max-width: 500px;
            padding: 8px 12px 12px 12px !important;
        }

        .dropdown-menu:has(> li:nth-child(9)) > li {
            break-inside: avoid;
            page-break-inside: avoid;
            -webkit-column-break-inside: avoid;
        }
    }

    /* Nested Dropdown (Submenu) Support */
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -8px;
        margin-left: 4px;
    }

    .dropdown-submenu .dropdown-toggle::after {
        content: "\f054"; /* FontAwesome chevron-right */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        border: none;
        margin-left: auto;
        float: right;
    }

    .dropdown-submenu:hover > .dropdown-menu {
        display: block;
    }

    .dropdown-submenu .dropdown-item.dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Mobile - Stack submenu vertically */
    @media (max-width: 991px) {
        .dropdown-submenu .dropdown-menu {
            position: static;
            margin-left: 16px;
            box-shadow: none;
            border-left: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 0 8px 8px 0;
            margin-top: 4px;
        }
    }

    /* Top Bar Animations */
    .opacity-8 {
        opacity: 0.9;
    }

    .opacity-10,
    .opacity-hover-10:hover {
        opacity: 1;
    }

    .transition-opacity {
        transition: opacity 0.3s ease;
    }

    /* Mobile Menu Button - Kejaksaan Style */
    .header-btn-collapse-nav {
        background: rgba(27, 94, 32, 0.05);
        border: 2px solid #1B5E20;
        color: #1B5E20;
        padding: 10px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .header-btn-collapse-nav:hover {
        background: #1B5E20;
        color: white;
        border-color: #1B5E20;
    }

    /* CTA Button - Compact Gold Authority */
    .btn-rounded.btn-secondary {
        background: linear-gradient(135deg, #D4AF37 0%, #FDD835 100%) !important;
        border: none !important;
        color: #263238 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        padding: 6px 16px !important;
        border-radius: 50px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 3px 10px rgba(212, 175, 55, 0.35) !important;
    }

    .btn-rounded.btn-secondary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 5px 16px rgba(212, 175, 55, 0.45) !important;
        background: #FDD835 !important;
    }

    /* Smooth transitions */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Compact Navigation Container */
    .header-nav-main .nav-pills {
        gap: 0;
        margin: 0;
    }

    .header-nav-main .nav-pills > li {
        margin: 0;
    }

    /* Reduce header body padding for more nav space */
    .header-body .py-3 {
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    /* ========== Responsive Styles ========== */
    @media (min-width: 1400px) {
        /* More breathing room on XL screens */
        .header-nav-main .nav-link {
            padding: 10px 16px !important;
        }
    }

    @media (min-width: 1200px) and (max-width: 1399px) {
        /* Tight spacing on large screens */
        .header-nav-main .nav-link {
            font-size: 13px;
            padding: 10px 12px !important;
        }
    }

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

    /* Force top bar visibility at top of page */
    .header-top.force-show {
        max-height: 100px !important;
        opacity: 1 !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
        overflow: visible !important;
    }

    .header-top.force-hide {
        max-height: 0 !important;
        opacity: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        overflow: hidden !important;
    }
    </style>

    <script>
    (function() {
        let lastScrollTop = 0;
        const header = document.getElementById('header');
        const headerTop = document.querySelector('.header-top');

        if (!header || !headerTop) return;

        function handleTopBarVisibility() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // At top of page (within 50px threshold)
            if (scrollTop <= 50) {
                headerTop.classList.remove('force-hide');
                headerTop.classList.add('force-show');
            }
            // Scrolled down
            else {
                headerTop.classList.remove('force-show');
                headerTop.classList.add('force-hide');
            }

            lastScrollTop = scrollTop;
        }

        // Initial check
        handleTopBarVisibility();

        // Listen to scroll events with throttling
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    handleTopBarVisibility();
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Also listen to Porto's sticky header events if available
        if (header.dataset.pluginOptions) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        handleTopBarVisibility();
                    }
                });
            });

            observer.observe(header, { attributes: true });
        }
    })();
    </script>
</header>
