<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PdfWriter;

use Livewire\Volt\Component;

new class extends Component {

    public function foo(): void
    {
        $pdf = new PdfWriter();
        $pdf->setMode(PdfWriter::MODE_AUTOMATIC);
        $pdf->setWidth(250);
        $pdf->setHeight(250);

        $outputFile = storage_path('app/qr-codes.pdf');

        for ($i = 0; $i < 10; $i++) {
            $uuid = Str::uuid();
            $qrCode = new QrCode($uuid);
            $pdf->addQrCode($qrCode);
            $pdf->newPage();
        }

        $pdfData = $pdf->output();
        file_put_contents($outputFile, $pdfData);

        $this->dispatchBrowserEvent('printQrCodePdf', [
            'url' => asset('storage/qr-codes.pdf'),
        ]);
    }

}; ?>

<x-app-layout>
    <div class="fixed flex w-full h-full">
        <x-button class="py-6 m-auto" x-on:click="$wire.foo()">
            {{ __('Generate QR Codes') }}
        </x-button>
    </div>
</x-app-layout>
