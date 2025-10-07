<?php

namespace App\Livewire\Pages;

use TomatoPHP\FilamentMediaManager\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;

class PublikasiPage extends Component
{
    use WithPagination;

    public ?int $detailMediaId = null;
    public string $search = '';
    public string $sortBy = 'terbaru'; // terbaru, terlama, judul
    public string $collectionFilter = 'all'; // Filter berdasarkan collection_name

    protected $folderModelId = 11; // Model ID untuk folder

    protected $queryString = ['search', 'sortBy', 'collectionFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingCollectionFilter()
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

    public function getVideoId(string $url): ?string
    {
        // Extract YouTube video ID from various URL formats
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
            return $id[1];
        } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
            return $id[1];
        } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
            return $id[1];
        }
        return null;
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
        // Load folder (model_id 11)
        $folder = Folder::withoutGlobalScope('user')->findOrFail($this->folderModelId);

        // Get all media from this folder (all collections)
        $allMedia = collect($folder->media);

        // Get available collections for filter
        $availableCollections = $allMedia->pluck('collection_name')->unique()->sort()->values();

        // Apply collection filter
        if ($this->collectionFilter !== 'all') {
            $mediaItems = $allMedia->filter(function ($media) {
                return $media->collection_name === $this->collectionFilter;
            });
        } else {
            $mediaItems = $allMedia;
        }

        // Apply search filter
        if ($this->search) {
            $mediaItems = $mediaItems->filter(function ($media) {
                $title = $media->custom_properties['title'] ?? $media->name;
                $description = $media->custom_properties['description'] ?? '';

                return stripos($title, $this->search) !== false ||
                       stripos($description, $this->search) !== false ||
                       stripos($media->collection_name, $this->search) !== false;
            });
        }

        // Apply sorting
        $mediaItems = match($this->sortBy) {
            'terlama' => $mediaItems->sortBy('created_at'),
            'judul' => $mediaItems->sortBy(fn($media) => $media->custom_properties['title'] ?? $media->name),
            default => $mediaItems->sortByDesc('created_at'), // terbaru
        };

        // Paginate manually since it's a collection
        $perPage = 12; // Grid layout: 4 columns x 3 rows = 12 items per page
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
            $detailMedia = $allMedia->firstWhere('id', $this->detailMediaId);
        }

        return view('livewire.pages.publikasi-page', [
            'folder' => $folder,
            'mediaItems' => $paginatedMedia,
            'detailMedia' => $detailMedia,
            'availableCollections' => $availableCollections,
            'totalMedia' => $allMedia->count(),
        ])->layout('layouts.main', [
            'title' => 'Publikasi - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Kumpulan publikasi dan dokumentasi Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => 'publikasi, dokumentasi, kejaksaan tinggi kaltara'
        ]);
    }
}
