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
    <h1>Room Owners</h1>
    <a href="{{route('user.show')}}" class="btn btn-outline-danger">Back to profile</a>
    <table class="index-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Owner Since</th>
            <th>View Rooms</th>
        </tr>
        </thead>
        <tbody>
        @foreach($owners as $owner)
            <tr>
                <td>{{$owner->id}}</td>
                <td>{{$owner->name}}</td>
                <td>{{$owner->email}}</td>
                <td>{{$owner->owner_since}}</td>
                <td><a href="{{route('owner_show',$owner->id)}}" class="btn btn-outline-info">View Rooms</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
