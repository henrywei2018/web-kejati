<?php

namespace App\Observers;

use App\Models\Banner\Category;
use App\Services\CacheInvalidationService;

class BannerCategoryObserver
{
    public function created(Category $category): void
    {
        CacheInvalidationService::clearHomeBannerCaches();
    }

    public function updated(Category $category): void
    {
        CacheInvalidationService::clearHomeBannerCaches();
    }

    public function deleted(Category $category): void
    {
        CacheInvalidationService::clearHomeBannerCaches();
    }
}
