<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Facility;
use App\Models\Room;
use App\Services\CityService;
use App\Services\WeatherService;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    protected $weatherService, $cityservice, $roomService;

    public function __construct(WeatherService $weatherService, CityService $cityService, RoomService $roomService)
    {
        $this->weatherService = $weatherService;
        $this->cityservice = $cityService;
        $this->roomService = $roomService;
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('room.create', compact('facilities'));
    }

    public function store(RoomRequest $request)
    {
        $this->roomService->store($request);
        return redirect()->route('home')->with('note', 'Room registered successfully and Now pending for admins approval.');
    }

    public function index()
    {
        $rooms = Room::simplePaginate(10);
        return view('room.index', compact('rooms'));
    }

    public function show($id)
    {
        $room = Room::with('facilities')->without('bookings')->findOrFail($id);
        $weather = $this->weatherService->weather($room->city, $room->country);
        return view('room.show', compact('room', 'weather'));
    }

    public function roomBookings($id)
    {
        $room = Room::findOrFail($id);
        return view('booking.rooms_bookings', compact('room'));
    }

    public function city_list(Request $request)
    {
        $cities = Room::where('city', 'LIKE', "%$request->city%")->distinct()->pluck('city');
        $output = '<ul class="list-group" style="display: block;position: relative;z-index: 1">';
        if (count($cities) == 0) {
            $output .= '<li class="list-group-item" id="noRoom">No Rooms In the searched city.</li>';
        } else {
            foreach ($cities as $city) {
                $output .= '<li class="list-group-item">' . $city . '</li>';
            }
        }
        $output .= '</ul>';

        return response()->json(['output' => $output]);
    }

    public function city_search(Request $request)
    {
        $request->validate(['city' => 'required',
            'days' => 'required|min:1|max:30|numeric',
            'start_date' => 'required|date'
        ]);
        $country = Room::where('city', $request->city)->select('country')->first();
        if($country!=null)
        {
            $country=$country->country;
        }
        $days = (int)$request->days;
        $start_date = date('Y-m-d', strtotime($request->start_date));
        session()->put('start_date',$start_date);
        session()->put('days',$days);
        $city = $request->city;
        $facilities = Facility::all();
        $filteredRooms =$this->roomService->rooms_availability($request);
        $weather = $this->weatherService->weather($request->city, $country);
        return view('city_rooms', compact('filteredRooms', 'weather', 'city', 'facilities'));
    }

    public function cities(Request $request)
    {
        $cities = $this->cityservice->cities($request->input('country'));

        return response()->json(['status' => 1, 'cities' => $cities, 'country' => $request->country]);

    }

    public function filterRooms(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'price' => 'nullable|numeric|max:1000',
                'no_of_days' => 'nullable|numeric|max:30',
                'start_date' => ['nullable', 'date', 'after_or_equal:' . date('Y-m-d')],
            ]
        );

        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => $validate->errors()]);
        }

        $filteredRooms = $this->roomService->filterRooms($request);
        return response()->json([
            'status' => true,
            'rooms' => $filteredRooms->map(function ($room) {
                return [
                    'id' => $room->id,
                    'room_pic' => $room->room_pic,
                    'title' => $room->title,
                    'description' => $room->description,
                    'daily_rent' => $room->daily_rent,
                    'booking_status' => $room->booking_status,
                ];
            })->toArray(),
        ]);
    }

    public function activate($id)
    {
        $room = Room::find($id);
        $room->status = 1;
        $room->save();
        return back()->with('note', 'Room Activated Successfully');
    }
}
