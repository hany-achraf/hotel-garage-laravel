<div class="fixed flex w-full h-full">
    <x-button class="py-6 m-auto" x-on:click="$openModal('generateQrCodesModal')">
        {{ __('Generate QR Codes') }}
    </x-button>

    <x-modal x-data="{ num: 0 }" name="generateQrCodesModal">
        <x-card>
            <x-slot name="title">
                {{ __('Generate QR Codes') }}
            </x-slot>

            <x-number label="How many you want to generate and print?" placeholder="0" x-model="num" />

            <x-slot name="footer" class="flex justify-end">
                <x-button flat x-on:click="close">
                    {{ __('Cancel') }}
                </x-button>

                <x-button primary x-on:click="$wire.foo(num)">
                    {{ __('Generate') }}
                </x-button>
            </x-slot>
        </x-card>
    </x-modal>
</div>

@script
<script>
    Livewire.on('printQrCodePdf', url => {
        const printWindow = window.open(url);
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    });
</script>
@endscript