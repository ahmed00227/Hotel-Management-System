<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Rooms</title>
    <link rel="stylesheet" href="{{asset('assets/table.css')}}">
</head>
<body>
@include('header')
<div class="container">
    <h1>All Rooms</h1>
    <a href="{{route('user.show')}}" class="btn btn-outline-danger">Back</a>

    <table class="index-table">
        <thead>
        <tr>
            <th>Room ID</th>
            <th>Room Picture</th>
            <th>Room Title</th>
            <th>Owner Name</th>
            <th>Daily Rent</th>
            <th>Room Address</th>
            <th>Activation Status</th>
            <th>Activate</th>
            <th>View Room</th>
            <th>Booking History</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{$room->id}}</td>
                <td><img src="{{asset('storage/avatars/'.$room->room_pic)}}" alt="icon" width="70"
                         class="rounded-1 ms-2">
                </td>
                <td>{{$room->title}}</td>
                <td>{{$room->user->name}}</td>
                <td>${{$room->daily_rent}}/-</td>
                <td>{{$room->address}}, {{$room->city}}, {{$room->country}}</td>
                <td>@if($room->status==1)
                        Active
                    @else
                        Inactive
                    @endif</td>
                <td> @if($room->status==0)
                        <a href="{{route('activate',$room->id)}}" class="btn btn-outline-info">Activate</a>
                    @endif
                </td>
                <td>
                    <a href="{{route('room.show',$room->id)}}" class="btn btn-outline-dark">View Room</a>
                </td>
                <td><a href="{{route('room.bookings',$room->id)}}" class="btn btn-outline-success">Check History</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="pagination">
    {{ $rooms->links() }}
</div>
</body>
</html>
