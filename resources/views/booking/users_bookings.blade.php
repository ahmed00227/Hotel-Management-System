<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Bookings</title>
    <link rel="stylesheet" href="{{asset('assets/table.css')}}">
</head>
<body>
@include('header')
<div class="container">
    <h1>Booking History of {{$user->name}}</h1>
    <a href="{{route('user.show')}}" class="btn btn-outline-danger">Back</a>
    <table class="index-table">
        <thead>
        <tr>
            <th>Booking ID</th>
            <th>Room Title</th>
            <th>Room Owner</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Booking Status</th>
            <th>Total Bill</th>
        </tr>
        </thead>
        <tbody>
        @foreach($user->bookings as $booking)
            <tr>
                <td>{{$booking->id}}</td>
                <td>{{$booking->room->title}}</td>
                <td>{{$booking->room->user->name}}</td>
                <td>{{$booking->start_date}}</td>
                <td>{{$booking->end_date}}</td>
                <td> @if($booking->confirmation_status==\App\Models\Booking::pending)
                        Pending
                    @elseif($booking->confirmation_status==\App\Models\Booking::confirmed)
                        Confirmed
                    @else
                        Rejected
                    @endif</td>
                <td>$ {{$booking->bill}}/-</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>