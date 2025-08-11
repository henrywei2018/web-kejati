<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Footer extends Component
{
    public $email;
    public $newsletterMessage = '';
    public $newsletterStatus = '';

    protected $rules = [
        'email' => 'required|email'
    ];

    public function subscribeNewsletter()
    {
        $this->validate();

        try {
            // Here you would implement your newsletter subscription logic
            // For example, save to database, send to email service, etc.
            
            $this->newsletterMessage = 'Success! You\'ve been added to our email list.';
            $this->newsletterStatus = 'success';
            $this->reset('email');
            
        } catch (\Exception $e) {
            $this->newsletterMessage = 'An error occurred. Please try again.';
            $this->newsletterStatus = 'error';
        }
    }

    public function render()
    {
        return view('livewire.components.footer');
    }
}