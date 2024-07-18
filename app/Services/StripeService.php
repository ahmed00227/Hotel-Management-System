<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;

class StripeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createProductAndPrice($room)
    {
        $product = Product::create([
            'name' => $room->title,
            'description' => $room->description,
        ]);

        $price = Price::create([
            'product' => $product->id,
            'unit_amount' => $room->daily_rent * 100,
            'currency' => 'usd',
        ]);
        return $price->id;
    }
    public function webhook()
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

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
                return response()->json(['error' => 'Unhandled event type'], 400);
        }

        return response()->json(['status' => 'success','data'=>$session]);
    }
}
