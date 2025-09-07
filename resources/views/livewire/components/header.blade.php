<header id="header"
    data-plugin-options="{'stickyScrollUp': true, 'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': false, 'stickyStartAt': 100, 'stickyHeaderContainerHeight': 100}">
    <div class="header-body border-top-0 h-auto box-shadow-none bg-primary  ">
        <div class="container-fluid px-3 px-lg-5 p-static">
            <div class="row align-items-center py-1">
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
                                    <li>
                                        <a href="demo-accounting-1.html" class="nav-link active">
                                            Home
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="demo-accounting-1-services.html"
                                            class="nav-link dropdown-toggle">Services</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="demo-accounting-1-services.html"
                                                    class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2">Overview</a>
                                            </li>
                                            <li><a href="demo-accounting-1-services-details.html"
                                                    class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2">Accounting</a>
                                            </li>
                                            <li><a href="demo-accounting-1-services-details.html"
                                                    class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2">Tax
                                                    Planning</a></li>
                                            <li><a href="demo-accounting-1-services-details.html"
                                                    class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2">Business
                                                    Advisory</a></li>
                                            <li><a href="demo-accounting-1-services-details.html"
                                                    class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2">Payroll
                                                    Management</a></li>
                                            <li><a href="demo-accounting-1-services-details.html"
                                                    class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2">Global
                                                    Accounting</a></li>
                                            <li><a href="demo-accounting-1-services-details.html"
                                                    class="dropdown-item anim-hover-translate-right-5px transition-3ms text-lg-2 py-lg-2">Admin
                                                    Services</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="demo-accounting-1-about.html">
                                            About
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="demo-accounting-1-process.html">
                                            Process
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="demo-accounting-1-projects.html">
                                            Projects
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="demo-accounting-1-news.html">
                                            News
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="demo-accounting-1-contact.html">
                                            Contact
                                        </a>
                                    </li>
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
    .nav-pills .nav-link.active,
    .header-nav-main .nav-link.active {
        background: var(--color-secondary) !important; /* #FFD333 */
        color: var(--color-secondary-800) !important; /* Dark primary for contrast */
        font-weight: 600;
        transform: translateY(-1px);
        border-radius: 25px;
    }

    /* Active hover effect */
    .header-nav .dropdown-item.text-color-hover-primary:hover,
.dropdown-item.text-color-hover-primary:hover {
    color: var(--color-secondary-600) !important;
}

/* Ensure all nav hover uses secondary */
.header-nav-main .nav-link:hover,
.header-nav-main .dropdown-item:hover {
    color: var(--color-secondary-500) !important;
}
/* Refined fix - Only target parent nav link, not dropdown items */

/* Remove overly broad rules and target specifically */
.dropdown:hover > .nav-link.dropdown-toggle:not(.dropdown-item),
.dropdown.show > .nav-link.dropdown-toggle:not(.dropdown-item) {
    color: var(--color-secondary-500) !important;
}

/* More specific targeting - only the direct child nav-link */
.header-nav-main .dropdown:hover > a.nav-link.dropdown-toggle,
.header-nav-main .dropdown.show > a.nav-link.dropdown-toggle {
    color: var(--color-secondary-500) !important;
}

/* Target only the dropdown toggle button, not dropdown items */
.dropdown-toggle[aria-expanded="true"]:not(.dropdown-item) {
    color: var(--color-secondary-500) !important;
}

/* Ensure dropdown items keep their own hover behavior */
.dropdown-menu .dropdown-item:hover {
    color: var(--color-secondary-600) !important;
    background-color: var(--color-secondary-50) !important;
    /* Remove any inherited secondary color from parent */
}

/* Override any broad dropdown hover rules for dropdown items */
.dropdown:hover .dropdown-item:hover,
.dropdown.show .dropdown-item:hover {
    color: var(--color-secondary-600) !important; /* Specific secondary shade for items */
    background-color: var(--color-secondary-50) !important;
}

/* Prevent dropdown container hover from affecting dropdown items */
.dropdown:hover .dropdown-menu .dropdown-item:not(:hover) {
    color: inherit !important; /* Keep original color when not directly hovered */
}

/* Very specific - only target the immediate nav-link child of dropdown */
li.dropdown:hover > a.nav-link:not(.dropdown-item),
li.dropdown:focus-within > a.nav-link:not(.dropdown-item) {
    color: var(--color-secondary-500) !important;
}

/* Reset dropdown items to their normal state unless directly hovered */
.dropdown-menu .dropdown-item:hover {
    background: #ffe434 !important;
    color: var(--color-secondary) !important;
    border-radius: 8px;
    transform: translateX(5px);
    box-shadow: 0 0 20px #ffe434;
    border-left: 3px solid var(--color-secondary);
    transition: all 0.3s ease;
}

.dropdown-menu .dropdown-item:hover {
    color: var(--color-secondary-600) !important; /* Only on direct hover */
    background-color: var(--color-secondary-50) !important;
}

/* Make sure active dropdown items don't inherit parent colors */
.dropdown.show .dropdown-menu .dropdown-item,
.dropdown:hover .dropdown-menu .dropdown-item {
    color: var(--color-primary-700) !important; /* Keep default unless directly hovered */
}

.dropdown.show .dropdown-menu .dropdown-item:hover,
.dropdown:hover .dropdown-menu .dropdown-item:hover {
    color: var(--color-secondary-600) !important; /* Secondary only on direct item hover */
    background-color: var(--color-secondary-50) !important;
}
    </style>
</header>
