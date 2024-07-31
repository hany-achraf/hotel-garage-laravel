<div class="m-8">
    <div class="flex justify-end">
        <x-button primary class="py-3 mb-4" x-on:click="$openModal('addGateModal')">{{ __('Add Gate') }}</x-button>
    </div>

    <x-modal name="addGateModal">
        <livewire:add-gate-form />
    </x-modal>
    
    <livewire:gate-table />
</div>
