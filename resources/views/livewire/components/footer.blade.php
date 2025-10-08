<footer id="footer" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: #fff;">
    <div class="container">
        {{-- Footer Ribbon --}}
        <div class="footer-ribbon" style="background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);">
            <span style="color: #fff;">Kejaksaan Tinggi Kalimantan Utara</span>
        </div>

        {{-- Main Footer Content --}}
        <div class="row py-5 my-4">
            {{-- About Section --}}
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-4 mb-3 fw-bold" style="color: #D4AF37;">TENTANG KAMI</h5>
                <p class="text-white text-3 mb-3 opacity-75">
                    Kejaksaan Tinggi Kalimantan Utara adalah lembaga penegak hukum yang bertugas melakukan penuntutan dan upaya hukum lain sesuai dengan peraturan perundang-undangan.
                </p>
                <a href="{{ route('about') }}" class="btn btn-sm" style="background: #D4AF37; color: #fff; border: none;">
                    <strong>SELENGKAPNYA</strong>
                    <i class="fas fa-angle-right ms-2"></i>
                </a>
            </div>

            {{-- Quick Links --}}
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-4 mb-3 fw-bold" style="color: #D4AF37;">TAUTAN CEPAT</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-white opacity-90 text-decoration-none hover-gold">
                            <i class="fas fa-angle-right me-2" style="color: #D4AF37;"></i>Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('berita.index') }}" class="text-white opacity-90 text-decoration-none hover-gold">
                            <i class="fas fa-angle-right me-2" style="color: #D4AF37;"></i>Berita
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('gallery') }}" class="text-white opacity-90 text-decoration-none hover-gold">
                            <i class="fas fa-angle-right me-2" style="color: #D4AF37;"></i>Galeri
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('informasi.pengumuman') }}" class="text-white opacity-90 text-decoration-none hover-gold">
                            <i class="fas fa-angle-right me-2" style="color: #D4AF37;"></i>Pengumuman
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('pegawai.index') }}" class="text-white opacity-90 text-decoration-none hover-gold">
                            <i class="fas fa-angle-right me-2" style="color: #D4AF37;"></i>Pegawai
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact') }}" class="text-white opacity-90 text-decoration-none hover-gold">
                            <i class="fas fa-angle-right me-2" style="color: #D4AF37;"></i>Kontak
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact Info --}}
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                <h5 class="text-4 mb-3 fw-bold" style="color: #D4AF37;">HUBUNGI KAMI</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-map-marker-alt mt-1 me-3" style="color: #D4AF37;"></i>
                        <span class="text-3 opacity-75">
                            Jl. Jenderal Sudirman No. 1<br>
                            Tanjung Selor, Kalimantan Utara<br>
                            77212
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-phone-alt me-3" style="color: #D4AF37;"></i>
                        <a href="tel:+62551234567" class="text-white opacity-90 text-decoration-none hover-gold">
                            (0551) 234567
                        </a>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-envelope me-3" style="color: #D4AF37;"></i>
                        <a href="mailto:info@kejati-kaltara.go.id" class="text-white opacity-90 text-decoration-none hover-gold">
                            info@kejati-kaltara.go.id
                        </a>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-clock me-3" style="color: #D4AF37;"></i>
                        <span class="text-3 opacity-90">
                            Senin - Jumat: 08:00 - 16:00 WITA
                        </span>
                    </li>
                </ul>
            </div>

            {{-- Social Media --}}
            <div class="col-md-6 col-lg-3">
                <h5 class="text-4 mb-3 fw-bold" style="color: #D4AF37;">MEDIA SOSIAL</h5>
                <p class="text-white text-3 mb-3 opacity-90">
                    Ikuti kami di media sosial untuk mendapatkan informasi terkini.
                </p>
                <div class="d-flex gap-2 mb-3">
                    <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center social-btn"
                       style="width: 40px; height: 40px; background: rgba(212, 175, 55, 0.2); color: #D4AF37; border: 2px solid rgba(212, 175, 55, 0.3);"
                       title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center social-btn"
                       style="width: 40px; height: 40px; background: rgba(212, 175, 55, 0.2); color: #D4AF37; border: 2px solid rgba(212, 175, 55, 0.3);"
                       title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center social-btn"
                       style="width: 40px; height: 40px; background: rgba(212, 175, 55, 0.2); color: #D4AF37; border: 2px solid rgba(212, 175, 55, 0.3);"
                       title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center social-btn"
                       style="width: 40px; height: 40px; background: rgba(212, 175, 55, 0.2); color: #D4AF37; border: 2px solid rgba(212, 175, 55, 0.3);"
                       title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
                <p class="text-2 mb-0 opacity-90">
                    <i class="fas fa-hashtag me-1" style="color: #D4AF37;"></i>
                    <span class="badge border border-1 me-1 mb-1" style="background: rgba(255, 255, 255, 0.1); border-color: #D4AF37 !important; color: #fff;">Kejaksaan</span>
                    <span class="badge border border-1 me-1 mb-1" style="background: rgba(255, 255, 255, 0.1); border-color: #D4AF37 !important; color: #fff;">Kaltara</span>
                    <span class="badge border border-1 me-1 mb-1" style="background: rgba(255, 255, 255, 0.1); border-color: #D4AF37 !important; color: #fff;">Hukum</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-copyright py-3" style="background: rgba(0, 0, 0, 0.2); border-top: 2px solid rgba(212, 175, 55, 0.3);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 text-center text-md-start mb-2 mb-md-0">
                    <p class="text-white mb-0 text-2 opacity-90">
                        © {{ date('Y') }} <strong style="color: #D4AF37;">Kejaksaan Tinggi Kalimantan Utara</strong>.
                        All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-5 text-center text-md-end">
                    <p class="mb-0 text-2 opacity-90">
                        <a href="#" class="text-white text-decoration-none hover-gold">Privacy Policy</a>
                        <span class="mx-2" style="color: #D4AF37;">|</span>
                        <a href="#" class="text-white text-decoration-none hover-gold">Terms of Service</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        #footer .hover-gold:hover {
            opacity: 1 !important;
            color: #D4AF37 !important;
        }

        #footer a.btn:hover {
            background: #B8941F !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
        }

        #footer .social-btn:hover {
            background: #D4AF37 !important;
            color: white !important;
            transform: scale(1.1);
            border-color: #D4AF37 !important;
        }

        #footer {
            position: relative;
            margin-top: 60px;
        }

        #footer .footer-ribbon {
            position: absolute;
            top: -30px;
            right: 0;
            left: 0;
            margin: 0 auto;
            padding: 10px 30px;
            max-width: fit-content;
            border-radius: 8px 8px 0 0;
            box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.2);
        }

        #footer .footer-ribbon span {
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
        }
    </style>
</footer>
