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
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        $endpoint_secret= config('services.stripe.webhook');
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

// Handle the event
        switch ($event->type) {
            case 'checkout.session.async_payment_failed':
                $session = $event->data->object;
            case 'checkout.session.async_payment_succeeded':
                $session = $event->data->object;
            case 'checkout.session.completed':
                $session = $event->data->object;
            case 'checkout.session.expired':
                $session = $event->data->object;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }
}
