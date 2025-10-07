<?php

namespace App\Livewire\Pages;

use TomatoPHP\FilamentMediaManager\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;

class VideoGalleryPage extends Component
{
    use WithPagination;

    public ?int $detailMediaId = null;
    public string $search = '';
    public string $sortBy = 'terbaru'; // terbaru, terlama, judul

    protected $folderModelId = 8; // Model ID untuk folder Galeri
    protected $collectionName = 'video'; // Collection name untuk video

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

    public function formatDuration(?int $seconds): string
    {
        if (!$seconds) return '0:00';

        $minutes = floor($seconds / 60);
        $secs = $seconds % 60;

        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $mins = $minutes % 60;
            return sprintf('%d:%02d:%02d', $hours, $mins, $secs);
        }

        return sprintf('%d:%02d', $minutes, $secs);
    }

    public function render()
    {
        // Load folder Galeri (model_id 8) untuk collection 'video'
        $folder = Folder::withoutGlobalScope('user')->findOrFail($this->folderModelId);

        // Get all media from this folder with collection 'video'
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
        $perPage = 6; // Grid layout: 3 columns x 2 rows = 6 items per page
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

        return view('livewire.pages.video-gallery-page', [
            'folder' => $folder,
            'mediaItems' => $paginatedMedia,
            'detailMedia' => $detailMedia,
            'collectionName' => $this->collectionName,
        ])->layout('layouts.main', [
            'title' => 'Galeri Video - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Kumpulan video kegiatan dan dokumentasi Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => 'video, galeri, dokumentasi, kejaksaan tinggi kaltara'
        ]);
    }
}
