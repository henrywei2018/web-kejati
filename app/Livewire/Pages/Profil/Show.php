<?php

namespace App\Livewire\Pages\Profil;

use App\Models\Profil;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Show extends Component
{
    public Profil $profil;

    public function mount($slug)
    {
        $this->profil = Profil::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    #[Layout('layouts.app')]
    #[Title('')]
    public function render()
    {
        return view('livewire.pages.profil.show')
            ->title($this->profil->title);
    }
}
