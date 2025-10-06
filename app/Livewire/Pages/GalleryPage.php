<?php

namespace App\Livewire\Pages;

use TomatoPHP\FilamentMediaManager\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;

class GalleryPage extends Component
{
    use WithPagination;

    public string $selectedFolder = 'all';
    public ?int $detailFolderId = null;

    protected $queryString = ['selectedFolder'];

    public function filterByFolder(string $folderCollection): void
    {
        $this->selectedFolder = $folderCollection;
        $this->resetPage();
    }

    public function showDetail(int $folderId): void
    {
        $this->detailFolderId = $folderId;
    }

    public function closeDetail(): void
    {
        $this->detailFolderId = null;
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
        // Query folders yang public saja
        $query = Folder::withoutGlobalScope('user')
            ->where('is_public', true)
            ->where('is_hidden', false)
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan collection jika dipilih
        if ($this->selectedFolder !== 'all') {
            $query->where('collection', $this->selectedFolder);
        }

        $folders = $query->paginate(12);

        // Get detail folder dengan media
        $detailFolder = null;
        if ($this->detailFolderId) {
            $detailFolder = Folder::withoutGlobalScope('user')
                ->where('is_public', true)
                ->find($this->detailFolderId);
        }

        // Get available folder collections untuk filter
        $availableFolders = Folder::withoutGlobalScope('user')
            ->where('is_public', true)
            ->where('is_hidden', false)
            ->select('collection', 'name', 'icon', 'color')
            ->distinct()
            ->get()
            ->keyBy('collection');

        return view('livewire.pages.gallery-page', [
            'folders' => $folders,
            'detailFolder' => $detailFolder,
            'availableFolders' => $availableFolders,
        ])->layout('layouts.main', [
            'title' => 'Galeri Media - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Galeri media Kejaksaan Tinggi Kalimantan Utara - Pengumuman, Infografis, dan dokumentasi kegiatan.',
            'metaKeywords' => 'galeri media, pengumuman, infografis, kegiatan, kejaksaan tinggi kaltara'
        ]);
    }
}
