<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="$folder->name"
        :subtitle="$folder->description ?? 'Galeri Media ' . $folder->name"
        :badge="ucfirst($folder->collection)"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Galeri Media', 'url' => route('gallery')],
            ['label' => $folder->name, 'url' => null]
        ]"
    />

    {{-- Media Grid --}}
    <section class="section section-default py-5">
        <div class="container">
            {{-- Folder Info --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" @if($folder->color) style="border-left: 4px solid {{ $folder->color }} !important;" @endif>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    @if($folder->icon)
                                        <x-icon name="{{ $folder->icon }}" class="me-3" style="width: 40px; height: 40px; color: {{ $folder->color ?? '#0d6efd' }};" />
                                    @endif
                                    <div>
                                        <h3 class="mb-1">{{ $folder->name }}</h3>
                                        @if($folder->description)
                                            <p class="text-muted mb-0">{{ $folder->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge fs-6" style="background-color: {{ $folder->color ?? '#0d6efd' }};">
                                        <i class="fas fa-file me-1"></i>
                                        {{ $folder->getMedia($folder->collection)->count() }} File
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Media Items Grid --}}
            <div class="row">
                @forelse($mediaItems as $media)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if(str_starts_with($media->mime_type, 'image/'))
                                {{-- Image Files --}}
                                <div class="position-relative overflow-hidden" style="height: 200px; cursor: pointer;" wire:click="showMediaDetail({{ $media->id }})">
                                    <img
                                        src="{{ $media->getUrl() }}"
                                        alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                        class="w-100 h-100 object-fit-cover"
                                        style="transition: transform 0.3s ease;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'"
                                    >
                                </div>
                            @else
                                {{-- Non-image Files --}}
                                <div class="bg-gradient d-flex align-items-center justify-content-center"
                                    style="height: 200px; background: linear-gradient(135deg, {{ $folder->color ?? '#6c757d' }} 0%, {{ $folder->color ?? '#495057' }} 100%);">
                                    <div class="text-center text-white">
                                        <i class="fas fa-file-{{ $this->getFileIcon($media->mime_type) }} fa-3x mb-2"></i>
                                        <p class="mb-0 fw-bold">{{ strtoupper($media->extension ?? 'FILE') }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="card-body p-2">
                                <h6 class="card-title text-3 mb-1" title="{{ $media->custom_properties['title'] ?? $media->name }}">
                                    {{ Str::limit($media->custom_properties['title'] ?? $media->name, 30) }}
                                </h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted text-2">
                                        {{ $this->formatBytes($media->size) }}
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
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Folder ini belum memiliki file.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($mediaItems->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        {{ $mediaItems->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Detail Modal --}}
    @if($detailMedia)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1" wire:click.self="closeMediaDetail">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" @if($folder->color) style="border-bottom: 3px solid {{ $folder->color }};" @endif>
                        <h5 class="modal-title">{{ $detailMedia->custom_properties['title'] ?? $detailMedia->name }}</h5>
                        <button type="button" class="btn-close" wire:click="closeMediaDetail"></button>
                    </div>
                    <div class="modal-body">
                        @if(str_starts_with($detailMedia->mime_type, 'image/'))
                            <img src="{{ $detailMedia->getUrl() }}" alt="{{ $detailMedia->name }}" class="img-fluid rounded mb-3">
                        @else
                            <div class="text-center py-5 bg-light rounded">
                                <i class="fas fa-file-{{ $this->getFileIcon($detailMedia->mime_type) }} fa-5x mb-3" style="color: {{ $folder->color ?? '#6c757d' }};"></i>
                                <h4>{{ strtoupper($detailMedia->extension ?? 'FILE') }}</h4>
                                <p class="text-muted">{{ $this->formatBytes($detailMedia->size) }}</p>
                            </div>
                        @endif

                        @if(isset($detailMedia->custom_properties['description']))
                            <p class="mt-3">{{ $detailMedia->custom_properties['description'] }}</p>
                        @endif

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>
                                Ditambahkan: {{ $detailMedia->created_at->format('d F Y, H:i') }}
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ $detailMedia->getUrl() }}" download="{{ $detailMedia->file_name }}" class="btn btn-primary">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                        <button type="button" class="btn btn-secondary" wire:click="closeMediaDetail">Tutup</button>
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
