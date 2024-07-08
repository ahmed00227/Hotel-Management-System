<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Owners Index</title>
    <link rel="stylesheet" href="{{asset('assets/table.css')}}">

</head>
<body>
@include('header')
<div class="container">
    <h1>List Of Website Users</h1>
    <a href="{{route('user.show')}}" class="btn btn-outline-danger">Back to Profile</a>
    <table class="index-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>View Bookings</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>@if($user->role==1)
                        Admin
                    @elseif($user->role==2)
                        Renter
                    @else
                        Customer
                    @endif</td>
                <td><a href="{{route('show-bookings',$user->id)}}" class="btn btn-outline-info">Booking History</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
