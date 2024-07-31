<?php

use App\Livewire\Forms\AddSecurityGuardForm;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public AddSecurityGuardForm $form;

    public function save(): void
    {
        $this->validate();

        $this->form->save();

        $this->dispatch('guard-added');
    }
}; ?>


<div x-on:guard-added="close" class="w-full">
    <form wire:submit="save">

        <x-card>
            {{-- <x-input icon="user" placeholder="Name" class="mb-4" /> --}}

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-input icon="user" wire:model="form.name" id="name" class="block w-full mt-1" type="text" name="name"
                    required autofocus autocomplete="text" />
                <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>


            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-input icon="at-symbol" wire:model="form.email" id="email" class="block w-full mt-1" type="email"
                    name="email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>


            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-input icon="lock-closed" wire:model="form.password" id="password" class="block w-full mt-1" type="text"
                    name="password" required />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>


            {{-- <x-input icon="lock-closed" placeholder="Password" class="mb-4" /> --}}

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />

                <x-button primary label="Submit" type="submit" />
            </x-slot>
        </x-card>
    </form>

</div>
