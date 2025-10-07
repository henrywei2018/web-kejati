<div>
    {{-- Header Breadcrumb --}}
    <livewire:components.header-details
        title="Daftar Pegawai"
        badge="Sumber Daya Manusia"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Daftar Pegawai']
        ]"
    />

    {{-- Main Content --}}
    <section class="section bg-light position-relative border-0 m-0 p-0">
        <div class="px-4 py-4">
            <div class="row g-3">
                {{-- Main Content Column --}}
                <div class="col-lg-9">
                    {{-- Search & Filter Bar --}}
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-3">
                            <div class="row g-2 align-items-end">
                                {{-- Search --}}
                                <div class="col-md-6">
                                    <label class="form-label text-2 fw-semibold mb-1">
                                        <i class="fas fa-search me-1 text-primary"></i> Cari Pegawai
                                    </label>
                                    <input
                                        type="text"
                                        wire:model.live.debounce.300ms="search"
                                        class="form-control form-control-sm"
                                        placeholder="Nama, NIP, Jabatan..."
                                    >
                                </div>

                                {{-- Department Filter --}}
                                <div class="col-md-3">
                                    <label class="form-label text-2 fw-semibold mb-1">
                                        <i class="fas fa-building me-1 text-primary"></i> Unit Kerja
                                    </label>
                                    <select wire:model.live="department" class="form-select form-select-sm">
                                        <option value="">Semua</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept }}">{{ $dept }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status Filter --}}
                                <div class="col-md-3">
                                    <label class="form-label text-2 fw-semibold mb-1">
                                        <i class="fas fa-id-card me-1 text-primary"></i> Status
                                    </label>
                                    <select wire:model.live="employmentStatus" class="form-select form-select-sm">
                                        <option value="">Semua</option>
                                        @foreach($employmentStatuses as $status)
                                            <option value="{{ $status }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Active Filters --}}
                            @if($search || $department || $employmentStatus)
                                <div class="mt-2 pt-2 border-top">
                                    <div class="d-flex flex-wrap gap-2 align-items-center">
                                        <small class="text-muted">Filter:</small>
                                        @if($search)
                                            <span class="badge bg-primary">
                                                "{{ $search }}"
                                                <button wire:click="$set('search', '')" class="btn-close btn-close-white ms-1" style="font-size: 0.5rem;"></button>
                                            </span>
                                        @endif
                                        @if($department)
                                            <span class="badge" style="background: #05AC69;">
                                                {{ $department }}
                                                <button wire:click="$set('department', '')" class="btn-close btn-close-white ms-1" style="font-size: 0.5rem;"></button>
                                            </span>
                                        @endif
                                        @if($employmentStatus)
                                            <span class="badge bg-info">
                                                {{ $employmentStatus }}
                                                <button wire:click="$set('employmentStatus', '')" class="btn-close btn-close-white ms-1" style="font-size: 0.5rem;"></button>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Results Info & Sort --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="text-3 mb-0">
                            <strong>{{ $employees->total() }}</strong> pegawai ditemukan
                        </p>
                        <div class="btn-group btn-group-sm" role="group">
                            <button
                                wire:click="sortBy('name')"
                                class="btn {{ $sortBy === 'name' ? 'btn-primary' : 'btn-outline-secondary' }}"
                            >
                                <i class="fas fa-sort-alpha-{{ $sortDirection === 'asc' ? 'down' : 'up' }} me-1"></i>
                                Nama
                            </button>
                            <button
                                wire:click="sortBy('display_order')"
                                class="btn {{ $sortBy === 'display_order' ? 'btn-primary' : 'btn-outline-secondary' }}"
                            >
                                <i class="fas fa-sort-numeric-{{ $sortDirection === 'asc' ? 'down' : 'up' }} me-1"></i>
                                Urutan
                            </button>
                        </div>
                    </div>

                    {{-- Employee Grid --}}
                    <div class="row g-3" wire:loading.class="opacity-50">
                        @forelse($employees as $employee)
                            <div class="col-md-6 col-lg-4">
                                <div class="employee-card card border-0 shadow-sm h-100"
                                     wire:click="showDetail('{{ $employee->id }}')"
                                     role="button">
                                    <div class="card-body p-3">
                                        {{-- Photo --}}
                                        <div class="text-center mb-2">
                                            @if($employee->getFirstMediaUrl('photo', 'preview'))
                                                <img
                                                    src="{{ $employee->getFirstMediaUrl('photo', 'preview') }}"
                                                    alt="{{ $employee->name }}"
                                                    class="employee-photo rounded-circle shadow-sm"
                                                >
                                            @else
                                                <div class="employee-photo-placeholder rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm">
                                                    <i class="fas fa-user fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Info --}}
                                        <div class="text-center">
                                            <h6 class="mb-1 fw-bold text-dark">{{ $employee->name }}</h6>

                                            @if($employee->nip)
                                                <p class="text-muted mb-1" style="font-size: 0.75rem;">
                                                    NIP: {{ $employee->nip }}
                                                </p>
                                            @endif

                                            <p class="mb-1 fw-semibold" style="color: #05AC69; font-size: 0.875rem;">
                                                {{ $employee->position }}
                                            </p>

                                            @if($employee->rank)
                                                <p class="text-muted mb-2" style="font-size: 0.8rem;">
                                                    {{ $employee->rank }}
                                                </p>
                                            @endif

                                            {{-- Badges --}}
                                            <div class="d-flex justify-content-center gap-1 mb-2">
                                                <span class="badge badge-sm
                                                    @if($employee->employment_status === 'PNS') bg-success
                                                    @elseif($employee->employment_status === 'PPPK') bg-info
                                                    @elseif($employee->employment_status === 'Honorer') bg-warning
                                                    @else bg-secondary
                                                    @endif" style="font-size: 0.7rem;">
                                                    {{ $employee->employment_status }}
                                                </span>
                                            </div>

                                            {{-- Department --}}
                                            @if($employee->department)
                                                <p class="text-muted mb-0" style="font-size: 0.75rem;">
                                                    <i class="fas fa-building me-1"></i>{{ $employee->department }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center py-5">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h5 class="text-dark">Tidak ada pegawai ditemukan</h5>
                                        <p class="text-muted mb-0">Coba ubah filter pencarian Anda</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($employees->hasPages())
                        <div class="mt-4">
                            {{ $employees->links() }}
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-3">
                    {{-- Statistics Widget --}}
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <h4><i class="fas fa-chart-bar me-2"></i>Statistik</h4>
                        </div>
                        <div class="widget-body">
                            <div class="info-list">
                                <div class="info-item">
                                    <span class="info-label">Total Pegawai</span>
                                    <span class="info-value">{{ $totalEmployees }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">PNS</span>
                                    <span class="info-value">{{ $totalPNS }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">PPPK</span>
                                    <span class="info-value">{{ $totalPPPK }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Department List Widget --}}
                    @if($departments->count() > 0)
                        <div class="sidebar-widget">
                            <div class="widget-header">
                                <h4><i class="fas fa-building me-2"></i>Unit Kerja</h4>
                            </div>
                            <div class="widget-body">
                                <div class="category-list">
                                    <a href="#"
                                       wire:click.prevent="$set('department', '')"
                                       class="category-item {{ !$department ? 'active' : '' }}">
                                        <span>Semua Unit</span>
                                        <span class="category-count">{{ $totalEmployees }}</span>
                                    </a>
                                    @foreach($departments as $dept)
                                        @php
                                            $count = \App\Models\Employee::active()->where('department', $dept)->count();
                                        @endphp
                                        <a href="#"
                                           wire:click.prevent="$set('department', '{{ $dept }}')"
                                           class="category-item {{ $department === $dept ? 'active' : '' }}">
                                            <span>{{ $dept }}</span>
                                            <span class="category-count">{{ $count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Status Filter Widget --}}
                    <div class="sidebar-widget">
                        <div class="widget-header">
                            <h4><i class="fas fa-filter me-2"></i>Status Kepegawaian</h4>
                        </div>
                        <div class="widget-body">
                            <div class="category-list">
                                <a href="#"
                                   wire:click.prevent="$set('employmentStatus', '')"
                                   class="category-item {{ !$employmentStatus ? 'active' : '' }}">
                                    <span>Semua Status</span>
                                    <span class="category-count">{{ $totalEmployees }}</span>
                                </a>
                                @foreach($employmentStatuses as $status)
                                    @php
                                        $count = \App\Models\Employee::active()->where('employment_status', $status)->count();
                                    @endphp
                                    @if($count > 0)
                                        <a href="#"
                                           wire:click.prevent="$set('employmentStatus', '{{ $status }}')"
                                           class="category-item {{ $employmentStatus === $status ? 'active' : '' }}">
                                            <span>{{ $status }}</span>
                                            <span class="category-count">{{ $count }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Detail Modal --}}
    @if($showModal && $selectedEmployee)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.7);">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                    {{-- Modal Header with Gradient --}}
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, #05AC69 0%, #048B56 100%); color: white; padding: 1.5rem;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fas fa-user-circle me-2"></i>Detail Pegawai
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>

                    <div class="modal-body px-4 pt-4 pb-3">
                        {{-- Header Section --}}
                        <div class="row mb-4 pb-3 border-bottom">
                            {{-- Photo Column --}}
                            <div class="col-md-4">
                                @if($selectedEmployee->getFirstMediaUrl('photo', 'large'))
                                    <img
                                        src="{{ $selectedEmployee->getFirstMediaUrl('photo', 'large') }}"
                                        alt="{{ $selectedEmployee->name }}"
                                        class="employee-detail-photo w-100 shadow"
                                        style="aspect-ratio: 6/10; object-fit: cover; border-radius: 0.75rem; border: 4px solid #05AC69;"
                                    >
                                @else
                                    <div class="employee-detail-photo-placeholder w-100 bg-light d-flex align-items-center justify-content-center shadow"
                                         style="aspect-ratio: 6/10; border-radius: 0.75rem; border: 4px solid #05AC69;">
                                        <i class="fas fa-user fa-5x text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Info Column --}}
                            <div class="col-md-8 d-flex flex-column justify-content-center">
                                <h4 class="fw-bold mb-2">{{ $selectedEmployee->name }}</h4>
                                @if($selectedEmployee->nip)
                                    <p class="text-muted mb-2">NIP: {{ $selectedEmployee->nip }}</p>
                                @endif

                                <div class="mb-3">
                                    <span class="badge
                                        @if($selectedEmployee->employment_status === 'PNS') bg-success
                                        @elseif($selectedEmployee->employment_status === 'PPPK') bg-info
                                        @elseif($selectedEmployee->employment_status === 'Honorer') bg-warning
                                        @else bg-secondary
                                        @endif">
                                        {{ $selectedEmployee->employment_status }}
                                    </span>
                                </div>

                                @if($selectedEmployee->position)
                                    <p class="mb-1"><strong style="color: #05AC69;">{{ $selectedEmployee->position }}</strong></p>
                                @endif
                                @if($selectedEmployee->rank)
                                    <p class="text-muted mb-1">{{ $selectedEmployee->rank }}</p>
                                @endif
                                @if($selectedEmployee->department)
                                    <p class="text-muted mb-0"><i class="fas fa-building me-1"></i>{{ $selectedEmployee->department }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Bio --}}
                        @if($selectedEmployee->bio)
                            <div class="mb-3">
                                <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-2" style="color: #05AC69;"></i>Biografi</h6>
                                <div class="text-dark" style="font-size: 0.9rem; line-height: 1.6;">
                                    {!! $selectedEmployee->bio !!}
                                </div>
                            </div>
                        @endif

                        {{-- Additional Info Grid --}}
                        <div class="row g-2 mb-3">
                            @if($selectedEmployee->education_level)
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-graduation-cap me-1"></i>Pendidikan</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ $selectedEmployee->education_level }}</strong>
                                    </div>
                                </div>
                            @endif

                            @if($selectedEmployee->join_date)
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-calendar me-1"></i>Tanggal Masuk</small>
                                        <strong class="text-dark" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($selectedEmployee->join_date)->format('d F Y') }}</strong>
                                    </div>
                                </div>
                            @endif

                            @if($selectedEmployee->email)
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-envelope me-1"></i>Email</small>
                                        <a href="mailto:{{ $selectedEmployee->email }}" style="color: #05AC69; font-size: 0.9rem;">
                                            {{ $selectedEmployee->email }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($selectedEmployee->phone)
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded">
                                        <small class="text-muted d-block mb-1"><i class="fas fa-phone me-1"></i>Telepon</small>
                                        <a href="tel:{{ $selectedEmployee->phone }}" style="color: #05AC69; font-size: 0.9rem;">
                                            {{ $selectedEmployee->phone }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Social Media --}}
                        @if($selectedEmployee->social_media && count($selectedEmployee->social_media) > 0)
                            <div class="mt-3 pt-3 border-top">
                                <h6 class="fw-bold mb-2"><i class="fas fa-share-alt me-2" style="color: #05AC69;"></i>Social Media</h6>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($selectedEmployee->social_media as $social)
                                        <a href="{{ $social['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-{{ strtolower($social['platform']) }} me-1"></i>
                                            {{ ucfirst($social['platform']) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Loading Indicator --}}
    <div wire:loading class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
        <div class="spinner-border" style="color: #05AC69;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <style>
        /* Employee Card Styles */
        .employee-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .employee-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(5, 172, 105, 0.15) !important;
        }

        .employee-photo {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border: 3px solid #05AC69;
        }

        .employee-photo-placeholder {
            width: 90px;
            height: 90px;
            border: 3px solid #e0e0e0;
        }

        /* Modal Styles */
        .modal.show {
            display: block !important;
        }

        /* Form Control Focus */
        .form-control:focus,
        .form-select:focus {
            border-color: #05AC69;
            box-shadow: 0 0 0 0.2rem rgba(5, 172, 105, 0.25);
        }

        /* Badge Styles */
        .badge-sm {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
        }

        /* Btn Primary Override */
        .btn-primary {
            background-color: #05AC69;
            border-color: #05AC69;
        }

        .btn-primary:hover {
            background-color: #048B56;
            border-color: #048B56;
        }

        .btn-outline-primary {
            color: #05AC69;
            border-color: #05AC69;
        }

        .btn-outline-primary:hover {
            background-color: #05AC69;
            border-color: #05AC69;
            color: white;
        }
    </style>
</div>
