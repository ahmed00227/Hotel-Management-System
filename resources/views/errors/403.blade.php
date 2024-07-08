<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resource - 403 Forbidden</title>
    <link href={{ asset('assets/style2.css') }} rel="stylesheet">
    <link href={{ asset('assets/style.css') }} rel="stylesheet">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="lock"></div>
<div class="message">
    <h1>Access to this page is restricted</h1>
    <p>Please check with the site admin if you believe this is a mistake.</p>
    <a href="{{route('home')}}" class="text-center btn btn-outline-dark">Return home</a>
</div>


</body>
</html>
