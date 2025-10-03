<?php

namespace App\Services;

use App\Models\Profil;
use Illuminate\Support\Facades\Route;

class NavigationService
{
    /**
     * Get main navigation menu items
     */
    public function getMainMenu(): array
    {
        return [
            [
                'label' => 'Beranda',
                'route' => 'home',
                'url' => route('home'),
                'active' => $this->isActiveRoute('home'),
            ],
            [
                'label' => 'Profil',
                'route' => 'profil.*',
                'url' => '#',
                'active' => $this->isActiveRoute('profil.*'),
                'children' => $this->getProfilMenu(),
            ],
            [
                'label' => 'Tentang',
                'route' => 'about',
                'url' => route('about'),
                'active' => $this->isActiveRoute('about'),
            ],
            [
                'label' => 'Artikel',
                'route' => 'artikel.*',
                'url' => route('artikel.index'),
                'active' => $this->isActiveRoute('artikel.*'),
            ],
            [
                'label' => 'Kontak',
                'route' => 'contact',
                'url' => route('contact'),
                'active' => $this->isActiveRoute('contact'),
            ],
        ];
    }

    /**
     * Get profil submenu items dynamically with nested children
     */
    public function getProfilMenu(): array
    {
        // Get only parent profils (no parent_id)
        $profils = Profil::active()
            ->parents()
            ->ordered()
            ->with(['activeChildren'])
            ->get();

        $menu = [];

        foreach ($profils as $profil) {
            $item = [
                'label' => $profil->title,
                'route' => 'profil.show',
                'url' => route('profil.show', $profil->slug),
                'active' => $this->isActiveRoute('profil.show') && request()->route('slug') === $profil->slug,
            ];

            // Add children if exists
            if ($profil->activeChildren->isNotEmpty()) {
                $item['children'] = [];
                foreach ($profil->activeChildren as $child) {
                    $item['children'][] = [
                        'label' => $child->title,
                        'route' => 'profil.show',
                        'url' => route('profil.show', $child->slug),
                        'active' => $this->isActiveRoute('profil.show') && request()->route('slug') === $child->slug,
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

        // Profil pages
        if (str_starts_with($currentRoute, 'profil.')) {
            $breadcrumbs[] = ['label' => 'Profil', 'url' => route('profil.index')];

            if ($currentRoute === 'profil.show' && request()->route('slug')) {
                $profil = Profil::where('slug', request()->route('slug'))->with('parent')->first();
                if ($profil) {
                    // Add parent breadcrumb if exists
                    if ($profil->parent) {
                        $breadcrumbs[] = [
                            'label' => $profil->parent->title,
                            'url' => route('profil.show', $profil->parent->slug)
                        ];
                    }

                    // Add current page
                    $breadcrumbs[] = ['label' => $profil->title];
                }
            }
        }

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

        return $breadcrumbs;
    }
}
