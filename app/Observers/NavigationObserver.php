<?php

namespace App\Observers;

use App\Models\Navigation;
use App\Services\CacheInvalidationService;

/**
 * Navigation changes affect every page (header menu), so we clear
 * all full-page response caches when navigation is modified.
 */
class NavigationObserver
{
    public function created(Navigation $navigation): void
    {
        CacheInvalidationService::clearNavigationCaches();
    }

    public function updated(Navigation $navigation): void
    {
        CacheInvalidationService::clearNavigationCaches();
    }

    public function deleted(Navigation $navigation): void
    {
        CacheInvalidationService::clearNavigationCaches();
    }
}
