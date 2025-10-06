<?php

namespace App\Livewire\Pages;

use TomatoPHP\FilamentMediaManager\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;

class FolderGalleryPage extends Component
{
    use WithPagination;

    public Folder $folder;
    public ?int $detailMediaId = null;

    public function mount($folder)
    {
        // Load folder dengan media
        $this->folder = Folder::withoutGlobalScope('user')
            ->where('is_public', true)
            ->findOrFail($folder);
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
        // Get all media from this folder
        $mediaItems = $this->folder->getMedia($this->folder->collection);

        // Paginate manually since it's a collection
        $perPage = 24;
        $currentPage = $this->getPage();
        $mediaCollection = collect($mediaItems);

        $paginatedMedia = new \Illuminate\Pagination\LengthAwarePaginator(
            $mediaCollection->forPage($currentPage, $perPage),
            $mediaCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        // Get detail media if selected
        $detailMedia = null;
        if ($this->detailMediaId) {
            $detailMedia = $mediaItems->firstWhere('id', $this->detailMediaId);
        }

        return view('livewire.pages.folder-gallery-page', [
            'mediaItems' => $paginatedMedia,
            'detailMedia' => $detailMedia,
        ])->layout('layouts.main', [
            'title' => $this->folder->name . ' - Galeri Media',
            'metaDescription' => $this->folder->description ?? 'Galeri ' . $this->folder->name . ' - Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => $this->folder->name . ', galeri media, kejaksaan tinggi kaltara'
        ]);
    }
}
