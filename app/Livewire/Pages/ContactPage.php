<?php

namespace App\Livewire\Pages;

use App\Models\ContactUs;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ContactPage extends Component
{
    #[Validate('required|string|max:255')]
    public $firstname = '';

    #[Validate('required|string|max:255')]
    public $lastname = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('required|string|max:20')]
    public $phone = '';

    #[Validate('nullable|string|max:255')]
    public $company = '';

    #[Validate('required|string|max:255')]
    public $subject = '';

    #[Validate('required|string|min:10')]
    public $message = '';

    public $showSuccessMessage = false;

    public function submit()
    {
        $this->validate();

        ContactUs::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => 'new',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->reset([
            'firstname',
            'lastname',
            'email',
            'phone',
            'company',
            'subject',
            'message'
        ]);

        $this->showSuccessMessage = true;
    }

    public function closeSuccessMessage()
    {
        $this->showSuccessMessage = false;
    }

    public function render()
    {
        return view('livewire.pages.contact-page')->layout('layouts.main', [
            'title' => 'Hubungi Kami - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Hubungi Kejaksaan Tinggi Kalimantan Utara untuk informasi lebih lanjut',
            'metaKeywords' => 'kontak, hubungi kami, kejaksaan tinggi kaltara'
        ]);
    }
}
