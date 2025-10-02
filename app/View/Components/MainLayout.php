<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MainLayout extends Component
{
    public $title;
    public $metaDescription;
    public $metaKeywords;
    public $bodyClass;

    public function __construct(
        $title = 'Kejaksaan Tinggi',
        $metaDescription = 'Kejaksaan Tinggi - Kalimantan Utara',
        $metaKeywords = 'WebSite Template',
        $bodyClass = ''
    ) {
        $this->title = $title;
        $this->metaDescription = $metaDescription;
        $this->metaKeywords = $metaKeywords;
        $this->bodyClass = $bodyClass;
    }

    public function render()
    {
        return view('layouts.main');
    }
}