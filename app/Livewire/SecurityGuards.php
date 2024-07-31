<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SecurityGuards extends Component
{
    public function render()
    {
        return view('livewire.security-guards');
    }
}
