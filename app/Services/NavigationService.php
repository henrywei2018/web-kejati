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

            // Add children if exists
            if ($nav->activeChildren->isNotEmpty()) {
                $item['children'] = [];
                foreach ($nav->activeChildren as $child) {
                    $item['children'][] = [
                        'label' => $child->computed_label,
                        'route' => $child->type === 'page' && $child->page ? 'page.show' : null,
                        'url' => $child->computed_url,
                        'active' => $this->isActiveUrl($child->computed_url),
                        'target' => $child->target ?? '_self',
                    ];
                }
            }

            $menu[] = $item;
        }

        return $menu;
    }


    /**
     * Get dynamic pages menu items with nested children
     */
    public function getDynamicPagesMenu(): array
    {
        // Get only parent pages (no parent_id) that should appear in navigation
        $pages = Page::active()
            ->parents()
            ->ordered()
            ->with(['activeChildren'])
            ->get();

        $menu = [];

        foreach ($pages as $page) {
            $item = [
                'label' => $page->title,
                'route' => 'page.show',
                'url' => route('page.show', $page->slug),
                'active' => $this->isActiveRoute('page.show') && request()->route('slug') === $page->slug,
            ];

            // Add children if exists
            if ($page->activeChildren->isNotEmpty()) {
                $item['children'] = [];
                foreach ($page->activeChildren as $child) {
                    $item['children'][] = [
                        'label' => $child->title,
                        'route' => 'page.show.child',
                        'url' => route('page.show.child', ['parent_slug' => $page->slug, 'child_slug' => $child->slug]),
                        'active' => $this->isActiveRoute('page.show.child') && request()->route('child_slug') === $child->slug,
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
        $currentPath = parse_url(request()->url(), PHP_URL_PATH);
        $menuPath = parse_url($url, PHP_URL_PATH);
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
