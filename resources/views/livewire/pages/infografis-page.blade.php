<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="'Infografis'"
        :subtitle="'Galeri infografis Kejaksaan Tinggi Kalimantan Utara'"
        :badge="'Galeri'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Informasi', 'url' => '#'],
            ['label' => 'Infografis', 'url' => null]
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
                                        placeholder="Cari infografis..."
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

                {{-- Grid Gallery Card --}}
                <div class="card border-0 shadow rounded">
                    <div class="card-body p-4">
                        {{-- Card Header --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Galeri Infografis</h4>
                                <span class="text-muted">
                                    {{ $mediaItems->count() }} dari {{ $folder->getMedia($folder->collection)->count() }} item
                                </span>
                            </div>
                        </div>

                        {{-- Grid Content --}}
                        @if($mediaItems->count() > 0)
                            <div class="row g-4">
                                @foreach($mediaItems as $media)
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <div class="infografis-card rounded overflow-hidden shadow-sm h-100">
                                            {{-- Image Container --}}
                                            <div class="position-relative overflow-hidden" style="height: 320px;">
                                                <img
                                                    src="{{ $media->getUrl() }}"
                                                    alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                                    class="w-100 h-100"
                                                    style="object-fit: cover;"
                                                >
                                                {{-- Overlay with Actions --}}
                                                <div class="infografis-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <div class="d-flex gap-2">
                                                        <button
                                                            wire:click="showMediaDetail({{ $media->id }})"
                                                            class="btn btn-light btn-sm rounded-circle"
                                                            style="width: 45px; height: 45px;"
                                                            title="Lihat Detail"
                                                        >
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a
                                                            href="{{ $media->getUrl() }}"
                                                            download="{{ $media->file_name }}"
                                                            class="btn btn-danger btn-sm rounded-circle"
                                                            style="width: 45px; height: 45px;"
                                                            title="Download"
                                                        >
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Content --}}
                                            <div class="px-3 pt-3 pb-2 bg-white">
                                                @if(isset($media->custom_properties['description']))
                                                    <span class="badge bg-warning text-dark mb-2 small">Infografis</span>
                                                @endif
                                                <h6 class="fw-bold mb-1 text-dark">
                                                    {{ Str::limit($media->custom_properties['title'] ?? $media->name, 60) }}
                                                </h6>
                                                @if(isset($media->custom_properties['description']))
                                                    <p class="text-muted small mb-0" style="font-size: 0.875rem;">
                                                        {{ Str::limit($media->custom_properties['description'], 100) }}
                                                    </p>
                                                @endif
                                            </div>

                                            {{-- Footer --}}
                                            <div class="px-3 pb-3 pt-1 bg-white">
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
                                    {{ $search ? 'Tidak ada hasil yang ditemukan untuk "' . $search . '"' : 'Belum ada infografis tersedia saat ini.' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Pagination --}}
                @if($mediaItems->hasPages())
                    <div class="mt-4">
                        {{ $mediaItems->links() }}
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-3">
                {{-- Folder Info Widget --}}
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h4><i class="fas fa-{{ $folder->icon ?? 'chart-bar' }} me-2"></i>{{ $folder->name }}</h4>
                    </div>
                    <div class="widget-body">
                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label">Total Item</span>
                                <span class="info-value">{{ $folder->getMedia($folder->collection)->count() }}</span>
                            </div>
                            @if($folder->description)
                                <div class="mt-2">
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
                            $allMedia = $folder->getMedia($folder->collection);
                            $today = $allMedia->filter(fn($m) => $m->created_at->isToday())->count();
                            $thisWeek = $allMedia->filter(fn($m) => $m->created_at->isCurrentWeek())->count();
                            $thisMonth = $allMedia->filter(fn($m) => $m->created_at->isCurrentMonth())->count();
                            $total = $allMedia->count();
                        @endphp

                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label">Hari Ini</span>
                                <span class="info-value">{{ $today }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Minggu Ini</span>
                                <span class="info-value">{{ $thisWeek }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Bulan Ini</span>
                                <span class="info-value">{{ $thisMonth }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Total</span>
                                <span class="info-value">{{ $total }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Latest Updates Widget --}}
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h4><i class="fas fa-clock me-2"></i>Terbaru</h4>
                    </div>
                    <div class="widget-body">
                        @php
                            $latestItems = $folder->getMedia($folder->collection)->sortByDesc('created_at')->take(5);
                        @endphp

                        @forelse($latestItems as $item)
                            <div class="news-item" wire:click="showMediaDetail({{ $item->id }})" style="cursor: pointer;">
                                <div class="news-thumbnail">
                                    <img src="{{ $item->getUrl() }}" alt="{{ $item->name }}">
                                </div>
                                <div class="news-content">
                                    <h6 class="news-title">{{ Str::limit($item->custom_properties['title'] ?? $item->name, 40) }}</h6>
                                    <div class="news-meta">{{ $item->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Belum ada item tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    @if($detailMedia)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.7);" tabindex="-1" wire:click.self="closeMediaDetail">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light border-bottom-0">
                        <div>
                            <h5 class="modal-title fw-bold mb-1">{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}</h5>
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>
                                {{ $detailMedia->created_at->format('d F Y, H:i') }} WIB
                            </small>
                        </div>
                        <button type="button" class="btn-close" wire:click="closeMediaDetail"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Image Preview --}}
                        <div class="text-center mb-3">
                            <img src="{{ $detailMedia->getUrl() }}" alt="{{ $detailMedia->name }}" class="img-fluid rounded shadow-sm" style="max-height: 70vh;">
                        </div>

                        {{-- Description --}}
                        @if(isset($detailMedia->custom_properties['description']))
                            <div class="mb-3">
                                <h6 class="fw-bold mb-2">Deskripsi:</h6>
                                <p class="text-muted mb-0">{{ $detailMedia->custom_properties['description'] }}</p>
                            </div>
                        @endif

                        {{-- File Info --}}
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Informasi File:</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Nama File</small>
                                        <strong class="text-dark">{{ $detailMedia->file_name }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Tipe</small>
                                        <strong class="text-dark">{{ strtoupper($detailMedia->extension ?? 'N/A') }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Ukuran</small>
                                        <strong class="text-dark">{{ $this->formatBytes($detailMedia->size) }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Tanggal Upload</small>
                                        <strong class="text-dark">{{ $detailMedia->created_at->format('d F Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <a href="{{ $detailMedia->getUrl() }}" download="{{ $detailMedia->file_name }}" class="btn btn-danger">
                            <i class="fas fa-download me-2"></i> Download File
                        </a>
                        <button type="button" class="btn btn-secondary" wire:click="closeMediaDetail">
                            <i class="fas fa-times me-2"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
    <style>
        .object-fit-cover {
            object-fit: cover;
        }
        .cursor-pointer {
            cursor: pointer;
        }

        /* Infografis Card Styles */
        .infografis-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
        }

        .infografis-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12) !important;
        }

        .infografis-overlay {
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .infografis-card:hover .infografis-overlay {
            opacity: 1;
        }

        .infografis-overlay .btn {
            transform: scale(0.8);
            transition: all 0.3s ease;
        }

        .infografis-card:hover .infografis-overlay .btn {
            transform: scale(1);
        }

        .infografis-overlay .btn:hover {
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
    </style>
    @endpush
</div>
