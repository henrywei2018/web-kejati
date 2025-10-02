<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Banner\Category as BannerCategory;
use App\Services\NavigationService;

class Header extends Component
{
    public $currentRoute;
    public $serviceCategories;
    public $mainMenu;
    public $breadcrumbs;

    public function mount()
    {
        $this->currentRoute = request()->route()->getName();
        $this->loadServiceCategories();
        $this->loadNavigation();
    }

    private function loadServiceCategories()
    {
        // Load service categories for navigation dropdown
        $this->serviceCategories = BannerCategory::where('is_active', true)
            ->where(function ($query) {
                $query->where('slug', 'like', '%service%')
                      ->orWhere('slug', 'like', '%layanan%')
                      ->orWhere('name', 'like', '%service%')
                      ->orWhere('name', 'like', '%layanan%');
            })
            ->withCount('banners')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'banners_count' => $category->banners_count
                ];
            });
    }

    private function loadNavigation()
    {
        $navigationService = app(NavigationService::class);
        $this->mainMenu = $navigationService->getMainMenu();
        $this->breadcrumbs = $navigationService->getBreadcrumbs();
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}