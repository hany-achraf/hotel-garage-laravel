<?php

namespace App\Livewire\Forms;

use App\Models\SecurityGuard;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddSecurityGuardForm extends Form
{
    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        SecurityGuard::create([
            'user_id' => $user->id,
        ]);

        $this->reset();
    }
}
