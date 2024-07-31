<?php

namespace App\Livewire;

// use Endroid\QrCode\Bacon\MatrixFactory;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PdfWriter;

use Illuminate\Support\Str;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard');
    }

    public function foo(int $num): void
    {
        $pdf = new \FPDF('P', 'mm');
        $pdfWrite = new PdfWriter();

        for ($i = 0; $i < $num; $i++) {

            $qrCode= QrCode::create('http://192.168.43.2:8000/my-visit?c=' . Str::uuid())
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
                ->setSize(150)
                ->setMargin(10)
                ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
            
            // $matrixFactory = new MatrixFactory();
            // $matrix = $matrixFactory->create($qrCode);

            $pdf->AddPage();

            $result = $pdfWrite->write($qrCode, null, null, ['fpdf' => $pdf]);
        }

        // header('Content-Type: '. $result->getMimeType());

        $result->saveToFile('storage/qr-codes.pdf');

        $this->dispatch('printQrCodePdf', asset('storage/qr-codes.pdf'));
    }
}
