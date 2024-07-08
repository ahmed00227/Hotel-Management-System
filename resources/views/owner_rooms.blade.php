<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner's Rooms</title>
    <link rel="stylesheet" href="{{asset('assets/table.css')}}">
</head>
<body>
@include('header')
<div class="container">
    <h1>Rooms Owned by {{$owner->name}}</h1>
    <div class="d-flex align-content-center justify-content-between">
        <a href="{{route('user.show')}}" class="btn btn-outline-danger">Back</a>
    @if(Auth()->id()==$owner->id)
    <a href="{{route('room.create')}}" class="btn btn-outline-dark">Post a Room</a>
    @endif
    </div>
    <table class="index-table">
        <thead>
        <tr>
            <th>Room ID</th>
            <th>Room Picture</th>
            <th>Room Title</th>
            <th>Daily Rent</th>
            <th>Room Address</th>
            <th>City</th>
            <th>Current Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($owner->rooms as $room)
            <tr>
                <td>{{$room->id}}</td>
                <td><img src="{{ asset('storage/avatars/'.$room->room_pic)}}" alt="dp" width="90"
                         class="dropdown-toggle rounded-1 " aria-expanded="false" aria-haspopup="true"></td>
                <td>{{$room->title}}</td>
                <td>${{$room->daily_rent}}/-</td>
                <td>{{$room->address}}</td>
                <td>{{$room->city}}</td>
                <td> @if($room->status==0)
                        Inactive
                    @else
                        Active
                    @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
