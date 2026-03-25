<?php

namespace App\Observers;

use App\Models\Banner\Content;
use App\Services\CacheInvalidationService;

class BannerContentObserver
{
    public function created(Content $content): void
    {
        CacheInvalidationService::clearHomeBannerCaches();
    }

    public function updated(Content $content): void
    {
        CacheInvalidationService::clearHomeBannerCaches();
    }

    public function deleted(Content $content): void
    {
        CacheInvalidationService::clearHomeBannerCaches();
    }

    public function restored(Content $content): void
    {
        CacheInvalidationService::clearHomeBannerCaches();
    }
}
