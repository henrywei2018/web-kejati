<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="'Galeri Gambar'"
        :subtitle="'Dokumentasi foto kegiatan Kejaksaan Tinggi Kalimantan Utara'"
        :badge="'Galeri Foto'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Galeri', 'url' => '#'],
            ['label' => 'Gambar', 'url' => null]
        ]"
    />

    {{-- Content Section --}}
    <div class="px-4 py-5">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-9 mb-4 mb-lg-0">
                {{-- Search and Filter Section --}}
                <div class="card border-0 shadow-sm rounded mb-4">
                    <div class="card-body">
                        <div class="row align-items-center g-3">
                            {{-- Search Input --}}
                            <div class="col-12 col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control border-start-0 ps-0"
                                        placeholder="Cari gambar..."
                                        wire:model.live.debounce.500ms="search"
                                    >
                                </div>
                            </div>

                            {{-- Sort Dropdown --}}
                            <div class="col-12 col-md-5">
                                <select class="form-select" wire:model.live="sortBy">
                                    <option value="terbaru">Terbaru</option>
                                    <option value="terlama">Terlama</option>
                                    <option value="judul">Berdasarkan Judul</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Image Grid Card --}}
                <div class="card border-0 shadow rounded">
                    <div class="card-body p-4">
                        {{-- Card Header --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Galeri Gambar</h4>
                                <div class="text-end">
                                    <span class="badge bg-danger">
                                        Total: {{ $folder->getMedia($collectionName)->count() }} foto
                                    </span>
                                    @if($search)
                                        <small class="d-block text-muted mt-1">
                                            {{ $mediaItems->total() }} hasil ditemukan
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Grid Content --}}
                        @if($mediaItems->count() > 0)
                            <div class="row g-3">
                                @foreach($mediaItems as $media)
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <div class="image-card rounded overflow-hidden shadow-sm h-100 bg-white">
                                            {{-- Image Container --}}
                                            <div class="position-relative overflow-hidden image-thumbnail" style="height: 240px; background: #f5f5f5;">
                                                <img
                                                    src="{{ $media->getUrl() }}"
                                                    alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                                    class="w-100 h-100"
                                                    style="object-fit: cover; cursor: pointer;"
                                                    loading="lazy"
                                                    wire:click="showMediaDetail({{ $media->id }})"
                                                >

                                                {{-- Hover Overlay --}}
                                                <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <button
                                                        wire:click="showMediaDetail({{ $media->id }})"
                                                        class="btn btn-light rounded-circle"
                                                        style="width: 50px; height: 50px;"
                                                        title="Lihat Detail"
                                                    >
                                                        <i class="fas fa-search-plus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Content --}}
                                            <div class="px-3 pt-3 pb-2">
                                                @if(isset($media->custom_properties['category']))
                                                    <span class="badge bg-danger mb-2 small">{{ $media->custom_properties['category'] }}</span>
                                                @endif
                                                <h6 class="fw-bold mb-1 text-dark">
                                                    {{ Str::limit($media->custom_properties['title'] ?? $media->name, 50) }}
                                                </h6>
                                                @if(isset($media->custom_properties['description']))
                                                    <p class="text-muted small mb-0" style="font-size: 0.875rem;">
                                                        {{ Str::limit($media->custom_properties['description'], 80) }}
                                                    </p>
                                                @endif
                                            </div>

                                            {{-- Footer --}}
                                            <div class="px-3 pb-3 pt-1">
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="far fa-calendar me-2"></i>
                                                    <span>{{ $media->created_at->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-images fa-4x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted fs-5">
                                    {{ $search ? 'Tidak ada hasil yang ditemukan untuk "' . $search . '"' : 'Belum ada gambar tersedia saat ini.' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Pagination --}}
                @if($mediaItems->hasPages())
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            {{-- Pagination Info --}}
                            <div class="text-muted small">
                                Menampilkan {{ $mediaItems->firstItem() ?? 0 }} - {{ $mediaItems->lastItem() ?? 0 }}
                                dari {{ $mediaItems->total() }} foto
                            </div>

                            {{-- Pagination Links --}}
                            <div>
                                {{ $mediaItems->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-3">
                {{-- Folder Info Widget --}}
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h4><i class="fas fa-images me-2"></i>Galeri Foto</h4>
                    </div>
                    <div class="widget-body">
                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-camera me-2"></i>Total Foto</span>
                                <span class="info-value">{{ $folder->getMedia($collectionName)->count() }}</span>
                            </div>
                            @if($folder->description)
                                <div class="mt-3">
                                    <p class="text-muted small mb-0">{{ $folder->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Quick Stats Widget --}}
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h4><i class="fas fa-chart-bar me-2"></i>Statistik</h4>
                    </div>
                    <div class="widget-body">
                        @php
                            $allMedia = $folder->getMedia($collectionName);
                            $today = $allMedia->filter(fn($m) => $m->created_at->isToday())->count();
                            $thisWeek = $allMedia->filter(fn($m) => $m->created_at->isCurrentWeek())->count();
                            $thisMonth = $allMedia->filter(fn($m) => $m->created_at->isCurrentMonth())->count();
                            $total = $allMedia->count();
                        @endphp

                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar-day me-2"></i>Hari Ini</span>
                                <span class="info-value">{{ $today }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar-week me-2"></i>Minggu Ini</span>
                                <span class="info-value">{{ $thisWeek }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar-alt me-2"></i>Bulan Ini</span>
                                <span class="info-value">{{ $thisMonth }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Latest Images Widget --}}
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h4><i class="fas fa-clock me-2"></i>Foto Terbaru</h4>
                    </div>
                    <div class="widget-body">
                        @php
                            $latestItems = $folder->getMedia($collectionName)->sortByDesc('created_at')->take(5);
                        @endphp

                        @forelse($latestItems as $item)
                            <a href="javascript:void(0)" wire:click="showMediaDetail({{ $item->id }})" class="news-item">
                                <div class="news-thumbnail">
                                    <img src="{{ $item->getUrl() }}" alt="{{ $item->custom_properties['title'] ?? $item->name }}">
                                </div>
                                <div class="news-content">
                                    <h6 class="news-title">{{ Str::limit($item->custom_properties['title'] ?? $item->name, 45) }}</h6>
                                    <div class="news-meta">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $item->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted small mb-0">Belum ada foto tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Image Detail Modal - Modern Style --}}
    @if($detailMedia)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.7);">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                    {{-- Modal Header with Gradient --}}
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; padding: 1.5rem;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fas fa-image me-2"></i>{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeMediaDetail"></button>
                    </div>

                    <div class="modal-body p-0">
                        {{-- Image Preview Section --}}
                        <div class="position-relative" style="background: #000; padding: 2rem;">
                            <div class="text-center">
                                <img
                                    src="{{ $detailMedia->getUrl() }}"
                                    alt="{{ $detailMedia->name }}"
                                    class="img-fluid shadow-lg"
                                    style="max-height: 70vh; object-fit: contain; border-radius: 8px;"
                                >
                            </div>
                        </div>

                        {{-- Image Info Section --}}
                        <div class="px-4 py-3 bg-light border-top">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1"><i class="far fa-calendar me-1"></i>Tanggal Upload</small>
                                    <strong class="text-dark" style="font-size: 0.9rem;">{{ $detailMedia->created_at->format('d F Y') }}</strong>
                                </div>
                                @if(isset($detailMedia->custom_properties['category']))
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-tag me-1"></i>Kategori</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ $detailMedia->custom_properties['category'] }}</strong>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1"><i class="fas fa-file me-1"></i>Ukuran File</small>
                                    <strong class="text-dark" style="font-size: 0.9rem;">{{ number_format($detailMedia->size / 1024, 2) }} KB</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1"><i class="fas fa-image me-1"></i>Dimensi</small>
                                    <strong class="text-dark" style="font-size: 0.9rem;">
                                        @php
                                            $dimensions = $detailMedia->custom_properties['dimensions'] ?? null;
                                        @endphp
                                        {{ $dimensions ? $dimensions['width'] . ' x ' . $dimensions['height'] . ' px' : 'N/A' }}
                                    </strong>
                                </div>
                            </div>
                        </div>

                        {{-- Description Section --}}
                        @if(isset($detailMedia->custom_properties['description']))
                            <div class="px-4 pt-3 pb-3">
                                <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-2" style="color: #05AC69;"></i>Deskripsi</h6>
                                <p class="text-dark mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                                    {{ $detailMedia->custom_properties['description'] }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Modal Footer --}}
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="closeMediaDetail">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                        <a href="{{ $detailMedia->getUrl() }}" download="{{ $detailMedia->file_name }}" class="btn btn-sm text-white" style="background: #05AC69;">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
    <style>
        /* Image Card Styles */
        .image-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
        }

        .image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
        }

        .image-thumbnail {
            position: relative;
            overflow: hidden;
        }

        .image-overlay {
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-card:hover .image-overlay {
            opacity: 1;
        }

        .image-overlay .btn {
            transform: scale(0.8);
            transition: all 0.3s ease;
        }

        .image-card:hover .image-overlay .btn {
            transform: scale(1);
        }

        .image-overlay .btn:hover {
            transform: scale(1.1) !important;
        }

        .list-group-item {
            transition: background-color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .rounded {
            border-radius: 0.5rem !important;
        }

        /* Modal Image Zoom */
        .modal-body img {
            transition: transform 0.3s ease;
        }
    </style>
    @endpush
</div>
