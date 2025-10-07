<?php

namespace App\Livewire\Pages;

use TomatoPHP\FilamentMediaManager\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;

class ImageGalleryPage extends Component
{
    use WithPagination;

    public ?int $detailMediaId = null;
    public string $search = '';
    public string $sortBy = 'terbaru'; // terbaru, terlama, judul

    protected $folderModelId = 8; // Model ID untuk folder Galeri
    protected $collectionName = 'gambar'; // Collection name untuk gambar

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
        // Load folder Galeri (model_id 8) untuk collection 'gambar'
        $folder = Folder::withoutGlobalScope('user')->findOrFail($this->folderModelId);

        // Get all media from this folder with collection 'gambar'
        $mediaItems = collect($folder->getMedia($this->collectionName));

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
        $perPage = 9; // Grid layout: 3 columns x 3 rows = 9 items per page
        $currentPage = $this->getPage();

        $paginatedMedia = new \Illuminate\Pagination\LengthAwarePaginator(
            $mediaItems->forPage($currentPage, $perPage)->values(),
            $mediaItems->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );

        // Get detail media if selected
        $detailMedia = null;
        if ($this->detailMediaId) {
            $detailMedia = $folder->getMedia($this->collectionName)->firstWhere('id', $this->detailMediaId);
        }

        return view('livewire.pages.image-gallery-page', [
            'folder' => $folder,
            'mediaItems' => $paginatedMedia,
            'detailMedia' => $detailMedia,
            'collectionName' => $this->collectionName,
        ])->layout('layouts.main', [
            'title' => 'Galeri Gambar - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Galeri foto dan dokumentasi kegiatan Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => 'galeri, foto, dokumentasi, kejaksaan tinggi kaltara'
        ]);
    }
}
