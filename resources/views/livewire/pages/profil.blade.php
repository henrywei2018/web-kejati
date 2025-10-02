<div class="row px-xl-0 py-2 overflow-hidden">
    @livewire('components.header-details', [
        'title' => 'Our Team',
        'badge' => 'Meet The Experts',
        'breadcrumbs' => [['label' => 'About', 'url' => route('about')], ['label' => 'Team']],
        'image' => asset('frontend/img/waves-2.svg'),
        'backgroundClass' => 'bg-primary',
        'titleClass' => 'text-secondary text-9 text-lg-12 font-weight-bold line-height-1 mb-2',
        'badgeClass' => 'badge bg-quaternary text-light rounded-pill text-uppercase font-weight-bold text-2-5 px-4 py-2 mb-3',
    ])
    <!-- Konten Profil -->
    <div class="container" id="intro">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mt-5 mt-lg-0 py-lg-5">
                <div class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="0">
                    <span
                        class="badge bg-gradient-light-primary-rgba-20 text-secondary rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-4"><span
                            class="d-inline-flex py-1 px-2">Who We Are</span></span>
                </div>
                <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                    <h2 class="text-9 text-lg-12 font-weight-semibold line-height-1 mb-4">Your Trusted Financial
                        Partners and Advisors</h2>
                </div>
                <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                    <p class="pe-lg-5">We provide comprehensive accounting and financial services tailored to meet the
                        needs of businesses and individuals alike. We are here to help you navigate the complexities of
                        the financial world.</p>
                </div>

                <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
                    <div class="d-flex align-items-center pt-2 pb-4">
                        <p class="d-inline-block mb-0 font-weight-bold line-height-1"><mark
                                class="text-dark mark mark-pos-2 mark-height-50 mark-color bg-color-before-primary-rgba-30 font-secondary text-15 mark-height-30 n-ls-5 p-0">30+</mark>
                        </p>
                        <span class="custom-font-tertiary text-6 text-dark n-ls-1 fst-italic ps-2">Years of
                            Experience</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center p-relative py-5">
                <div class="opacity-2 p-absolute w-100">
                    <img src="img/icons/abstract-bg-1.svg" alt="" data-icon
                        data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary w-100'}" />
                </div>
                <div class="cascading-images-wrapper custom-cascading-images-wrapper-1">
                    <div class="cascading-images p-relative">
                        <div class="custom-mask-img custom-mask-img-2">
                            <img class="img-fluid" src="img/demos/accounting-1/generic/generic-2.jpg" loading="lazy"
                                alt="">
                        </div>
                        <div class="p-absolute w-100 custom-mask-img custom-mask-img-3" style="top: 21%; left: -30%;">
                            <img src="img/demos/accounting-1/generic/generic-3.jpg" loading="lazy" class="img-fluid"
                                alt="" />
                        </div>
                        <div class="p-absolute bg-color-light border-radius-2 p-3 text-3-5 n-ls-05 text-dark box-shadow-7 d-flex align-items-center"
                            style="bottom: 0%; left: -45%;">
                            <img src="img/demos/accounting-1/icons/icon-4.svg" width="26" alt="" data-icon
                                data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary me-1'}" />
                            <strong class="custom-font-secondary pe-2">Join Us</strong> | 1000+ clients globally!
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
