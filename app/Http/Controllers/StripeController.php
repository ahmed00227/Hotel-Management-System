<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
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
        $endpoint_secret = config('services.stripe.webhook');
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

// Handle the event
        switch ($event->type) {
            case 'checkout.session.async_payment_failed':
                $session = $event->data->object;
                Log::info($session->metadata);

            case 'checkout.session.async_payment_succeeded':
                $session = $event->data->object;
               // Log::info($session->metadata);

            case 'checkout.session.completed':
                $session = $event->data->object;
                Log::info($session->metadata);
               $booking= Booking::find($session->metadata->booking_id);
               $booking->confirmation_status=1;
               $booking->save();
            case 'checkout.session.expired':
                $session = $event->data->object;
               // Log::info($session->metadata);

            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);

    }
}
