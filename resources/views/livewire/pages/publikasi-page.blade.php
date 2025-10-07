<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="'Publikasi'"
        :subtitle="'Kumpulan media publikasi dan dokumentasi Kejaksaan Tinggi Kalimantan Utara'"
        :badge="'Informasi'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Informasi', 'url' => '#'],
            ['label' => 'Publikasi', 'url' => null]
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
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control border-start-0 ps-0"
                                        placeholder="Cari media..."
                                        wire:model.live.debounce.500ms="search"
                                    >
                                </div>
                            </div>

                            {{-- Collection Filter --}}
                            <div class="col-12 col-md-4">
                                <select class="form-select" wire:model.live="collectionFilter">
                                    <option value="all">Semua Koleksi</option>
                                    @foreach($availableCollections as $collection)
                                        <option value="{{ $collection }}">{{ ucfirst($collection) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Sort Dropdown --}}
                            <div class="col-12 col-md-4">
                                <select class="form-select" wire:model.live="sortBy">
                                    <option value="terbaru">Terbaru</option>
                                    <option value="terlama">Terlama</option>
                                    <option value="judul">Berdasarkan Judul</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Media Grid Card --}}
                <div class="card border-0 shadow rounded">
                    <div class="card-body p-4">
                        {{-- Card Header --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Galeri Publikasi</h4>
                                <div class="text-end">
                                    <span class="badge bg-danger">
                                        Total: {{ $totalMedia }} media
                                    </span>
                                    @if($search || $collectionFilter !== 'all')
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
                                        // Check media type
                                        $isImage = str_starts_with($media->mime_type, 'image/');
                                        $isVideo = str_starts_with($media->mime_type, 'video/');
                                        $isPdf = $media->mime_type === 'application/pdf';
                                        $videoUrl = $media->custom_properties['video_url'] ?? null;
                                        $videoId = $videoUrl ? $this->getVideoId($videoUrl) : null;
                                        $isYouTube = !empty($videoId);
                                    @endphp

                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="media-card rounded overflow-hidden shadow-sm h-100 bg-white"
                                             wire:click="showMediaDetail({{ $media->id }})"
                                             style="cursor: pointer;">
                                            {{-- Media Thumbnail --}}
                                            <div class="position-relative overflow-hidden media-thumbnail" style="height: 200px; background: #f8f9fa;">
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
                                                    <div class="position-absolute top-50 start-50 translate-middle">
                                                        <i class="fas fa-play-circle fa-3x text-white" style="text-shadow: 0 0 10px rgba(0,0,0,0.8);"></i>
                                                    </div>
                                                @elseif($isImage)
                                                    {{-- Image Thumbnail --}}
                                                    <img
                                                        src="{{ $media->getUrl() }}"
                                                        alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                                        class="w-100 h-100"
                                                        style="object-fit: cover;"
                                                        loading="lazy"
                                                    >
                                                @elseif($isVideo)
                                                    {{-- Video Thumbnail --}}
                                                    <video
                                                        class="w-100 h-100"
                                                        style="object-fit: cover; pointer-events: none;"
                                                        muted
                                                    >
                                                        <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                                    </video>
                                                    <div class="position-absolute top-50 start-50 translate-middle">
                                                        <i class="fas fa-play-circle fa-3x text-white" style="text-shadow: 0 0 10px rgba(0,0,0,0.8);"></i>
                                                    </div>
                                                @elseif($isPdf)
                                                    {{-- PDF Icon --}}
                                                    <div class="d-flex align-items-center justify-content-center h-100" style="background: #dc3545;">
                                                        <i class="fas fa-file-pdf fa-4x text-white"></i>
                                                    </div>
                                                @else
                                                    {{-- Generic File Icon --}}
                                                    <div class="d-flex align-items-center justify-content-center h-100" style="background: #6c757d;">
                                                        <i class="fas fa-file fa-4x text-white"></i>
                                                    </div>
                                                @endif

                                                {{-- Collection Badge --}}
                                                <div class="position-absolute top-0 start-0 m-2">
                                                    <span class="badge bg-dark bg-opacity-75">
                                                        {{ ucfirst($media->collection_name) }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Content --}}
                                            <div class="px-3 pt-3 pb-2">
                                                <h6 class="fw-bold mb-1 text-dark">
                                                    {{ Str::limit($media->custom_properties['title'] ?? $media->name, 50) }}
                                                </h6>
                                                @if(isset($media->custom_properties['description']))
                                                    <p class="text-muted small mb-0" style="font-size: 0.875rem;">
                                                        {{ Str::limit($media->custom_properties['description'], 60) }}
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
                                <i class="fas fa-folder-open fa-4x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted fs-5">
                                    {{ $search ? 'Tidak ada hasil yang ditemukan untuk "' . $search . '"' : 'Belum ada media tersedia saat ini.' }}
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
                                dari {{ $mediaItems->total() }} media
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
                                    <i class="fas fa-{{ $folder->icon ?? 'folder' }} fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">Publikasi</h5>
                                <span class="badge bg-danger">{{ $totalMedia }} Media</span>
                            </div>
                        </div>
                        @if($folder->description)
                            <p class="text-muted small mb-0">{{ $folder->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Collection Stats Widget --}}
                <div class="card border-0 shadow-sm rounded mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-layer-group text-danger me-2"></i>
                            Koleksi
                        </h5>

                        <div class="list-group list-group-flush">
                            <button
                                wire:click="$set('collectionFilter', 'all')"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-0 {{ $collectionFilter === 'all' ? 'fw-bold text-danger' : '' }}">
                                <span>Semua Koleksi</span>
                                <span class="badge {{ $collectionFilter === 'all' ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                    {{ $totalMedia }}
                                </span>
                            </button>
                            @foreach($availableCollections as $collection)
                                @php
                                    $count = collect($folder->media)->where('collection_name', $collection)->count();
                                @endphp
                                <button
                                    wire:click="$set('collectionFilter', '{{ $collection }}')"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-0 {{ $collectionFilter === $collection ? 'fw-bold text-danger' : '' }}">
                                    <span>{{ ucfirst($collection) }}</span>
                                    <span class="badge {{ $collectionFilter === $collection ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                        {{ $count }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Media Detail Modal --}}
    @if($detailMedia)
        @php
            // Check media type
            $isImage = str_starts_with($detailMedia->mime_type, 'image/');
            $isVideo = str_starts_with($detailMedia->mime_type, 'video/');
            $isPdf = $detailMedia->mime_type === 'application/pdf';
            $videoUrl = $detailMedia->custom_properties['video_url'] ?? null;
            $videoId = $videoUrl ? $this->getVideoId($videoUrl) : null;
            $isYouTube = !empty($videoId);
        @endphp

        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.85);">
            <div class="modal-dialog modal-xl modal-dialog-centered" style="pointer-events: none;">
                <div class="modal-content border-0 shadow-2xl" style="background: #ffffff; border-radius: 16px; overflow: hidden; pointer-events: auto;">
                    {{-- Modal Header --}}
                    <div class="modal-header border-0 px-4 pt-4 pb-3">
                        <div class="flex-grow-1">
                            <h5 class="modal-title fw-bold mb-1 text-dark">{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}</h5>
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>
                                {{ $detailMedia->created_at->format('d F Y') }}
                                <span class="badge bg-secondary ms-2">{{ ucfirst($detailMedia->collection_name) }}</span>
                            </small>
                        </div>
                        <button type="button" class="btn-close" wire:click="closeMediaDetail"></button>
                    </div>

                    <div class="modal-body p-0">
                        {{-- Media Display --}}
                        @if($isYouTube)
                            {{-- YouTube Video --}}
                            <div class="ratio ratio-16x9" style="background: #000;">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1"
                                    title="{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif($isVideo)
                            {{-- Local Video --}}
                            <div class="ratio ratio-16x9" style="background: #000;">
                                <video controls autoplay class="w-100 h-100" style="object-fit: contain;">
                                    <source src="{{ $detailMedia->getUrl() }}" type="{{ $detailMedia->mime_type }}">
                                    Browser Anda tidak mendukung pemutaran video.
                                </video>
                            </div>
                        @elseif($isPdf)
                            {{-- PDF Viewer --}}
                            <div style="height: 70vh;">
                                <iframe src="{{ $detailMedia->getUrl() }}" class="w-100 h-100" frameborder="0"></iframe>
                            </div>
                        @elseif($isImage)
                            {{-- Image Display --}}
                            <div class="position-relative" style="background: #05AC69; padding: 3rem 2rem;">
                                <div class="text-center">
                                    <img src="{{ $detailMedia->getUrl() }}"
                                        class="img-fluid shadow-lg"
                                        style="max-height: 70vh; object-fit: contain; border-radius: 8px;">
                                </div>
                            </div>
                        @else
                            {{-- Fallback --}}
                            <div class="text-center py-5" style="background: #f8f9fa;">
                                <i class="fas fa-file fa-5x text-muted mb-3"></i>
                                <h5 class="text-dark">Preview tidak tersedia</h5>
                                <p class="text-muted">Silakan download file untuk melihat konten</p>
                            </div>
                        @endif

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
                    <div class="modal-footer border-0 px-4 pb-4 pt-2">
                        <button type="button" class="btn btn-light px-4 py-2" wire:click="closeMediaDetail">
                            <i class="fas fa-times me-2"></i>
                            Tutup
                        </button>
                        @if($videoUrl)
                            <a href="{{ $videoUrl }}" target="_blank" class="btn px-4 py-2 text-white" style="background: #05AC69;">
                                <i class="fas fa-external-link-alt me-2"></i>
                                Buka di Tab Baru
                            </a>
                        @else
                            <a href="{{ $detailMedia->getUrl() }}" download class="btn px-4 py-2 text-white" style="background: #05AC69;">
                                <i class="fas fa-download me-2"></i>
                                Download
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
    <style>
        /* Media Card Styles */
        .media-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
        }

        .media-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .media-thumbnail {
            position: relative;
            background: #f8f9fa;
        }

        /* Modal responsiveness */
        @media (max-width: 768px) {
            .modal-xl {
                margin: 0.5rem;
            }
        }
    </style>
    @endpush
</div>
