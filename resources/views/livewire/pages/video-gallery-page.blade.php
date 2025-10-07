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
                                <div class="text-end">
                                    <span class="badge bg-danger">
                                        Total: {{ $folder->getMedia($collectionName)->count() }} video
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
                            <div class="row g-4">
                                @foreach($mediaItems as $media)
                                    @php
                                        // Check for YouTube URL
                                        $videoUrl = $media->custom_properties['video_url'] ?? null;
                                        $videoId = $videoUrl ? $this->getVideoId($videoUrl) : null;
                                        $isYouTube = !empty($videoId);
                                        $isVideo = str_starts_with($media->mime_type, 'video/');
                                    @endphp

                                    <div class="col-12 col-sm-6 col-md-4">
                                        <div class="video-card rounded overflow-hidden shadow-sm h-100 bg-white">
                                            {{-- Video Thumbnail Container --}}
                                            <div class="position-relative overflow-hidden video-thumbnail" style="height: 200px; background: #000;">
                                                @if($isYouTube)
                                                    {{-- YouTube Thumbnail --}}
                                                    <img
                                                        src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg"
                                                        alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                                        class="w-100 h-100"
                                                        style="object-fit: cover;"
                                                        loading="lazy"
                                                        onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg';"
                                                    >
                                                @elseif(isset($media->custom_properties['thumbnail']))
                                                    {{-- Custom Thumbnail --}}
                                                    <img
                                                        src="{{ $media->custom_properties['thumbnail'] }}"
                                                        alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                                        class="w-100 h-100"
                                                        style="object-fit: cover;"
                                                        loading="lazy"
                                                    >
                                                @elseif($isVideo)
                                                    {{-- Video Element (Filament Approach) --}}
                                                    <video
                                                        class="w-100 h-100"
                                                        style="object-fit: cover; pointer-events: none;"
                                                        muted
                                                    >
                                                        <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                                    </video>
                                                @else
                                                    {{-- Fallback Icon --}}
                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                        <i class="fas fa-video fa-4x text-white opacity-50"></i>
                                                    </div>
                                                @endif
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
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            {{-- Pagination Info --}}
                            <div class="text-muted small">
                                Menampilkan {{ $mediaItems->firstItem() ?? 0 }} - {{ $mediaItems->lastItem() ?? 0 }}
                                dari {{ $mediaItems->total() }} video
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
                        <h4><i class="fas fa-video me-2"></i>Video Gallery</h4>
                    </div>
                    <div class="widget-body">
                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-film me-2"></i>Total Video</span>
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

                {{-- Latest Videos Widget --}}
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <h4><i class="fas fa-clock me-2"></i>Video Terbaru</h4>
                    </div>
                    <div class="widget-body">
                        @php
                            $latestItems = $folder->getMedia($collectionName)->sortByDesc('created_at')->take(5);
                        @endphp

                        @forelse($latestItems as $item)
                            @php
                                $videoUrl = $item->custom_properties['video_url'] ?? null;
                                $videoId = $videoUrl ? $this->getVideoId($videoUrl) : null;
                                $isYouTube = !empty($videoId);
                                $isVideo = str_starts_with($item->mime_type, 'video/');
                            @endphp
                            <a href="javascript:void(0)" wire:click="showMediaDetail({{ $item->id }})" class="news-item">
                                <div class="news-thumbnail">
                                    @if($isYouTube)
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/default.jpg"
                                             alt="{{ $item->custom_properties['title'] ?? $item->name }}">
                                    @elseif(isset($item->custom_properties['thumbnail']))
                                        <img src="{{ $item->custom_properties['thumbnail'] }}"
                                             alt="{{ $item->custom_properties['title'] ?? $item->name }}">
                                    @elseif($isVideo)
                                        <video style="pointer-events: none;" muted>
                                            <source src="{{ $item->getUrl() }}" type="{{ $item->mime_type }}">
                                        </video>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100" style="background: #000;">
                                            <i class="fas fa-video text-white"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-play text-white" style="font-size: 0.75rem; text-shadow: 0 0 3px rgba(0,0,0,0.8);"></i>
                                    </div>
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
                            <p class="text-muted small mb-0">Belum ada video tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Video Modal - Modern Style --}}
    @if($detailMedia)
        @php
            // Check if video_url exists in custom_properties (YouTube)
            $videoUrl = $detailMedia->custom_properties['video_url'] ?? null;
            $videoId = $videoUrl ? $this->getVideoId($videoUrl) : null;
            $isYouTube = !empty($videoId);
            $isLocalVideo = str_starts_with($detailMedia->mime_type, 'video/');
            $uniqueId = 'video_' . $detailMedia->id . '_' . time();
        @endphp

        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.7);" id="videoModal{{ $detailMedia->id }}">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                    {{-- Modal Header with Gradient --}}
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; padding: 1.5rem;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fas fa-video me-2"></i>{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeMediaDetail"></button>
                    </div>

                    <div class="modal-body p-0">
                        {{-- Video Player --}}
                        @if($isYouTube)
                            {{-- YouTube Video --}}
                            <div class="ratio ratio-16x9" style="background: #000;">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&rel=0&modestbranding=1"
                                    title="{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    loading="lazy"
                                    style="border: none;">
                                </iframe>
                            </div>
                        @elseif($isLocalVideo)
                            {{-- Direct Video File - Sama persis seperti Filament --}}
                            <div class="ratio ratio-16x9" style="background: #000;">
                                <video class="w-100 h-100" controls style="object-fit: contain;">
                                    <source src="{{ $detailMedia->getUrl() }}" type="{{ $detailMedia->mime_type }}">
                                </video>
                            </div>
                        @else
                            {{-- Fallback - Debug Info --}}
                            <div class="text-center py-5" style="background: #f8f9fa;">
                                <i class="fas fa-video fa-5x text-muted mb-3"></i>
                                <h5 class="text-dark">Video tidak dapat diputar</h5>
                                <p class="text-muted">Format video tidak didukung</p>
                            </div>
                        @endif

                        {{-- Video Info Section --}}
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
                                @if(isset($detailMedia->custom_properties['duration']))
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1"><i class="far fa-clock me-1"></i>Durasi</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ $this->formatDuration($detailMedia->custom_properties['duration']) }}</strong>
                                    </div>
                                @endif
                                @if(isset($detailMedia->custom_properties['views']))
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1"><i class="far fa-eye me-1"></i>Dilihat</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ number_format($detailMedia->custom_properties['views']) }} kali</strong>
                                    </div>
                                @endif
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
                        @if($videoUrl)
                            <a href="{{ $videoUrl }}" target="_blank" class="btn btn-sm text-white" style="background: #05AC69;">
                                <i class="fas fa-external-link-alt me-1"></i>Buka di YouTube
                            </a>
                        @elseif($isLocalVideo)
                            <a href="{{ $detailMedia->getUrl() }}" download class="btn btn-sm text-white" style="background: #05AC69;">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        @endif
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
