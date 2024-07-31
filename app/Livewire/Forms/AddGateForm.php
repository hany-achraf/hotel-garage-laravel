<?php

// class AddGateForm extends Component
// {
//     public function render()
//     {
//         return view('livewire.add-gate-form');
//     }
// }

namespace App\Livewire\Forms;

use App\Models\Gate;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddGateForm extends Form
{
    #[Validate('required|string')]
    public string $name = '';

    public function save()
    {
        $this->validate();

        Gate::create(['name' => $this->name]);

        $this->reset();
    }
}
