<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Visits extends Component
{
    public function render()
    {
        return view('livewire.visits');
    }
}
