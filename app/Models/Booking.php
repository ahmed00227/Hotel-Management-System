<?php

namespace App\Models;

use App\Observers\BookingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ObservedBy([BookingObserver::class])]

class Booking extends Model
{
    const confirmed=1;//Booking was Confirmed
    const pending=0;//Booking is pending For confirmation
    const rejected=2;//Booking Request Was rejected
    use HasFactory;
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
