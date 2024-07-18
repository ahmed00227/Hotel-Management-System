<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Services\StripeService;
class RoomService
{
    /**
     * Create a new class instance.
     */
    protected $stripeService;
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService=$stripeService;
    }

    public function store($request)
    {
        $name = time() . '_room_' . $request->room_pic->getClientOriginalName();
        $request->file('room_pic')->storeAs('public/avatars', $name);
        $room = Room::create([
            'description' => $request->description,
            'title' => $request->title,
            'address' => $request->address,
            'daily_rent' => $request->daily_rent,
            'city' => $request->city,
            'country' => $request->country,
            'user_id' => Auth::id(),
            'status' => 0,
            'price_id'=>$this->stripeService->createProductAndPrice($request),
            'room_pic' => $name
        ]);

        if (!empty($request->facility_id)) {
            $facility = [];
            $i = 0;

            foreach ($request->facility_condition as $condition) {
                if ($condition != null) {
                    $facility[$request->facility_id[$i]] = ['facility_condition' => $condition];
                    $i++;
                }
            }

            $room->facilities()->attach($facility);
        }
    }

    public function rooms_availability($request)
    {
        $rooms = Room::where('city', $request->city)->where('status', 1)->get();

        return $rooms->map(function ($room) use ($request) {
            $endDate = date('Y-m-d', strtotime($request->start_date . ' + ' . ($request->no_of_days - 1) . ' days'));
            $room->bookings->each(function ($booking) use ($request, $endDate, $room) {
                $bookingStartDate = date('Y-m-d', strtotime($booking->start_date));
                $bookingEndDate = date('Y-m-d', strtotime($booking->end_date));

                if (($request->start_date >= $bookingStartDate && $request->start_date <= $bookingEndDate) ||
                    ($endDate >= $bookingStartDate && $endDate <= $bookingEndDate)) {
                    if ($booking->confirmation_status == 1)
                        $room->booking_status = 'BOOKED';
                } else
                    $room->booking_status = 'AVAILABLE';
            });
            return $room;
        });

    }

    public function filterRooms($request)
    {
        $query = Room::where('city', $request->city)->where('status', 1);
        if ($request->price !== null) {
            $query->where('daily_rent', '<=', $request->price);
        }
        if ($request->facility_id !== null) {
            $facilityIds = array_map('intval', $request->facility_id); // Convert strings to integers
            $query->whereHas('facilities', function ($q) use ($facilityIds) {
                $q->whereIn('facility_id', $facilityIds);
            }, '=', count($facilityIds));
        }

        $rooms = $query->get();

        $filteredRooms = $rooms->map(function ($room) use ($request) {
            $room->booking_status = 'zero';

            if ($request->has('start_date') && $request->start_date !== null && $request->has('no_of_days') && $request->no_of_days !== null) {
                $endDate = date('Y-m-d', strtotime($request->start_date . ' + ' . ($request->no_of_days - 1) . ' days'));

                $room->bookings->each(function ($booking) use ($request, $endDate, $room) {

                    $bookingStartDate = date('Y-m-d', strtotime($booking->start_date));
                    $bookingEndDate = date('Y-m-d', strtotime($booking->end_date));

                    if ((($request->start_date >= $bookingStartDate && $request->start_date <= $bookingEndDate) ||
                            ($endDate >= $bookingStartDate && $endDate <= $bookingEndDate)) && $booking->confirmation_status == 1) {
                        $room->booking_status = 'booked';
                    } else
                        $room->booking_status = 'available';
                });
            }

            return $room;
        });

        return $filteredRooms;
    }
}
