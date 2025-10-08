<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Navigation;
use Illuminate\Support\Facades\Route;

class NavigationService
{
    /**
     * Get main navigation menu items
     * Priority: Beranda + Auto Pages (always) + Custom Navigation (additional)
     */
    public function getMainMenu(): array
    {
        $menu = [];

        // 1. Always add Beranda as first item
        $menu[] = [
            'label' => 'Beranda',
            'route' => 'home',
            'url' => route('home'),
            'active' => $this->isActiveRoute('home'),
        ];

        // 2. Always add auto-generated pages from database
        $menu = array_merge($menu, $this->getDynamicPagesMenu());

        // 3. Add custom navigation items (external links, dropdowns, etc)
        $customNav = $this->getCustomNavigation();
        if (!empty($customNav)) {
            $menu = array_merge($menu, $customNav);
        }

        return $menu;
    }

    /**
     * Get custom navigation from database (only custom menu items)
     */
    private function getCustomNavigation(): array
    {
        $navigations = Navigation::active()
            ->parents()
            ->ordered()
            ->with(['activeChildren.page', 'page'])
            ->get();

        if ($navigations->isEmpty()) {
            return [];
        }

        $menu = [];
        foreach ($navigations as $nav) {
            $item = [
                'label' => $nav->computed_label,
                'route' => $nav->type === 'page' && $nav->page ? 'page.show' : null,
                'url' => $nav->computed_url,
                'active' => $this->isActiveUrl($nav->computed_url),
                'target' => $nav->target ?? '_self',
            ];

            // Collect all children: from activeChildren (Navigation children) + Pages with this navigation_id
            $children = [];

            // 1. Add navigation children (submenu)
            if ($nav->activeChildren->isNotEmpty()) {
                foreach ($nav->activeChildren as $child) {
                    $children[] = [
                        'label' => $child->computed_label,
                        'route' => $child->type === 'page' && $child->page ? 'page.show' : null,
                        'url' => $child->computed_url,
                        'active' => $this->isActiveUrl($child->computed_url),
                        'target' => $child->target ?? '_self',
                    ];
                }
            }

            // 2. Add dynamic pages that belong to this navigation (pages with navigation_id)
            $navPages = Page::active()
                ->where('navigation_id', $nav->id)
                ->ordered()
                ->get();

            foreach ($navPages as $page) {
                $children[] = [
                    'label' => $page->title,
                    'route' => 'page.show',
                    'url' => $page->url,
                    'active' => $this->isActiveUrl($page->url),
                    'target' => '_self',
                ];
            }

            // Add children to item if any exist
            if (!empty($children)) {
                $item['children'] = $children;
            }

            $menu[] = $item;
        }

        return $menu;
    }


    /**
     * Get dynamic pages menu items with nested children
     * Only pages WITHOUT navigation_id (standalone pages)
     */
    public function getDynamicPagesMenu(): array
    {
        // Get only parent pages (no parent_id and no navigation_id) that should appear in navigation
        $pages = Page::active()
            ->parents()
            ->whereNull('navigation_id') // Exclude pages already under Navigation menu
            ->ordered()
            ->with(['activeChildren'])
            ->get();

        $menu = [];

        foreach ($pages as $page) {
            $item = [
                'label' => $page->title,
                'route' => 'page.show',
                'url' => $page->url,
                'active' => $this->isActiveUrl($page->url),
            ];

            // Add children if exists (pages with parent_id)
            if ($page->activeChildren->isNotEmpty()) {
                $item['children'] = [];
                foreach ($page->activeChildren as $child) {
                    $item['children'][] = [
                        'label' => $child->title,
                        'route' => 'page.show',
                        'url' => $child->url,
                        'active' => $this->isActiveUrl($child->url),
                    ];
                }
            }

            $menu[] = $item;
        }

        return $menu;
    }

    /**
     * Check if the given route is active
     */
    public function isActiveRoute(string $routeName): bool
    {
        if (str_contains($routeName, '*')) {
            // Wildcard route matching
            $pattern = str_replace('*', '.*', $routeName);
            return (bool) preg_match('/^' . $pattern . '$/', Route::currentRouteName());
        }

        return Route::currentRouteName() === $routeName;
    }

    private function isActiveUrl(string $url): bool
    {
        // Handle placeholder URLs (dropdowns, external menus, etc.)
        // These should never be active
        if (empty($url) || $url === '#' || str_starts_with($url, 'javascript:')) {
            return false;
        }

        // Parse URLs
        $currentUrl = request()->url();
        $currentPath = parse_url($currentUrl, PHP_URL_PATH);
        $menuPath = parse_url($url, PHP_URL_PATH);

        // Handle null/false paths (invalid URLs)
        if ($menuPath === null || $menuPath === false || $menuPath === '') {
            return false;
        }

        if ($currentPath === null || $currentPath === false) {
            $currentPath = '/';
        }

        // Normalize paths: remove trailing slashes, but keep root as '/'
        $currentPath = $currentPath === '/' ? '/' : rtrim($currentPath, '/');
        $menuPath = $menuPath === '/' ? '/' : rtrim($menuPath, '/');

        // Exact match only
        return $currentPath === $menuPath;
    }

    /**
     * Get active menu item
     */
    public function getActiveMenuItem(): ?array
    {
        $menu = $this->getMainMenu();

        foreach ($menu as $item) {
            if ($item['active']) {
                return $item;
            }

            if (isset($item['children'])) {
                foreach ($item['children'] as $child) {
                    if ($child['active']) {
                        return $child;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Get breadcrumbs for current page
     */
    public function getBreadcrumbs(): array
    {
        $breadcrumbs = [
            ['label' => 'Beranda', 'url' => route('home')]
        ];

        $currentRoute = Route::currentRouteName();

        // About page
        if ($currentRoute === 'about') {
            $breadcrumbs[] = ['label' => 'Tentang'];
        }

        // Artikel pages
        if (str_starts_with($currentRoute, 'artikel.')) {
            $breadcrumbs[] = ['label' => 'Artikel', 'url' => route('artikel.index')];
        }

        // Contact page
        if ($currentRoute === 'contact') {
            $breadcrumbs[] = ['label' => 'Kontak'];
        }

        // Dynamic pages - Parent page
        if ($currentRoute === 'page.show') {
            $parentSlug = request()->route('parent_slug');

            if ($parentSlug) {
                $page = Page::where('slug', $parentSlug)
                    ->where('is_active', true)
                    ->whereNull('parent_id')
                    ->first();

                if ($page) {
                    $breadcrumbs[] = ['label' => $page->title];
                }
            }
        }

        // Dynamic pages - Child page
        if ($currentRoute === 'page.show.child') {
            $parentSlug = request()->route('parent_slug');
            $childSlug = request()->route('child_slug');

            if ($parentSlug && $childSlug) {
                // Find parent first
                $parent = Page::where('slug', $parentSlug)->whereNull('parent_id')->first();
                if ($parent) {
                    $breadcrumbs[] = [
                        'label' => $parent->title,
                        'url' => route('page.show', $parent->slug)
                    ];

                    // Find child under this parent
                    $child = Page::where('slug', $childSlug)
                        ->where('parent_id', $parent->id)
                        ->first();

                    if ($child) {
                        $breadcrumbs[] = ['label' => $child->title];
                    }
                }
            }
        }

        return $breadcrumbs;
    }
}
