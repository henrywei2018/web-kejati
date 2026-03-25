<?php

namespace App\Livewire\Pages;

use TomatoPHP\FilamentMediaManager\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class PengumumanPage extends Component
{
    use WithPagination;

    public ?int $detailMediaId = null;
    public string $search = '';
    public string $sortBy = 'terbaru'; // terbaru, terlama, judul

    protected $folderId = 3; // Folder ID untuk Pengumuman

    protected $queryString = ['search', 'sortBy'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function showMediaDetail(int $mediaId): void
    {
        $this->detailMediaId = $mediaId;
    }

    public function closeMediaDetail(): void
    {
        $this->detailMediaId = null;
    }

    public function getFileIcon(string $mimeType): string
    {
        return match(true) {
            str_contains($mimeType, 'pdf') => 'pdf',
            str_contains($mimeType, 'word') || str_contains($mimeType, 'document') => 'word',
            str_contains($mimeType, 'excel') || str_contains($mimeType, 'spreadsheet') => 'excel',
            str_contains($mimeType, 'powerpoint') || str_contains($mimeType, 'presentation') => 'powerpoint',
            str_contains($mimeType, 'zip') || str_contains($mimeType, 'compressed') => 'archive',
            str_contains($mimeType, 'video') => 'video',
            str_contains($mimeType, 'audio') => 'audio',
            default => 'alt',
        };
    }

    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function render()
    {
        // Load folder Pengumuman — cached 10 min
        $folder = Cache::remember('folder_pengumuman_' . $this->folderId, 600, function () {
            return Folder::withoutGlobalScope('user')->findOrFail($this->folderId);
        });

        // Get all media from this folder — cached 10 min
        $mediaItems = Cache::remember('folder_pengumuman_media_' . $this->folderId, 600, function () use ($folder) {
            return collect($folder->getMedia($folder->collection));
        });

        // Apply search filter
        if ($this->search) {
            $mediaItems = $mediaItems->filter(function ($media) {
                $title = $media->custom_properties['title'] ?? $media->name;
                $description = $media->custom_properties['description'] ?? '';

                return stripos($title, $this->search) !== false ||
                       stripos($description, $this->search) !== false;
            });
        }

        // Apply sorting
        $mediaItems = match($this->sortBy) {
            'terlama' => $mediaItems->sortBy('created_at'),
            'judul' => $mediaItems->sortBy(fn($media) => $media->custom_properties['title'] ?? $media->name),
            default => $mediaItems->sortByDesc('created_at'), // terbaru
        };

        // Paginate manually since it's a collection
        $perPage = 10;
        $currentPage = $this->getPage();

        $paginatedMedia = new \Illuminate\Pagination\LengthAwarePaginator(
            $mediaItems->forPage($currentPage, $perPage)->values(),
            $mediaItems->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        // Get detail media if selected — reuse the already-loaded cached collection
        $detailMedia = null;
        if ($this->detailMediaId) {
            $detailMedia = $mediaItems->firstWhere('id', $this->detailMediaId);
        }

        return view('livewire.pages.pengumuman-page', [
            'folder' => $folder,
            'mediaItems' => $paginatedMedia,
            'detailMedia' => $detailMedia,
        ])->layout('layouts.main', [
            'title' => 'Pengumuman - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Daftar pengumuman resmi dari Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => 'pengumuman, informasi, kejaksaan tinggi kaltara'
        ]);
    }
}
