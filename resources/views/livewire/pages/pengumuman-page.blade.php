<div role="main" class="main">
    {{-- Header --}}
    <livewire:components.header-details
        :title="'Pengumuman'"
        :subtitle="'Informasi dan pengumuman resmi Kejaksaan Tinggi Kalimantan Utara'"
        :badge="'Informasi Publik'"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Informasi', 'url' => '#'],
            ['label' => 'Pengumuman', 'url' => null]
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
                                        placeholder="Ketikkan pencarian Anda..."
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

                {{-- Kumpulan Publikasi Card --}}
                <div class="card border-0 shadow rounded">
                    <div class="card-body p-0">
                        {{-- Card Header --}}
                        <div class="px-4 py-3 border-bottom bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Kumpulan Publikasi</h4>
                                <span class="text-muted">
                                    Menampilkan {{ $mediaItems->count() }} dari {{ $folder->getMedia($folder->collection)->count() }} pengumuman
                                </span>
                            </div>
                        </div>

                        {{-- Table Content --}}
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center ps-4" style="width: 50px;">#</th>
                                        <th style="width: 60px;"></th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center" style="width: 130px;">Tanggal</th>
                                        <th class="text-center pe-4" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mediaItems as $index => $media)
                                        <tr>
                                            {{-- Number --}}
                                            <td class="text-center text-muted ps-4">
                                                {{ $mediaItems->firstItem() + $index }}
                                            </td>

                                            {{-- Icon/Preview --}}
                                            <td>
                                                @if(str_starts_with($media->mime_type, 'image/'))
                                                    <img
                                                        src="{{ $media->getUrl() }}"
                                                        alt="{{ $media->custom_properties['title'] ?? $media->name }}"
                                                        class="rounded cursor-pointer"
                                                        style="width: 45px; height: 45px; object-fit: cover;"
                                                        wire:click="showMediaDetail({{ $media->id }})"
                                                    >
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center rounded"
                                                        style="width: 45px; height: 45px; background-color: #dc3545;">
                                                        <i class="fas fa-file-{{ $this->getFileIcon($media->mime_type) }} text-white"></i>
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Title --}}
                                            <td>
                                                <strong class="text-dark">{{ $media->custom_properties['title'] ?? $media->name }}</strong>
                                            </td>

                                            {{-- Description --}}
                                            <td class="text-muted">
                                                {{ Str::limit($media->custom_properties['description'] ?? 'Deskripsi ' . ($media->custom_properties['title'] ?? $media->name), 100) }}
                                            </td>

                                            {{-- Date --}}
                                            <td class="text-center">
                                                <small class="text-muted">{{ $media->created_at->format('d-m-Y') }}</small>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button
                                                        wire:click="showMediaDetail({{ $media->id }})"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="Lihat Detail"
                                                    >
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a
                                                        href="{{ $media->getUrl() }}"
                                                        download="{{ $media->file_name }}"
                                                        class="btn btn-sm btn-danger"
                                                        title="Download"
                                                    >
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                                                    <p class="mb-0 fs-5">
                                                        {{ $search ? 'Tidak ada hasil yang ditemukan untuk "' . $search . '"' : 'Belum ada pengumuman tersedia saat ini.' }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
                            <a href="javascript:void(0)" wire:click="showMediaDetail({{ $item->id }})" class="news-item">
                                <div class="news-thumbnail">
                                    @if(str_starts_with($item->mime_type, 'image/'))
                                        <img src="{{ $item->getUrl() }}" alt="{{ $item->custom_properties['title'] ?? $item->name }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100" style="background-color: #05AC69;">
                                            <i class="fas fa-file-{{ $this->getFileIcon($item->mime_type) }} text-white fa-lg"></i>
                                        </div>
                                    @endif
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
                            <p class="text-muted small mb-0">Belum ada item tersedia</p>
                        @endforelse
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
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-file-alt me-2"></i>Total</span>
                                <span class="info-value">{{ $total }}</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    @if($detailMedia)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.7);" tabindex="-1" wire:click.self="closeMediaDetail">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
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
                        @if(str_starts_with($detailMedia->mime_type, 'image/'))
                            {{-- Image Preview --}}
                            <div class="text-center mb-3">
                                <img src="{{ $detailMedia->getUrl() }}" alt="{{ $detailMedia->name }}" class="img-fluid rounded shadow-sm">
                            </div>
                        @elseif(str_contains($detailMedia->mime_type, 'pdf'))
                            {{-- PDF Preview with iframe --}}
                            <div class="mb-3">
                                <iframe
                                    src="{{ $detailMedia->getUrl() }}"
                                    style="width: 100%; height: 600px; border: none;"
                                    class="rounded shadow-sm">
                                </iframe>
                            </div>
                        @else
                            {{-- File Type Preview --}}
                            <div class="text-center py-5 bg-light rounded mb-3">
                                <div class="mb-3">
                                    <i class="fas fa-file-{{ $this->getFileIcon($detailMedia->mime_type) }} fa-5x text-danger"></i>
                                </div>
                                <h4 class="mb-2">{{ strtoupper($detailMedia->extension ?? 'FILE') }}</h4>
                                <p class="text-muted mb-0">{{ $this->formatBytes($detailMedia->size) }}</p>
                            </div>
                        @endif

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
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .card {
            transition: all 0.3s ease;
        }
        .list-group-item {
            transition: all 0.2s ease;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(3px);
        }
        .rounded {
            border-radius: 0.375rem !important;
        }
        .rounded-top {
            border-top-left-radius: 0.375rem !important;
            border-top-right-radius: 0.375rem !important;
        }
    </style>
    @endpush
</div>
