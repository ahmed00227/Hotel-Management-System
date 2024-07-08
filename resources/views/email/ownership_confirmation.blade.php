<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">

    <title>Ownership Confirmation Email</title>
</head>
<body>
<h1>Hello There,</h1>
<p>

    Greetings, Hope you are having a good day.
</p>
<p>
    This email was used to request the Renter status on paradox campus management system.If you haven't Done that then
    you can ignore this mail but if you did this
    then use this otp to verify
</p>
<h2>{{$user->otp}}</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam, beatae dicta ea eaque eum expedita impedit
    magni minima, nobis quos repellendus, soluta vero voluptate voluptates? Ea ex possimus quae!</p>


</body>
</html>
