<?php

namespace App\Observers;

use App\Jobs\BookingConfirmation;
use App\Mail\ConfirmationMail;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{

    public function stored(Booking $booking): void
    {
       BookingConfirmation::dispatch($booking);
//        Mail::to($booking->user->email)->send(new ConfirmationMail($booking));

    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
