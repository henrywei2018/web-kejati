<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="'Galeri Media'"
        :subtitle="'Dokumen, Pengumuman, Infografis, dan Kegiatan'"
        :badge="'Media Gallery'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Galeri Media', 'url' => null]
        ]"
    />

    {{-- Filter Folders --}}
    <section class="section bg-light py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                        <button
                            wire:click="filterByFolder('all')"
                            class="btn {{ $selectedFolder === 'all' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm px-4"
                        >
                            <i class="fas fa-th me-1"></i> Semua Folder
                        </button>
                        @foreach($availableFolders as $folder)
                            <button
                                wire:click="filterByFolder('{{ $folder->collection }}')"
                                class="btn {{ $selectedFolder === $folder->collection ? 'btn-primary' : 'btn-outline-primary' }} btn-sm px-4"
                                @if($folder->color) style="--bs-btn-border-color: {{ $folder->color }}; --bs-btn-hover-bg: {{ $folder->color }};" @endif
                            >
                                @if($folder->icon)
                                    <x-icon name="{{ $folder->icon }}" class="me-1" style="width: 14px; height: 14px;" />
                                @else
                                    <i class="fas fa-folder me-1"></i>
                                @endif
                                {{ $folder->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Grid --}}
    <section class="section section-default py-5">
        <div class="container">
            <div class="row">
                @forelse($folders as $folder)
                    @php
                        $mediaItems = $folder->getMedia($folder->collection);
                        $firstMedia = $mediaItems->first();
                        $mediaCount = $mediaItems->count();
                    @endphp

                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card border-0 shadow-sm h-100" @if($folder->color) style="border-left: 4px solid {{ $folder->color }} !important;" @endif>
                            @if($firstMedia)
                                @if(str_starts_with($firstMedia->mime_type, 'image/'))
                                    <div class="card-img-top position-relative overflow-hidden" style="height: 200px; cursor: pointer;" wire:click="showDetail({{ $folder->id }})">
                                        <img
                                            src="{{ $firstMedia->getUrl() }}"
                                            alt="{{ $folder->name }}"
                                            class="w-100 h-100 object-fit-cover transition-transform"
                                            style="transition: transform 0.3s ease;"
                                            onmouseover="this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.transform='scale(1)'"
                                        >
                                        @if($mediaCount > 1)
                                            <span class="badge bg-dark position-absolute top-0 end-0 m-2">
                                                <i class="fas fa-images me-1"></i>{{ $mediaCount }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    {{-- For non-image files (PDF, etc) --}}
                                    <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, {{ $folder->color ?? '#6c757d' }} 0%, {{ $folder->color ?? '#495057' }} 100%);">
                                        <div class="text-center text-white">
                                            <i class="fas fa-file-{{ $this->getFileIcon($firstMedia->mime_type) }} fa-4x mb-2 opacity-75"></i>
                                            <p class="mb-0 text-2">{{ strtoupper($firstMedia->extension ?? 'FILE') }}</p>
                                        </div>
                                        @if($mediaCount > 1)
                                            <span class="badge bg-dark position-absolute top-0 end-0 m-2">
                                                <i class="fas fa-file me-1"></i>{{ $mediaCount }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    @if($folder->icon)
                                        <x-icon name="{{ $folder->icon }}" style="width: 80px; height: 80px; opacity: 0.3;" />
                                    @else
                                        <i class="fas fa-folder-open text-white fa-3x opacity-25"></i>
                                    @endif
                                </div>
                            @endif

                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    @if($folder->icon)
                                        <x-icon name="{{ $folder->icon }}" class="me-2" style="width: 18px; height: 18px; color: {{ $folder->color ?? '#0d6efd' }};" />
                                    @endif
                                    <span class="badge" style="background-color: {{ $folder->color ?? '#0d6efd' }};">
                                        {{ $folder->name }}
                                    </span>
                                </div>

                                @if($folder->description)
                                    <p class="card-text text-muted text-3 mb-2">
                                        {{ Str::limit($folder->description, 80) }}
                                    </p>
                                @else
                                    <p class="card-text text-muted text-3 mb-2">
                                        Koleksi {{ $folder->name }}
                                    </p>
                                @endif

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ $folder->created_at->format('d M Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-file me-1"></i>
                                        {{ $mediaCount }} file
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <button
                                    wire:click="showDetail({{ $folder->id }})"
                                    class="btn btn-sm btn-outline-primary w-100"
                                >
                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada folder media yang tersedia saat ini.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($folders->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        {{ $folders->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Detail Modal --}}
    @if($detailFolder)
        @php
            $detailMedia = $detailFolder->getMedia($detailFolder->collection);
        @endphp
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1" wire:click.self="closeDetail">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" @if($detailFolder->color) style="border-bottom: 3px solid {{ $detailFolder->color }};" @endif>
                        <div>
                            <h5 class="modal-title d-flex align-items-center">
                                @if($detailFolder->icon)
                                    <x-icon name="{{ $detailFolder->icon }}" class="me-2" style="width: 24px; height: 24px; color: {{ $detailFolder->color ?? '#0d6efd' }};" />
                                @endif
                                {{ $detailFolder->name }}
                            </h5>
                            <span class="badge mt-1" style="background-color: {{ $detailFolder->color ?? '#0d6efd' }};">
                                {{ $detailMedia->count() }} File
                            </span>
                        </div>
                        <button type="button" class="btn-close" wire:click="closeDetail"></button>
                    </div>
                    <div class="modal-body">
                        @if($detailFolder->description)
                            <div class="alert alert-light mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ $detailFolder->description }}
                            </div>
                        @endif

                        <div class="row g-3">
                            @foreach($detailMedia as $media)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm">
                                        @if(str_starts_with($media->mime_type, 'image/'))
                                            {{-- Image Files --}}
                                            <a href="{{ $media->getUrl() }}" data-lightbox="folder-{{ $detailFolder->id }}" data-title="{{ $media->custom_properties['title'] ?? $media->name }}">
                                                <img
                                                    src="{{ $media->getUrl() }}"
                                                    alt="{{ $media->name }}"
                                                    class="card-img-top"
                                                    style="cursor: pointer; height: 200px; object-fit: cover;"
                                                >
                                            </a>
                                        @else
                                            {{-- Non-image Files (PDF, DOC, etc) --}}
                                            <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center"
                                                style="height: 200px; background: linear-gradient(135deg, {{ $detailFolder->color ?? '#6c757d' }} 0%, {{ $detailFolder->color ?? '#495057' }} 100%);">
                                                <div class="text-center text-white">
                                                    <i class="fas fa-file-{{ $this->getFileIcon($media->mime_type) }} fa-4x mb-2"></i>
                                                    <p class="mb-0 fw-bold">{{ strtoupper($media->extension ?? 'FILE') }}</p>
                                                    <small>{{ $this->formatBytes($media->size) }}</small>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="card-body">
                                            <h6 class="card-title text-4 mb-1">
                                                {{ $media->custom_properties['title'] ?? $media->name }}
                                            </h6>
                                            @if(isset($media->custom_properties['description']))
                                                <p class="card-text text-muted text-2 mb-2">
                                                    {{ Str::limit($media->custom_properties['description'], 60) }}
                                                </p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">
                                                    <i class="far fa-calendar me-1"></i>
                                                    {{ $media->created_at->format('d M Y') }}
                                                </small>
                                                <a href="{{ $media->getUrl() }}"
                                                   download="{{ $media->file_name }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($detailMedia->isEmpty())
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Folder ini belum memiliki file.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetail">
                            <i class="fas fa-times me-1"></i> Tutup
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
    </style>
    @endpush
</div>
