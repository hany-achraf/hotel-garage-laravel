<?php

namespace App\Livewire;

use App\Models\Visit;

use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;

use Srmklive\PayPal\Services\PayPal as PayPalClient;



#[Layout('layouts.guest')]
#[Lazy]
class MyVisit extends Component
{
    #[Url('c')]
    public string $qrCode = '';

    public Visit $visit;

    public function mount()
    {
        // sleep(3);
        $this->visit = Visit::where('qr_code', $this->qrCode)->first();
    }

    public function placeholder()
    {
        return <<<'HTML'
            <div class="w-full h-full">
                <svg class="w-5 h-5 m-auto animate-spin">
                    <circle cx="8" cy="8" r="8" stroke="currentColor" stroke-width="2" fill="none"></circle>
                </svg>
            </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.my-visit');
    }

    public function pay()
    {
        $provider = new PayPalClient;
        $provider->getAccessToken();

        // $amount = floor($this->visit->entry_time->diffInHours(now()) * 0.25 * 100) / 100;
        $amount = 8.25;

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "cancel_url" => route('cancelled-payment'),
                "return_url" => route('successful-payment', ['visit_id' => $this->visit->id, 'amount' => $amount])
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount,
                    ],
                ]
            ]
        ]);

        // dd($response);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('cancelled-payment');
        }
    }
}
