<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Creation</title>
</head>
<body>

@include('header')
<h1 class="text-center m-4">Booking creation Form</h1>
<div class="container mx-auto border border-opacity-25 rounded-1 border-black col-7">
    <form action="{{route('booking.store')}}" method="post">
        @csrf
        <input type="number" hidden name="room_id" value="{{$room->id}}">
        <div class="row">
            <div class="m-2 col-6">
                <label for="Title">Room Title:</label>
                <input type="text" id="Title" value="{{$room->title}}" disabled class="border-opacity-25 border">
            </div>
            <div class="m-2 col-5">
                <label for="date">Start Date:</label>
                <input type="date" id="date" value="{{session('start_date')}}" name="start_date"
                       class="border-opacity-25 border ">
            </div>
        </div>
        <div class="row">
            <div class="m-2 col-6">
                <label for="rent">Daily Rent ($):</label>
                <input type="number" id="rent" value="{{$room->daily_rent}}" disabled
                       class="border-opacity-25 border me-2">
            </div>
            <div class="m-2 col-5">
                <label for="days">Days of Stay:</label>
                <input type="number" min="1" id="days" name="no_of_days" value="{{session('days')}}" required
                       class="border-opacity-25 border me-2">
            </div>

        </div>
        <input type="submit" class="btn btn-success m-2 " value="Confirm Booking">
    </form>
</div>
<script>

</script>
</body>
</html>
