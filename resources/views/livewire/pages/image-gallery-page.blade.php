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
    <div class="py-5">
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
                <div class="card border-0 shadow-sm rounded mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px; background-color: {{ $folder->color ?? '#dc3545' }};">
                                    <i class="fas fa-{{ $folder->icon ?? 'images' }} fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">Galeri Foto</h5>
                                <span class="badge bg-danger">{{ $folder->getMedia($collectionName)->count() }} Foto</span>
                            </div>
                        </div>
                        @if($folder->description)
                            <p class="text-muted small mb-0">{{ $folder->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Quick Stats Widget --}}
                <div class="card border-0 shadow-sm rounded mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-chart-bar text-danger me-2"></i>
                            Statistik
                        </h5>
                        @php
                            $allMedia = $folder->getMedia($collectionName);
                            $today = $allMedia->filter(fn($m) => $m->created_at->isToday())->count();
                            $thisWeek = $allMedia->filter(fn($m) => $m->created_at->isCurrentWeek())->count();
                            $thisMonth = $allMedia->filter(fn($m) => $m->created_at->isCurrentMonth())->count();
                            $total = $allMedia->count();
                        @endphp

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Hari Ini</small>
                                <small class="text-dark fw-bold">{{ $today }}</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" role="progressbar"
                                     style="width: {{ $total > 0 ? ($today / $total * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Minggu Ini</small>
                                <small class="text-dark fw-bold">{{ $thisWeek }}</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" role="progressbar"
                                     style="width: {{ $total > 0 ? ($thisWeek / $total * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Bulan Ini</small>
                                <small class="text-dark fw-bold">{{ $thisMonth }}</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" role="progressbar"
                                     style="width: {{ $total > 0 ? ($thisMonth / $total * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Latest Images Widget --}}
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-clock text-danger me-2"></i>
                            Foto Terbaru
                        </h5>
                        @php
                            $latestItems = $folder->getMedia($collectionName)->sortByDesc('created_at')->take(5);
                        @endphp

                        <div class="list-group list-group-flush">
                            @forelse($latestItems as $item)
                                <div class="list-group-item px-0 border-bottom" wire:click="showMediaDetail({{ $item->id }})" style="cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $item->getUrl() }}" alt="{{ $item->name }}"
                                                 class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 small">{{ Str::limit($item->custom_properties['title'] ?? $item->name, 40) }}</h6>
                                            <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small mb-0">Belum ada foto tersedia</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Image Detail Modal - Minimalist & Clean --}}
    @if($detailMedia)
        <div class="modal fade show modal-modern" style="display: block; background: rgba(0, 0, 0, 0.85);" tabindex="-1" wire:click.self="closeMediaDetail">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-2xl" style="background: #ffffff; border-radius: 16px; overflow: hidden;">
                    {{-- Modal Header --}}
                    <div class="modal-header border-0 px-4 pt-4 pb-3" style="background: #ffffff;">
                        <div class="flex-grow-1">
                            <h5 class="modal-title fw-bold mb-1 text-dark">{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}</h5>
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>
                                {{ $detailMedia->created_at->format('d F Y') }}
                            </small>
                        </div>
                        <button type="button" class="btn-close" wire:click="closeMediaDetail"></button>
                    </div>

                    <div class="modal-body p-0">
                        {{-- Image Preview Section --}}
                        <div class="position-relative" style="background: #05AC69; padding: 3rem 2rem;">
                            <div class="text-center">
                                <img
                                    src="{{ $detailMedia->getUrl() }}"
                                    alt="{{ $detailMedia->name }}"
                                    class="img-fluid shadow-lg"
                                    style="max-height: 70vh; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);"
                                >
                            </div>
                        </div>

                        {{-- Description Section --}}
                        @if(isset($detailMedia->custom_properties['description']))
                            <div class="px-4 pt-4 pb-3">
                                <p class="text-black mb-0 lh-lg" style="font-size: 0.95rem;">
                                    {{ $detailMedia->custom_properties['description'] }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Modal Footer --}}
                    <div class="modal-footer border-0 px-4 pb-4 pt-2" style="background: #ffffff;">
                        <button type="button" class="btn btn-light px-4 py-2" wire:click="closeMediaDetail">
                            <i class="fas fa-times me-2"></i>
                            Tutup
                        </button>
                        <a href="{{ $detailMedia->getUrl() }}" download="{{ $detailMedia->file_name }}" class="btn px-4 py-2 text-white" style="background: #05AC69;">
                            <i class="fas fa-download me-2"></i>
                            Download
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
