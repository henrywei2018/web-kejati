<footer id="footer" class="mt-0 border-top-0 bg-color-dark">
    <div class="container py-5">
        <div class="row py-4">
            <!-- Logo and Description -->
            <div class="col-sm-6 col-lg-3">
                <div class="pb-2">
                    <img alt="Porto" width="131" height="27" src="{{ asset('frontend/img/demos/accounting-1/logo-light.png') }}">
                </div>
                <p class="text-3-5 text-color-grey mb-4">
                    Professional accounting services to help your business thrive and grow.
                </p>
                <ul class="social-icons social-icons-clean social-icons-lg">
                    <li class="social-icons-instagram">
                        <a href="#" target="_blank" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li class="social-icons-twitter">
                        <a href="#" target="_blank" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="social-icons-facebook">
                        <a href="#" target="_blank" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="social-icons-linkedin">
                        <a href="#" target="_blank" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Quick Links -->
            <div class="col-sm-6 col-lg-3 pt-4 pt-sm-0">
                <h4 class="text-color-dark font-weight-bold mb-3">Quick Links</h4>
                <ul class="list list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-color-grey text-color-hover-primary">Home</a></li>
                    <li><a href="{{ route('services') }}" class="text-color-grey text-color-hover-primary">Services</a></li>
                    <li><a href="{{ route('about') }}" class="text-color-grey text-color-hover-primary">About</a></li>
                    <li><a href="{{ route('process') }}" class="text-color-grey text-color-hover-primary">Process</a></li>
                    <li><a href="{{ route('projects') }}" class="text-color-grey text-color-hover-primary">Projects</a></li>
                    <li><a href="{{ route('news') }}" class="text-color-grey text-color-hover-primary">News</a></li>
                    <li><a href="{{ route('contact') }}" class="text-color-grey text-color-hover-primary">Contact</a></li>
                </ul>
            </div>
            
            <!-- Services -->
            <div class="col-sm-6 col-lg-3 pt-4 pt-lg-0">
                <h4 class="text-color-dark font-weight-bold mb-3">Services</h4>
                <ul class="list list-unstyled">
                    <li><a href="{{ route('services.accounting') }}" class="text-color-grey text-color-hover-primary">Accounting</a></li>
                    <li><a href="{{ route('services.tax-planning') }}" class="text-color-grey text-color-hover-primary">Tax Planning</a></li>
                    <li><a href="{{ route('services.business-advisory') }}" class="text-color-grey text-color-hover-primary">Business Advisory</a></li>
                    <li><a href="{{ route('services.payroll') }}" class="text-color-grey text-color-hover-primary">Payroll Management</a></li>
                    <li><a href="{{ route('services.global-accounting') }}" class="text-color-grey text-color-hover-primary">Global Accounting</a></li>
                    <li><a href="{{ route('services.admin') }}" class="text-color-grey text-color-hover-primary">Admin Services</a></li>
                </ul>
            </div>
            
            <!-- Newsletter -->
            <div class="col-lg-3 pt-4 pt-lg-0">
                <h4 class="text-color-dark font-weight-bold mb-3">Newsletter</h4>
                <p class="text-3-5 text-color-grey">Want to receive news and updates? Enter your email.</p>
                
                @if($newsletterMessage)
                    <div class="alert alert-{{ $newsletterStatus == 'success' ? 'success' : 'danger' }}">
                        @if($newsletterStatus == 'success')
                            <strong>Success!</strong> {{ $newsletterMessage }}
                        @else
                            {{ $newsletterMessage }}
                        @endif
                    </div>
                @endif
                
                <form wire:submit.prevent="subscribeNewsletter" class="mb-0">
                    <div class="row">
                        <div class="form-group col">
                            <div class="position-relative">
                                <i class="icons icon-envelope text-color-grey bg-light text-3-5 position-absolute right-15 top-50pct transform3dy-n50"></i>
                                <input type="email" 
                                       wire:model="email" 
                                       placeholder="Enter your e-mail" 
                                       class="form-control form-control-icon text-3 h-auto border-width-2 border-radius-2 border-color-grey-200 py-2 @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <button type="submit" 
                                    class="btn btn-rounded btn-dark box-shadow-7 font-weight-medium px-3 py-2 text-2-5 btn-swap-1" 
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>Submit <i class="fa-solid fa-arrow-right ms-2"></i></span>
                                <span wire:loading>Submitting...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Copyright -->
    <div class="footer-copyright bg-transparent pb-5">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-lg-6 text-center text-lg-start py-3">
                    <p class="text-3 mb-0 opacity-6">© {{ date('Y') }} Porto is Proudly Powered by <a href="http://www.okler.net/" target="_blank" class="text-decoration-underline text-color-secondary text-color-hover-primary">Okler</a></p>
                </div>
                <div class="col-lg-6 py-3 text-center text-lg-end">
                    <a href="#" class="text-color-grey text-color-hover-primary">Privacy Policy</a>
                    <a href="#" class="text-color-grey text-color-hover-primary ms-3">Terms of Use</a>
                </div>
            </div>
        </div>
    </div>
</footer>