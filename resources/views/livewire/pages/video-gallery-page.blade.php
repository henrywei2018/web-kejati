<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="'Galeri Video'"
        :subtitle="'Kumpulan video kegiatan dan dokumentasi Kejaksaan Tinggi Kalimantan Utara'"
        :badge="'Multimedia'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Galeri', 'url' => '#'],
            ['label' => 'Video', 'url' => null]
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
                                        placeholder="Cari video..."
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

                {{-- Video Grid Card --}}
                <div class="card border-0 shadow rounded">
                    <div class="card-body p-4">
                        {{-- Card Header --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Galeri Video</h4>
                                <span class="text-muted">
                                    {{ $mediaItems->count() }} dari {{ $folder->getMedia($collectionName)->count() }} video
                                </span>
                            </div>
                        </div>

                        {{-- Grid Content --}}
                        @if($mediaItems->count() > 0)
                            <div class="row g-4">
                                @foreach($mediaItems as $media)
                                    @php
                                        $videoUrl = $media->custom_properties['video_url'] ?? $media->getUrl();
                                        $videoId = $this->getVideoId($videoUrl);
                                        $thumbnail = $videoId
                                            ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg"
                                            : ($media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl());
                                    @endphp

                                    <div class="col-12 col-sm-6 col-md-4">
                                        <div class="video-card rounded overflow-hidden shadow-sm h-100 bg-white">
                                            {{-- Video Thumbnail Container --}}
                                            <div class="position-relative overflow-hidden video-thumbnail" style="height: 200px;">
                                                <img
                                                    src="{{ $thumbnail }}"
                                                    alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                                    class="w-100 h-100"
                                                    style="object-fit: cover;"
                                                    loading="lazy"
                                                >
                                                {{-- Play Button Overlay --}}
                                                <div class="video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <button
                                                        wire:click="showMediaDetail({{ $media->id }})"
                                                        class="btn btn-danger rounded-circle play-button"
                                                        style="width: 60px; height: 60px;"
                                                        title="Putar Video"
                                                    >
                                                        <i class="fas fa-play ms-1"></i>
                                                    </button>
                                                </div>

                                                {{-- Duration Badge --}}
                                                @if(isset($media->custom_properties['duration']))
                                                    <div class="position-absolute bottom-0 end-0 m-2">
                                                        <span class="badge bg-dark bg-opacity-75">
                                                            {{ $this->formatDuration($media->custom_properties['duration']) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Content --}}
                                            <div class="px-3 pt-3 pb-2">
                                                <div class="d-flex align-items-start mb-2">
                                                    <span class="badge bg-danger me-2 flex-shrink-0">Video</span>
                                                    @if(isset($media->custom_properties['category']))
                                                        <span class="badge bg-secondary flex-shrink-0">{{ $media->custom_properties['category'] }}</span>
                                                    @endif
                                                </div>
                                                <h6 class="fw-bold mb-1 text-dark">
                                                    {{ Str::limit($media->custom_properties['title'] ?? $media->name, 60) }}
                                                </h6>
                                                @if(isset($media->custom_properties['description']))
                                                    <p class="text-muted small mb-0" style="font-size: 0.875rem;">
                                                        {{ Str::limit($media->custom_properties['description'], 80) }}
                                                    </p>
                                                @endif
                                            </div>

                                            {{-- Footer --}}
                                            <div class="px-3 pb-3 pt-1">
                                                <div class="d-flex align-items-center justify-content-between text-muted small">
                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-calendar me-2"></i>
                                                        <span>{{ $media->created_at->format('d M Y') }}</span>
                                                    </div>
                                                    @if(isset($media->custom_properties['views']))
                                                        <div class="d-flex align-items-center">
                                                            <i class="far fa-eye me-1"></i>
                                                            <span>{{ number_format($media->custom_properties['views']) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-video fa-4x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted fs-5">
                                    {{ $search ? 'Tidak ada hasil yang ditemukan untuk "' . $search . '"' : 'Belum ada video tersedia saat ini.' }}
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
                <div class="card border-0 shadow-sm rounded mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px; background-color: {{ $folder->color ?? '#dc3545' }};">
                                    <i class="fas fa-{{ $folder->icon ?? 'video' }} fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">Video Gallery</h5>
                                <span class="badge bg-danger">{{ $folder->getMedia($collectionName)->count() }} Video</span>
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

                {{-- Latest Videos Widget --}}
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-clock text-danger me-2"></i>
                            Video Terbaru
                        </h5>
                        @php
                            $latestItems = $folder->getMedia($collectionName)->sortByDesc('created_at')->take(5);
                        @endphp

                        <div class="list-group list-group-flush">
                            @forelse($latestItems as $item)
                                @php
                                    $videoUrl = $item->custom_properties['video_url'] ?? $item->getUrl();
                                    $videoId = $this->getVideoId($videoUrl);
                                    $thumb = $videoId
                                        ? "https://img.youtube.com/vi/{$videoId}/default.jpg"
                                        : ($item->hasGeneratedConversion('thumb') ? $item->getUrl('thumb') : $item->getUrl());
                                @endphp
                                <div class="list-group-item px-0 border-bottom" wire:click="showMediaDetail({{ $item->id }})" style="cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 position-relative">
                                            <img src="{{ $thumb }}" alt="{{ $item->name }}"
                                                 class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                            <div class="position-absolute top-50 start-50 translate-middle">
                                                <i class="fas fa-play text-white" style="font-size: 0.75rem;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 small">{{ Str::limit($item->custom_properties['title'] ?? $item->name, 40) }}</h6>
                                            <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small mb-0">Belum ada video tersedia</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Video Modal --}}
    @if($detailMedia)
        @php
            $videoUrl = $detailMedia->custom_properties['video_url'] ?? $detailMedia->getUrl();
            $videoId = $this->getVideoId($videoUrl);
        @endphp
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.8);" tabindex="-1" wire:click.self="closeMediaDetail">
            <div class="modal-dialog modal-xl modal-dialog-centered">
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
                    <div class="modal-body p-0">
                        {{-- Video Player --}}
                        @if($videoId)
                            {{-- YouTube Video --}}
                            <div class="ratio ratio-16x9">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1"
                                    title="{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif(str_starts_with($detailMedia->mime_type, 'video/'))
                            {{-- Direct Video File --}}
                            <video controls class="w-100" style="max-height: 70vh;">
                                <source src="{{ $detailMedia->getUrl() }}" type="{{ $detailMedia->mime_type }}">
                                Browser Anda tidak mendukung pemutaran video.
                            </video>
                        @else
                            {{-- Fallback --}}
                            <div class="text-center py-5 bg-light">
                                <i class="fas fa-video fa-5x text-danger mb-3"></i>
                                <h4>Video tidak dapat diputar</h4>
                                <p class="text-muted">Format video tidak didukung atau URL tidak valid</p>
                            </div>
                        @endif

                        {{-- Video Info --}}
                        <div class="p-4">
                            @if(isset($detailMedia->custom_properties['description']))
                                <div class="mb-3">
                                    <h6 class="fw-bold mb-2">Deskripsi:</h6>
                                    <p class="text-muted mb-0">{{ $detailMedia->custom_properties['description'] }}</p>
                                </div>
                            @endif

                            {{-- Video Details --}}
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Informasi Video:</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Judul</small>
                                            <strong class="text-dark">{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}</strong>
                                        </div>
                                        @if(isset($detailMedia->custom_properties['duration']))
                                            <div class="col-md-6">
                                                <small class="text-muted d-block">Durasi</small>
                                                <strong class="text-dark">{{ $this->formatDuration($detailMedia->custom_properties['duration']) }}</strong>
                                            </div>
                                        @endif
                                        @if(isset($detailMedia->custom_properties['category']))
                                            <div class="col-md-6">
                                                <small class="text-muted d-block">Kategori</small>
                                                <strong class="text-dark">{{ $detailMedia->custom_properties['category'] }}</strong>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Tanggal Upload</small>
                                            <strong class="text-dark">{{ $detailMedia->created_at->format('d F Y') }}</strong>
                                        </div>
                                        @if(isset($detailMedia->custom_properties['views']))
                                            <div class="col-md-6">
                                                <small class="text-muted d-block">Jumlah Tayangan</small>
                                                <strong class="text-dark">{{ number_format($detailMedia->custom_properties['views']) }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        @if($videoUrl)
                            <a href="{{ $videoUrl }}" target="_blank" class="btn btn-danger">
                                <i class="fas fa-external-link-alt me-2"></i> Buka di Tab Baru
                            </a>
                        @endif
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
        /* Video Card Styles */
        .video-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
        }

        .video-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .video-thumbnail {
            position: relative;
            background: #000;
        }

        .video-overlay {
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-card:hover .video-overlay {
            opacity: 1;
        }

        .play-button {
            transform: scale(0.8);
            transition: all 0.3s ease;
            font-size: 1.25rem;
        }

        .video-card:hover .play-button {
            transform: scale(1);
        }

        .play-button:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
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

        /* Modal video responsiveness */
        @media (max-width: 768px) {
            .modal-xl {
                margin: 0.5rem;
            }
        }
    </style>
    @endpush
</div>
