<?php

namespace App\Observers;

use App\Models\Blog\Category;
use App\Services\CacheInvalidationService;

class BlogCategoryObserver
{
    public function created(Category $category): void
    {
        CacheInvalidationService::clearBlogCategoryCaches();
    }

    public function updated(Category $category): void
    {
        CacheInvalidationService::clearBlogCategoryCaches();
    }

    public function deleted(Category $category): void
    {
        CacheInvalidationService::clearBlogCategoryCaches();
    }
}
