<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Banner\Category as BannerCategory;

class Header extends Component
{
    public $currentRoute;
    public $serviceCategories;
    
    public function mount()
    {
        $this->currentRoute = request()->route()->getName();
        $this->loadServiceCategories();
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
            ->withCount('posts')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'posts_count' => $category->posts_count
                ];
            });
    }
    
    public function render()
    {
        return view('livewire.components.header');
    }
}