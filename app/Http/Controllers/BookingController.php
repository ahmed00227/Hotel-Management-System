<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{

    public function create($id)
    {
        $room = Room::findOrFail($id);
        return view('booking.create', compact('room'));
    }

    public function store(BookingRequest $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($request->no_of_days - 1);

        $bookingQuery = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            })
            ->where(function ($query) {
                $query->where('confirmation_status', 1)
                    ->orWhere('user_id', Auth::id());
            });

        $booking = $bookingQuery->get();
        $room = Room::find($request->room_id);
        if ($room->user_id == Auth::id()) {
            return back()->with('note', 'This is your own Room you cannot book this');
        }
        if ($booking->isEmpty()) {
            $days = (int)$request->no_of_days;
            Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $request->room_id,
                'start_date' => Carbon::parse($request->start_date),
                'end_date' => Carbon::parse($request->start_date)->addDays($days - 1),
                'bill' => $room->daily_rent * $days,
                'booking_confirmation_token' => Str::random(30),
            ]);
            return redirect()->route('show-bookings', Auth()->id())->with('note', 'Booking was registered and is now pending for confirmation check your email for booking confirmation');
        }
        return redirect()->back()->with('note', 'This Room Is Booked in these dates you cannot requested that');
    }

    public function bookingConfirmation($token)
    {
        $booking = Booking::where('booking_confirmation_token', $token)->first();
        if ($booking != null) {
            if ($booking->confirmation_status == Booking::rejected) {
                return redirect()->route('home')->with('note', 'This Room is already booked by someone else and your booking request was rejected.');
            }
            Booking::where('room_id', $booking->room_id)
                ->where(function ($query) use ($booking) {
                    $query->whereBetween('start_date', [$booking->start_date, $booking->end_date])
                        ->orWhereBetween('end_date', [$booking->start_date, $booking->end_date]);
                })
                ->where('confirmation_status', Booking::pending)->setAttribute('confirmation_status', Booking::rejected);
            $booking->confirmation_status = 1;
            $booking->booking_confirmation_token = null;
            $booking->save();
            return redirect()->route('home')->with('note', 'Booking confirmed successfully');
        } else {
            return redirect()->route('home')->with('note', 'token expired booking confirmation was unsuccessful');
        }
    }

    public function index()
    {
        $bookings = Booking::all();
        return view('booking.index', compact('bookings'));
    }
}
