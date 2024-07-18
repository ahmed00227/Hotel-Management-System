<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $stripePriceId = $request->price_id;

        $quantity = $request->quantity;

        return $request->user()->checkout([$stripePriceId => $quantity], [
            'success_url' => route('checkout-success'),
            'cancel_url' => route('checkout-cancel'),
        ]);
    }
    public function checkoutSuccess()
    {
        return view('checkout.success');
    }
    public function checkoutCancel()
    {
        return view('checkout.cancel');
    }
}
