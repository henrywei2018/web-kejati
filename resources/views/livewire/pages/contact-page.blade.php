<div>
    {{-- Header Breadcrumb --}}
    <livewire:components.header-details
        title="Hubungi Kami"
        badge="Kontak"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Hubungi Kami']
        ]"
    />

    {{-- Main Content --}}
    <section class="section bg-light position-relative border-0 m-0 p-0">
        <div class="container py-4">
            {{-- Success Message --}}
            @if($showSuccessMessage)
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2" style="font-size: 1.5rem; color: #05AC69;"></i>
                        <div>
                            <h5 class="mb-1">Pesan Berhasil Dikirim!</h5>
                            <p class="mb-0">Terima kasih telah menghubungi kami. Kami akan segera membalas pesan Anda.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" wire:click="closeSuccessMessage"></button>
                </div>
            @endif

            <div class="row g-4">
                {{-- Contact Information Column --}}
                <div class="col-lg-4">
                    {{-- Contact Info Widget --}}
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <h4><i class="fas fa-map-marker-alt me-2"></i>Informasi Kontak</h4>
                        </div>
                        <div class="widget-body">
                            {{-- Address --}}
                            <div class="contact-info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-building fa-lg" style="color: #05AC69;"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Alamat</h6>
                                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                            Jl. Jenderal Sudirman No. 1<br>
                                            Tanjung Selor, Kalimantan Utara<br>
                                            77212
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="contact-info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-phone fa-lg" style="color: #05AC69;"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Telepon</h6>
                                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                            <a href="tel:+62551234567" style="color: #05AC69;">(0551) 234567</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="contact-info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-envelope fa-lg" style="color: #05AC69;"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Email</h6>
                                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                            <a href="mailto:info@kejati-kaltara.go.id" style="color: #05AC69;">info@kejati-kaltara.go.id</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Working Hours --}}
                            <div class="contact-info-item">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-clock fa-lg" style="color: #05AC69;"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Jam Kerja</h6>
                                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                            Senin - Jumat: 08:00 - 16:00 WITA<br>
                                            Sabtu - Minggu: Tutup
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media Widget --}}
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <h4><i class="fas fa-share-alt me-2"></i>Media Sosial</h4>
                        </div>
                        <div class="widget-body">
                            <div class="d-flex flex-column gap-2">
                                <a href="#" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                    <i class="fab fa-facebook fa-lg me-2"></i>
                                    <span>Facebook</span>
                                </a>
                                <a href="#" class="btn btn-outline-info btn-sm d-flex align-items-center">
                                    <i class="fab fa-twitter fa-lg me-2"></i>
                                    <span>Twitter</span>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                                    <i class="fab fa-instagram fa-lg me-2"></i>
                                    <span>Instagram</span>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                                    <i class="fab fa-youtube fa-lg me-2"></i>
                                    <span>YouTube</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Form Column --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); padding: 1.5rem;">
                            <h4 class="text-white mb-0">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <form wire:submit.prevent="submit">
                                <div class="row g-3">
                                    {{-- First Name --}}
                                    <div class="col-md-6">
                                        <label for="firstname" class="form-label fw-semibold">
                                            Nama Depan <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control @error('firstname') is-invalid @enderror"
                                            id="firstname"
                                            wire:model="firstname"
                                            placeholder="Masukkan nama depan Anda">
                                        @error('firstname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Last Name --}}
                                    <div class="col-md-6">
                                        <label for="lastname" class="form-label fw-semibold">
                                            Nama Belakang <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control @error('lastname') is-invalid @enderror"
                                            id="lastname"
                                            wire:model="lastname"
                                            placeholder="Masukkan nama belakang Anda">
                                        @error('lastname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="email"
                                            wire:model="email"
                                            placeholder="nama@email.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">
                                            Nomor Telepon <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="tel"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            id="phone"
                                            wire:model="phone"
                                            placeholder="08xxxxxxxxxx">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Company --}}
                                    <div class="col-12">
                                        <label for="company" class="form-label fw-semibold">
                                            Instansi/Perusahaan <span class="text-muted">(Opsional)</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control @error('company') is-invalid @enderror"
                                            id="company"
                                            wire:model="company"
                                            placeholder="Nama instansi atau perusahaan Anda">
                                        @error('company')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Subject --}}
                                    <div class="col-12">
                                        <label for="subject" class="form-label fw-semibold">
                                            Subjek <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control @error('subject') is-invalid @enderror"
                                            id="subject"
                                            wire:model="subject"
                                            placeholder="Masukkan subjek pesan">
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Message --}}
                                    <div class="col-12">
                                        <label for="message" class="form-label fw-semibold">
                                            Pesan <span class="text-danger">*</span>
                                        </label>
                                        <textarea
                                            class="form-control @error('message') is-invalid @enderror"
                                            id="message"
                                            wire:model="message"
                                            rows="5"
                                            placeholder="Tulis pesan Anda di sini..."></textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="col-12">
                                        <button
                                            type="submit"
                                            class="btn text-white px-4 py-2"
                                            style="background: #05AC69;"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove>
                                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                            </span>
                                            <span wire:loading>
                                                <i class="fas fa-spinner fa-spin me-2"></i>Mengirim...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Map Section --}}
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header border-0 bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marked-alt me-2" style="color: #05AC69;"></i>Lokasi Kami
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div style="height: 400px; background: #e9ecef; position: relative;">
                                {{-- Google Maps Embed --}}
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.817395896789!2d117.37284!3d2.83696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMsKwNTAnMTMuMSJOIDExN8KwMjInMjIuMiJF!5e0!3m2!1sid!2sid!4v1234567890"
                                    width="100%"
                                    height="400"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #05AC69;
            box-shadow: 0 0 0 0.2rem rgba(5, 172, 105, 0.25);
        }

        .btn-outline-primary:hover {
            background-color: #05AC69;
            border-color: #05AC69;
        }

        .contact-info-item {
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .contact-info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
    </style>
</div>
