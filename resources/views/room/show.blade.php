<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Room Details</title>
</head>
<body>
@include('header')

<div class="row">
    <div class="col-7 p-3">
        <img src="{{asset('storage/avatars/'.$room->room_pic)}}" alt="icon" width="700" class="rounded-1 ms-2">
    </div>
    <div class="container col-4 border border-black border-opacity-25 rounded-1 m-4 shadow">
        <h2 class="mt-4 ms-2">Title:- {{$room->title}}</h2>
        <h4 class="mt-3 ms-2">Per Night : ${{$room->daily_rent}}/-</h4>
        <h4 class="mt-4 ms-2">Location:- {{$room->address}}, {{$room->city}}, {{$room->country}}</h4>
        <p>
            <strong class="mt-1 ms-2">Description: </strong>{{$room->description}}
        </p>
        <h5 class="mt-2 ms-2">Facilities :</h5>
        <ul>
            @foreach($room->facilities as $facility)
                <li>
                    {{$facility->facility_name}}
                    ----@if($facility->pivot->facility_condition==1)
                        Good
                    @elseif($facility->pivot->facility_condition==2)
                        Excellent
                    @else
                        Premium
                    @endif Condition

                </li>
            @endforeach
        </ul>
{{--        <a href="{{route('booking.create',$room->id)}}"  class="btn btn-lg btn-outline-success">Book Now</a>--}}
        <a href="{{route('booking.create',$room->id)}}"  class="btn btn-lg btn-outline-success">Book Now</a>
    </div>
</div>
</body>
</html>
