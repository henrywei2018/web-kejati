<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearPageCache extends Command
{
    protected $signature = 'cache:pages {--section= : Clear only a specific section (home, berita, gallery, employee, media, response)}';
    protected $description = 'Clear frontend page caches to reflect new content immediately';

    /** All cache key prefixes grouped by section */
    private array $sections = [
        'home' => [
            'home_hero_banner',
            'home_services',
            'home_latest_posts',
            'home_featured_posts',
            'home_popular_posts',
            'home_latest_infografis',
            'home_publikasi',
            'home_pengumuman',
            'home_employees',
            'home_kepala_kejaksaan',
            'home_layanan_services',
        ],
        'berita' => [
            'berita_featured_post',
            'berita_sidebar_categories',
            'berita_sidebar_popular_posts',
            'berita_popular_tags',
        ],
        'gallery' => [
            'gallery_available_folders',
        ],
        'employee' => [
            'employee_departments',
            'employee_stats',
        ],
    ];

    /** Prefix-based keys (cleared by forgetting folder-specific caches) */
    private array $prefixSections = [
        'media' => [
            'folder_infografis_',
            'folder_pengumuman_',
            'folder_galeri_',
            'folder_publikasi_',
        ],
    ];

    public function handle(): int
    {
        $section = $this->option('section');

        if ($section && !isset($this->sections[$section]) && !isset($this->prefixSections[$section])) {
            $this->error("Unknown section: {$section}. Available: " . implode(', ', array_merge(array_keys($this->sections), array_keys($this->prefixSections))));
            return self::FAILURE;
        }

        $cleared = 0;

        $sectionsToProcess = $section
            ? array_filter($this->sections, fn($k) => $k === $section, ARRAY_FILTER_USE_KEY)
            : $this->sections;

        foreach ($sectionsToProcess as $name => $keys) {
            foreach ($keys as $key) {
                Cache::forget($key);
                $cleared++;
            }
            $this->line("  Cleared section: <info>{$name}</info> (" . count($keys) . " keys)");
        }

        // For prefix-based caches, use cache store tags if available, else flush all
        if (!$section || isset($this->prefixSections[$section])) {
            $prefixSections = $section
                ? array_filter($this->prefixSections, fn($k) => $k === $section, ARRAY_FILTER_USE_KEY)
                : $this->prefixSections;

            foreach ($prefixSections as $name => $prefixes) {
                // Try to flush folder IDs 1–50 (covers typical usage)
                foreach ($prefixes as $prefix) {
                    for ($id = 1; $id <= 50; $id++) {
                        Cache::forget($prefix . $id);
                        Cache::forget($prefix . $id . '_video');
                        Cache::forget($prefix . $id . '_gambar');
                        $cleared++;
                    }
                }
                $this->line("  Cleared section: <info>{$name}</info> (folder caches)");
            }
        }

        // Full-page response cache uses page_cache_* keys — flush via cache store tags not supported
        // on file driver, so we use a dedicated flush via Laravel cache store
        if (!$section || $section === 'response') {
            $this->call('cache:clear');
            $this->line("  Cleared section: <info>response</info> (full-page HTML cache + all other caches)");
            $this->info("Done. All caches cleared.");
            return self::SUCCESS;
        }

        $this->info("Done. Cleared {$cleared} cache entries.");

        return self::SUCCESS;
    }
}
