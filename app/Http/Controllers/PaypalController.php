<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            Transaction::create([
                'visit_id' => $request['visit_id'],
                'amount' => $request['amount'],
                'transaction_type' => 'payment',
                'payment_method' => 'paypal',
            ]);
            return view('success');
        } else {
            return redirect()->route('cancelled-payment');
        }
    }

    public function cancelled()
    {
        return view('cancelled');
    }
}
