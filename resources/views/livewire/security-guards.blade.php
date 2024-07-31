
<div class="m-8">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <div class="flex justify-end">
        <x-button primary class="py-3 mb-4" x-on:click="$openModal('addGuardModal')">{{ __('Add Guard') }}</x-button>
    </div>

    <x-modal name="addGuardModal">
        <livewire:add-guard-form />
    </x-modal>
    
    <livewire:security-gurads-table />
</div>
