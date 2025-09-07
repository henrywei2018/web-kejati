<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class AboutUs extends Component
{
    public function render()
    {
        return view('livewire.pages.about-us')->layout('layouts.main', [
                'title' => 'Home - Professional Accounting Services',
                'metaDescription' => 'Professional accounting services to help your business grow. Expert financial solutions, tax planning, and business advisory services.',
                'metaKeywords' => 'accounting, tax planning, business advisory, payroll, financial services'
            ]);
    }
}
