<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">

    <title>Confirmation Email</title>
</head>
<body>
<h1>Hello There,</h1>
<p>

    Greetings, Hope you are having a good day.
</p>
<p>
    This email was sent to inform you that your Booking of room was confirmed from {{$booking->start_date}} till {{$booking->end_date}} on paradox short term retnals
     which costed you ${{$booking->bill}}/-.
</p>
</body>
</html>
