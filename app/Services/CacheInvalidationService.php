<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Central registry for all frontend cache keys.
 *
 * Every observer and model event calls this service instead of
 * hard-coding cache key strings in multiple places. When a key
 * name changes, it only needs to change here.
 */
class CacheInvalidationService
{
    // ── Home page ────────────────────────────────────────────────────

    public static function clearHomePostCaches(): void
    {
        Cache::forget('home_latest_posts');
        Cache::forget('home_featured_posts');
        Cache::forget('home_popular_posts');
        self::clearPageResponseCache('/');
    }

    public static function clearHomeBannerCaches(): void
    {
        Cache::forget('home_hero_banner');
        Cache::forget('home_services');
        Cache::forget('home_layanan_services');
        self::clearPageResponseCache('/');
    }

    public static function clearHomeEmployeeCaches(): void
    {
        Cache::forget('home_employees');
        Cache::forget('home_kepala_kejaksaan');
        self::clearPageResponseCache('/');
    }

    public static function clearHomeMediaCaches(?string $collection = null): void
    {
        if ($collection === null || $collection === 'infografis') {
            Cache::forget('home_latest_infografis');
        }
        if ($collection === null || $collection === 'laporan-publikasi') {
            Cache::forget('home_publikasi');
        }
        if ($collection === null || str_starts_with((string) $collection, 'pengumuman')) {
            Cache::forget('home_pengumuman');
        }
        self::clearPageResponseCache('/');
    }

    // ── Berita (blog) ────────────────────────────────────────────────

    public static function clearBeritaCaches(?string $postSlug = null): void
    {
        Cache::forget('berita_featured_post');
        Cache::forget('berita_sidebar_categories');
        Cache::forget('berita_sidebar_popular_posts');
        Cache::forget('berita_popular_tags');

        self::clearPageResponseCache('/berita');

        if ($postSlug) {
            Cache::forget("berita_related_{$postSlug}");
            Cache::forget("berita_prev_{$postSlug}");
            Cache::forget("berita_next_{$postSlug}");
            self::clearPageResponseCache("/berita/{$postSlug}");
        }
    }

    public static function clearBlogCategoryCaches(): void
    {
        Cache::forget('berita_sidebar_categories');
        Cache::forget('berita_popular_tags');
        self::clearPageResponseCache('/berita');
    }

    // ── Employee ─────────────────────────────────────────────────────

    public static function clearEmployeeCaches(): void
    {
        Cache::forget('employee_departments');
        Cache::forget('employee_stats');
        self::clearHomeEmployeeCaches();
        self::clearPageResponseCache('/organisasi/pegawai');
    }

    // ── Media folders ────────────────────────────────────────────────

    public static function clearFolderCaches(int $folderId, ?string $collection = null): void
    {
        Cache::forget("folder_infografis_{$folderId}");
        Cache::forget("folder_infografis_media_{$folderId}");
        Cache::forget("folder_pengumuman_{$folderId}");
        Cache::forget("folder_pengumuman_media_{$folderId}");
        Cache::forget("folder_galeri_{$folderId}");
        Cache::forget("folder_galeri_media_{$folderId}_video");
        Cache::forget("folder_galeri_media_{$folderId}_gambar");
        Cache::forget("folder_publikasi_{$folderId}");
        Cache::forget("folder_publikasi_media_{$folderId}");

        Cache::forget('gallery_available_folders');

        self::clearPageResponseCache('/galeri');
        self::clearPageResponseCache('/galeri/video');
        self::clearPageResponseCache('/galeri/gambar');
        self::clearPageResponseCache('/informasi/pengumuman');
        self::clearPageResponseCache('/informasi/infografis');
        self::clearPageResponseCache('/informasi/publikasi');
    }

    // ── Spatie Media Library collections ─────────────────────────────

    /**
     * Called when a Media model is saved or deleted.
     * Maps collection names to the correct frontend caches.
     */
    public static function clearMediaCollectionCaches(string $collection): void
    {
        match (true) {
            $collection === 'infografis'                     => self::clearFolderByCollection('infografis'),
            str_starts_with($collection, 'pengumuman')       => self::clearFolderByCollection('pengumuman'),
            $collection === 'laporan-publikasi'              => self::clearFolderByCollection('publikasi'),
            in_array($collection, ['video', 'gambar'])       => self::clearFolderByCollection('galeri'),
            $collection === 'featured'                       => self::clearBeritaCaches(),
            default                                          => self::clearFolderCaches(0),
        };

        self::clearHomeMediaCaches($collection);
    }

    private static function clearFolderByCollection(string $type): void
    {
        // Clear folder caches for IDs 1–50; covers typical usage without needing a DB lookup
        for ($id = 1; $id <= 50; $id++) {
            Cache::forget("folder_{$type}_{$id}");
            Cache::forget("folder_{$type}_media_{$id}");
            Cache::forget("folder_{$type}_media_{$id}_video");
            Cache::forget("folder_{$type}_media_{$id}_gambar");
        }
    }

    // ── Navigation / Pages ───────────────────────────────────────────

    public static function clearNavigationCaches(): void
    {
        // Dynamic page routes use Navigation model — clear their response caches
        self::clearAllPageResponseCaches();
    }

    // ── Full-page HTML response caches ───────────────────────────────

    /**
     * Clear the cached HTML response for a specific URL path.
     */
    public static function clearPageResponseCache(string $path): void
    {
        $url = url($path);
        Cache::forget('page_cache_' . md5($url));
    }

    /**
     * Nuclear option: flush everything.
     * Used when Navigation or Settings change (affects every page).
     */
    public static function clearAllPageResponseCaches(): void
    {
        // The file cache driver doesn't support tag-based flushing, so we call
        // artisan cache:clear — acceptable since navigation changes are rare.
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
    }
}
