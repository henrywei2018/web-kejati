<div class="row px-xl-0 py-2 overflow-hidden">
    @livewire('components.header-details', [
        'title' => 'Our Team',
        'badge' => 'Meet The Experts',
        'breadcrumbs' => [
            ['label' => 'About', 'url' => route('about')],
            ['label' => 'Team']
        ],
        'image' => asset('frontend/img/waves-2.svg'),
        'backgroundClass' => 'bg-primary',
        'titleClass' => 'text-secondary text-9 text-lg-12 font-weight-bold line-height-1 mb-2',
        'badgeClass' => 'badge bg-quaternary text-light rounded-pill text-uppercase font-weight-bold text-2-5 px-4 py-2 mb-3'
    ])
    <div class="container pb-5 pt-lg-5 mt-5">
        <div class="row">
            <div class="col-lg-4 order-1 order-lg-0 pe-lg-5 mt-4 mt-lg-0">
                <div class="bg-grey-100 p-4 border-radius-2 mb-4">
                    <div class="m-3">
                        <h4 class="text-5 font-weight-semibold line-height-1 mb-4">Our Services</h4>

                        <ul class="nav nav-list nav-list-arrows flex-column mb-0">
                            <li class="nav-item"><a href="demo-accounting-1-services-details.html"
                                    class="nav-link active text-dark">Accounting</a></li>
                            <li class="nav-item"><a href="demo-accounting-1-services-details.html" class="nav-link">Tax
                                    Planning</a></li>
                            <li class="nav-item"><a href="demo-accounting-1-services-details.html"
                                    class="nav-link">Business
                                    Advisory</a></li>
                            <li class="nav-item"><a href="demo-accounting-1-services-details.html"
                                    class="nav-link">Payroll
                                    Management</a></li>
                            <li class="nav-item"><a href="demo-accounting-1-services-details.html"
                                    class="nav-link">Global
                                    Accounting</a></li>
                            <li class="nav-item"><a href="demo-accounting-1-services-details.html"
                                    class="nav-link">Admin
                                    Services</a></li>
                        </ul>

                    </div>
                </div>

                <div class="bg-tertiary text-light p-4 border-radius-2 mb-4">
                    <div class="m-3">
                        <h4 class="text-5 font-weight-semibold line-height-1 mb-4 text-light">Our Specialist</h4>

                        <div class="border-radius-2 overflow-hidden">
                            <span class="thumb-info thumb-info-no-overlay thumb-info-show-hidden-content-hover">
                                <span class="thumb-info-wrapper border-radius-0 rounded-top">
                                    <img src="img/demos/accounting-1/team/team-3.jpg" loading="lazy" class="img-fluid"
                                        alt="">
                                </span>
                                <span class="thumb-info-content">
                                    <span class="thumb-info-content-inner bg-light p-4">
                                        <h4 class="text-5 mb-1">Laura Mitchell</h4>
                                        <p class="line-height-7 text-3 mb-0">CEO &amp; Founder</p>
                                        <span class="thumb-info-content-inner-hidden p-absolute d-block w-100 py-3">
                                            <ul class="social-icons social-icons-clean social-icons-medium">
                                                <li class="social-icons-instagram">
                                                    <a href="http://www.instagram.com/" target="_blank"
                                                        title="Instagram">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                </li>
                                                <li class="social-icons-x">
                                                    <a href="http://www.x.com/" target="_blank" title="X">
                                                        <i class="fab fa-x-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="social-icons-facebook">
                                                    <a href="http://www.facebook.com/" target="_blank" title="Facebook">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </div>

                        <div class="d-flex flex-column pt-4">
                            <div class="pe-4">
                                <div class="feature-box feature-box-secondary align-items-center">
                                    <div class="feature-box-icon feature-box-icon-lg p-static box-shadow-7">
                                        <img src="img/icons/phone-2.svg" width="30" height="30" alt=""
                                            data-icon
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <p>We provide comprehensive accounting services tailored to meet the unique needs of each client. Our
                    team
                    of experienced accountants is dedicated to helping businesses of all sizes manage their financial
                    health
                    and achieve their financial goals.</p>

                <div class="row mt-5">
                    <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
                        <h2 class="text-7 font-weight-semibold line-height-1 mb-4">What We Do</h2>
                        <p>We offer a full range of accounting services designed to provide you with accurate financial
                            data, insightful analysis, and strategic advice.</p>
                        <ul class="list list-icons list-icons-lg list-icons-style-3 text-3-5">
                            <li><i class="fas fa-check bg-color-dark-rgba-10 text-color-before-secondary"></i> Financial
                                Statement Preparation</li>
                            <li><i class="fas fa-check bg-color-dark-rgba-10 text-color-before-secondary"></i>
                                Bookkeeping
                                Services</li>
                            <li><i class="fas fa-check bg-color-dark-rgba-10 text-color-before-secondary"></i> Payroll
                                Services</li>
                            <li><i class="fas fa-check bg-color-dark-rgba-10 text-color-before-secondary"></i> Tax
                                Preparation and Planning</li>
                            <li><i class="fas fa-check bg-color-dark-rgba-10 text-color-before-secondary"></i> Budgeting
                                and
                                Forecasting</li>
                            <li><i class="fas fa-check bg-color-dark-rgba-10 text-color-before-secondary"></i> Audit and
                                Assurance</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img class="img-fluid border-radius-2 mb-2" src="img/demos/accounting-1/generic/generic-9.jpg"
                            alt="">

                        <div class="appear-animation mt-2 animated blurIn appear-animation-visible"
                            data-appear-animation="blurIn" data-appear-animation-delay="300"
                            style="animation-delay: 300ms;">
                            <div class="d-flex align-items-center pt-4">
                                <strong class="d-inline-flex text-12 text-dark n-ls-5">90%</strong>
                                <div class="p-2 ps-3">
                                    <div class="animated-icon animated fadeIn svg-fill-color-primary"><svg
                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 5 24 14"
                                            id="icon_221725475921235" data-filename="icon-6.svg" width="48"
                                            height="48">
                                            <clipPath id="clip0_246_1849">
                                                <path d="m0 0h24v24h-24z"></path>
                                            </clipPath>
                                            <g clip-path="url(#clip0_246_1849)" clip-rule="evenodd" fill="rgb(0,0,0)"
                                                fill-rule="evenodd">
                                                <path
                                                    d="m23.7071 5.29289c.3905.39053.3905 1.02369 0 1.41422l-9.5 9.49999c-.3905.3905-1.0237.3905-1.4142 0l-4.2929-4.2929-6.79289 6.7929c-.39053.3905-1.023693.3905-1.414217 0-.3905241-.3905-.3905241-1.0237 0-1.4142l7.499997-7.50001c.39053-.39052 1.02369-.39052 1.41422 0l4.29289 4.29291 8.7929-8.79291c.3905-.39052 1.0237-.39052 1.4142 0z">
                                                </path>
                                                <path
                                                    d="m16 6c0-.55228.4477-1 1-1h6c.5523 0 1 .44772 1 1v6c0 .5523-.4477 1-1 1s-1-.4477-1-1v-5h-5c-.5523 0-1-.44772-1-1z">
                                                </path>
                                            </g>
                                        </svg></div>
                                </div>
                            </div>
                            <span class="custom-font-tertiary text-7 text-dark n-ls-1 fst-italic">Increased
                                Profitability</span>
                            <p class="mb-0 pt-2 text-3-5 line-height-7">Through strategic financial planning.</p>
                        </div>
                    </div>
                </div>

                <!-- Delivering Excellence -->
                <div class="bg-quaternary border-radius-2 mt-4 mt-lg-5 p-relative overflow-hidden">
                    <div class="container p-relative z-index-1">
                        <div class="row px-3 px-lg-5 py-5 py-lg-0 align-items-center">
                            <div class="col-lg-7">
                                <div class="appear-animation" data-appear-animation="fadeIn"
                                    data-appear-animation-delay="0">
                                    <h2 class="text-9 font-weight-semibold line-height-1 mb-4"><span
                                            class="p-relative z-index-1">Delivering Excellence Through</span> <mark
                                            class="text-dark mark mark-color mark-color-primary mark-pos-2 mark-height-100 p-0 appear-animation"
                                            data-appear-animation data-appear-animation-delay="0">Expertise</mark> and
                                        <mark
                                            class="text-dark mark mark-color mark-color-primary mark-pos-2 mark-height-100 p-0 appear-animation"
                                            data-appear-animation data-appear-animation-delay="1500">Dedication</mark>
                                    </h2>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="appear-animation" data-appear-animation="blurIn"
                                            data-appear-animation-delay="600">
                                            <div class="d-flex align-items-center pt-4">
                                                <strong class="d-inline-flex text-15 text-dark n-ls-5">70%</strong>
                                                <div class="p-2 ps-3">
                                                    <img src="img/demos/accounting-1/icons/icon-6.svg" width="48"
                                                        alt="" data-icon
                                                        data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" />
                                                </div>
                                            </div>
                                            <span class="custom-font-tertiary text-7 text-dark n-ls-1 fst-italic">Tax
                                                Savings</span>
                                            <div class="pe-lg-5">
                                                <p class="mb-0 pt-2 text-3-5 line-height-7 pe-lg-5">Saving our clients
                                                    thousands of dollars each year.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="appear-animation" data-appear-animation="fadeIn"
                                    data-appear-animation-delay="800">
                                    <img src="img/demos/accounting-1/svg/graph.svg" alt="" data-icon
                                        data-plugin-options="{'onlySVG': true, 'extraClass': 'w-100 custom-el-4'}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Why Choose Us -->
                <div class="row align-items-center mt-3 py-5">
                    <div class="col">
                        <h2 class="text-7 font-weight-semibold line-height-1 mb-4">Why Choose Us?</h2>

                        <div class="accordion accordion-modern-status accordion-modern-status-arrow accordion-modern-status-arrow-dark"
                            id="accordionWhyChooseUs">
                            <div class="card card-default box-shadow-8 border-radius-2 bg-light">
                                <div class="card-header bg-transparent" id="collapseWhyChooseUsHeadingOne">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle bg-transparent text-3-5 text-color-dark font-weight-semi-bold collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseWhyChooseUsOne"
                                            aria-expanded="false" aria-controls="collapseWhyChooseUsOne">
                                            Expert Team
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseWhyChooseUsOne" class="collapse"
                                    aria-labelledby="collapseWhyChooseUsHeadingOne"
                                    data-bs-parent="#accordionWhyChooseUs">
                                    <div class="card-body pt-0">
                                        <p class="mb-0">Our expert team of certified accountants brings years of
                                            experience and deep industry knowledge to help you navigate complex
                                            financial
                                            landscapes. We’re dedicated to providing personalized, reliable, and
                                            results-driven services, ensuring your business thrives with our strategic
                                            financial guidance.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default box-shadow-8 border-radius-2 bg-light">
                                <div class="card-header bg-transparent" id="collapseWhyChooseUsHeadingTwo">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle bg-transparent text-3-5 text-color-dark font-weight-semi-bold collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseWhyChooseUsTwo"
                                            aria-expanded="false" aria-controls="collapseWhyChooseUsTwo">
                                            Personalized Approach
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseWhyChooseUsTwo" class="collapse"
                                    aria-labelledby="collapseWhyChooseUsHeadingTwo"
                                    data-bs-parent="#accordionWhyChooseUs">
                                    <div class="card-body pt-0">
                                        <p class="mb-0">Our personalized approach ensures your unique financial needs
                                            are
                                            met with tailored solutions. We take the time to understand your business,
                                            offering dedicated support and customized strategies to help you achieve
                                            your
                                            financial goals and drive long-term success.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default box-shadow-8 border-radius-2 bg-light">
                                <div class="card-header bg-transparent" id="collapseWhyChooseUsHeadingThree">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle bg-transparent text-3-5 text-color-dark font-weight-semi-bold collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseWhyChooseUsThree"
                                            aria-expanded="false" aria-controls="collapseWhyChooseUsThree">
                                            Reliable Service
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseWhyChooseUsThree" class="collapse"
                                    aria-labelledby="collapseWhyChooseUsHeadingThree"
                                    data-bs-parent="#accordionWhyChooseUs">
                                    <div class="card-body pt-0">
                                        <p class="mb-0">Our firm is committed to providing reliable service you can
                                            trust. With a focus on accuracy and attention to detail, we deliver timely,
                                            dependable financial solutions, ensuring peace of mind and helping you make
                                            informed decisions to support your business's growth and success.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default box-shadow-8 border-radius-2 bg-light">
                                <div class="card-header bg-transparent" id="collapseWhyChooseUsHeadingFour">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle bg-transparent text-3-5 text-color-dark font-weight-semi-bold collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseWhyChooseUsFour"
                                            aria-expanded="false" aria-controls="collapseWhyChooseUsThree">
                                            Client-Centric Focus
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseWhyChooseUsFour" class="collapse"
                                    aria-labelledby="collapseWhyChooseUsHeadingFour"
                                    data-bs-parent="#accordionWhyChooseUs">
                                    <div class="card-body pt-0">
                                        <p class="mb-0">Our client-centric focus means you are always our top
                                            priority.
                                            We build strong relationships by listening to your needs and providing
                                            responsive, tailored services. Your success drives our efforts, ensuring
                                            that we
                                            deliver value and exceed your expectations every step of the way.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ's -->
                <div class="row align-items-center mt-3">
                    <div class="col">
                        <h2 class="text-7 font-weight-semibold line-height-1 mb-4 pb-2">Frequently Asked Questions</h2>

                        <div class="toggle toggle-minimal toggle-faqs toggle-dark m-0" data-plugin-toggle>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">What types of businesses do you work with?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">We work with a wide range of businesses, from small startups to
                                        large
                                        corporations, across various industries. Our team is equipped to handle the
                                        unique
                                        accounting needs of any business.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">How do you charge for your services?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">Our pricing is flexible and depends on the scope of work
                                        required. We
                                        offer competitive hourly rates, flat fees for specific services, and custom
                                        packages
                                        tailored to your business’s needs.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">What accounting software do you use?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">We use industry-leading software like QuickBooks, Xero, and Sage,
                                        but
                                        we’re also proficient in a variety of other platforms. We can work with your
                                        existing system or recommend the best software for your needs.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">Can you help with tax planning and
                                    preparation?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">Yes, we provide comprehensive tax services, including tax
                                        planning,
                                        preparation, and filing. Our goal is to help you minimize your tax liabilities
                                        while
                                        ensuring full compliance with all regulations.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">How often will I receive financial
                                    reports?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">The frequency of reporting is up to you. We can provide monthly,
                                        quarterly, or annual reports, depending on your needs. Regular communication
                                        ensures
                                        that you’re always informed about your financial standing.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">Do you offer bookkeeping services?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">Absolutely. We provide full-service bookkeeping, including
                                        transaction recording, bank reconciliations, payroll processing, and more, to
                                        keep
                                        your financials in order.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">What makes your firm different from
                                    others?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">Our firm is distinguished by our personalized approach, deep
                                        industry
                                        knowledge, and commitment to building long-term relationships with our clients.
                                        We’re not just accountants—we’re your business partners.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">How do you ensure the security of my financial
                                    data?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">We take data security very seriously. Our firm uses the latest
                                        encryption technologies and follows strict protocols to protect your financial
                                        information from unauthorized access.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">Can you assist with financial forecasting and
                                    budgeting?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">Yes, we offer strategic financial planning services, including
                                        forecasting, budgeting, and cash flow analysis, to help you make informed
                                        decisions
                                        and achieve your business goals.</p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title text-4 text-dark">How do I get started with your services?</a>
                                <div class="toggle-content">
                                    <p class="mb-0">Getting started is easy! Simply contact us to schedule an initial
                                        consultation, where we’ll discuss your needs and how we can best support your
                                        business.</p>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
