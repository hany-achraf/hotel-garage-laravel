<?php

use App\Livewire\Forms\AddGateForm;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public AddGateForm $form;

    public function save(): void
    {
        $this->validate();

        $this->form->save();

        $this->dispatch('gate-added');
    }
}; ?>


<div x-on:gate-added="close" class="w-full">
    <form wire:submit="save">
        <x-card>
            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-input icon="bars-3" wire:model="form.name" id="name" class="block w-full mt-1" type="text" name="name"
                    required autofocus autocomplete="text" />
                <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />

                <x-button primary label="Submit" type="submit" />
            </x-slot>
        </x-card>
    </form>

</div>
