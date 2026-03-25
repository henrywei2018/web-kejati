<?php

namespace App\Livewire\Pages;

use TomatoPHP\FilamentMediaManager\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class InfografisPage extends Component
{
    use WithPagination;

    public ?int $detailMediaId = null;
    public string $search = '';
    public string $sortBy = 'terbaru'; // terbaru, terlama, judul

    protected $folderId = 2; // Folder ID untuk Infografis

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
        // Load folder Infografis — cached 10 min
        $folder = Cache::remember('folder_infografis_' . $this->folderId, 600, function () {
            return Folder::withoutGlobalScope('user')->findOrFail($this->folderId);
        });

        // Get all media from this folder — cached 10 min
        $mediaItems = Cache::remember('folder_infografis_media_' . $this->folderId, 600, function () use ($folder) {
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
        $perPage = 12; // Grid layout works better with 12 items (3x4 or 4x3)
        $currentPage = $this->getPage();

        $paginatedMedia = new \Illuminate\Pagination\LengthAwarePaginator(
            $mediaItems->forPage($currentPage, $perPage)->values(),
            $mediaItems->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        // Get detail media if selected — reuse already-loaded cached collection
        $detailMedia = null;
        if ($this->detailMediaId) {
            $detailMedia = $mediaItems->firstWhere('id', $this->detailMediaId);
        }

        return view('livewire.pages.infografis-page', [
            'folder' => $folder,
            'mediaItems' => $paginatedMedia,
            'detailMedia' => $detailMedia,
        ])->layout('layouts.main', [
            'title' => 'Infografis - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Galeri infografis dari Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => 'infografis, galeri, kejaksaan tinggi kaltara'
        ]);
    }
}
