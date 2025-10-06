<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Services\NavigationService;

class HeaderDetails extends Component
{
    // Public properties that can be passed as props
    public $title = 'Page Title';
    public $badge = '';
    public $breadcrumbs = [];
    public $image = '';
    public $headerIcon = ''; // SVG icon for decoration
    public $backgroundClass = 'bg-primary';
    public $showBreadcrumbs = true;
    public $showImage = true;
    public $showBadge = true;
    public $showIcon = true;
    public $titleClass = 'text-dark text-9 text-lg-12 font-weight-semibold line-height-1 mb-2';
    public $badgeClass = 'badge bg-color-dark-rgba-10 text-light rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-3';
    public $breadcrumbClass = 'breadcrumb d-flex text-3-5 font-weight-semi-bold pb-2 mb-3';
    public $wavesSvg = 'img/demos/accounting-1/svg/waves.svg';
    public $abstractBg = 'img/icons/abstract-bg-1.svg';
    public $animationDelay1 = '0';
    public $animationDelay2 = '200';
    public $autoBreadcrumbs = true; // Auto-load breadcrumbs from NavigationService

    public function mount(
        $title = 'Page Title',
        $badge = '',
        $breadcrumbs = null, // null = auto-load, [] = empty, [...] = custom
        $image = '',
        $headerIcon = '',
        $backgroundClass = 'bg-primary',
        $showBreadcrumbs = true,
        $showImage = true,
        $showBadge = true,
        $showIcon = true,
        $titleClass = 'text-dark text-9 text-lg-12 font-weight-semibold line-height-1 mb-2',
        $badgeClass = 'badge bg-color-dark-rgba-10 text-light rounded-pill text-uppercase font-weight-semibold text-2-5 px-3 py-2 px-4 mb-3',
        $breadcrumbClass = 'breadcrumb d-flex text-3-5 font-weight-semi-bold pb-2 mb-3',
        $wavesSvg = 'img/demos/accounting-1/svg/waves.svg',
        $abstractBg = 'img/icons/abstract-bg-1.svg',
        $animationDelay1 = '0',
        $animationDelay2 = '200',
        $autoBreadcrumbs = true
    ) {
        $this->title = $title;
        $this->badge = $badge;
        $this->backgroundClass = $backgroundClass;
        $this->image = $image;
        $this->headerIcon = $headerIcon;
        $this->showBreadcrumbs = $showBreadcrumbs;
        $this->showImage = $showImage;
        $this->showBadge = $showBadge;
        $this->showIcon = $showIcon;
        $this->titleClass = $titleClass;
        $this->badgeClass = $badgeClass;
        $this->breadcrumbClass = $breadcrumbClass;
        $this->wavesSvg = $wavesSvg;
        $this->abstractBg = $abstractBg;
        $this->animationDelay1 = $animationDelay1;
        $this->animationDelay2 = $animationDelay2;
        $this->autoBreadcrumbs = $autoBreadcrumbs;

        // Auto-load breadcrumbs from NavigationService if not provided
        if ($breadcrumbs === null && $autoBreadcrumbs) {
            $navigationService = app(NavigationService::class);
            $this->breadcrumbs = $navigationService->getBreadcrumbs();
        } else {
            $this->breadcrumbs = is_array($breadcrumbs) ? $breadcrumbs : [];
        }
    }

    public function render()
    {
        return view('livewire.components.header-details');
    }
}