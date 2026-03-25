<?php

namespace App\Observers;

use App\Services\CacheInvalidationService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Listens to Spatie Media Library file events.
 *
 * When an admin uploads or deletes a file (infografis, pengumuman,
 * publikasi, video, gambar), the relevant frontend page caches are
 * automatically cleared so visitors see the new content immediately.
 */
class MediaObserver
{
    public function created(Media $media): void
    {
        CacheInvalidationService::clearMediaCollectionCaches($media->collection_name);
        CacheInvalidationService::clearFolderCaches($media->model_id);
    }

    public function updated(Media $media): void
    {
        CacheInvalidationService::clearMediaCollectionCaches($media->collection_name);
        CacheInvalidationService::clearFolderCaches($media->model_id);
    }

    public function deleted(Media $media): void
    {
        CacheInvalidationService::clearMediaCollectionCaches($media->collection_name);
        CacheInvalidationService::clearFolderCaches($media->model_id);
    }
}
