<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradox - Short-Term Rentals</title>
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .hero {
            position: relative;
            height: 600px;
            background-color: #2980b9; /* Hero background color */
            color: #fff;
            text-align: center;
            padding: 100px 0;
        }

        label {
            color: black;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 40px;
        }

        .search-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 900px;
            margin: 0 auto;
            background-color: #F7F5F5;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-box label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .search-box input[type="text"],
        .search-box input[type="date"],
        .search-box input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-right: 10px;
            width: 180px;
        }

        .search-box input[type="number"] {
            width: 80px;
        }

        .search-box button {
            background-color: #2980b9;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .featured-rooms {
            padding: 50px 0;
            text-align: center;
        }

        .featured-rooms h2 {
            margin-bottom: 40px;
            font-size: 2em;
        }

        .room-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .room {
            width: 300px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 20px;
            text-align: left;
        }

        .room img {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .room h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .hero {
            position: relative;
            height: 600px;
        }

        .room p {
            margin-bottom: 15px;
        }

        .room .price {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .room a {
            background-color: #2980b9;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .why-choose-us {
            padding: 50px 0;
            text-align: center;
        }

        .why-choose-us h2 {
            margin-bottom: 40px;
            font-size: 2em;
        }

        .benefits {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .benefit {
            text-align: center;
            width: 250px;
        }

        .benefit i {
            font-size: 3em;
            margin-bottom: 20px;
            color: #2980b9;
        }

        .benefit h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .benefit p {
            margin-bottom: 15px;
        }

        .search-box-container {
            width: 900px; /* Set a fixed width for the container */
            margin: 0 auto;
        }

        #list {
            width: 30%;
        }

    </style>
</head>
<body>
@include('header')

<main>
    <section class="hero">
        <div class="hero-content">
            <h1>Find Your Perfect Short-Term Stay</h1>
            <p>Explore unique rooms in amazing locations for your next adventure.</p>

            <form action="{{route('city.search')}}" method="post">
                @csrf
                <div class="search-box-container">
                    <div class="search-box">
                        <div>
                            <label for="destination">Destination</label>
                            <input type="text" id="destination" name="city" required
                                   placeholder="Enter your destination" @if(isset($city)) value="{{$city}}" @endif>
                        </div>
                        <div>
                            <label for="checkin">Check-in Date</label>
                            <input type="date" id="start_date" name="start_date" required value="{{session('start_date')}}" >
                        </div>
                        <div>
                            <label for="days">Days</label>
                            <input type="number" min="1" id="days" name="days" required  value="{{session('days')}}" >
                        </div>
                        <button type="submit">Search</button>
                    </div>
                    <div id="list" class="me-5" style="text-align: left;"></div>
                </div>
            </form>
        </div>
    </section>

    <section class="featured-rooms">
        @yield('body')
    </section>

    <section class="why-choose-us">
        <h2>Why Choose Us?</h2>
        <div class="benefits">
            <div class="benefit">
                <i class="fas fa-home"></i>
                <h3>Unique Rooms</h3>
                <p>Discover a variety of rooms to suit your style and budget.</p>
            </div>
            <div class="benefit">
                <i class="fas fa-calendar-alt"></i>
                <h3>Flexible Stays</h3>
                <p>Book your short-term stay for any duration, from a weekend getaway to a business trip.</p>
            </div>
            <div class="benefit">
                <i class="fas fa-star"></i>
                <h3>Local Experiences</h3>
                <p>Explore the city like a local with recommendations and insider tips.</p>
            </div>
        </div>
    </section>

</main>
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script src="https://kit.fontawesome.com/your-fontawesome-kit-code.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $("#destination").on('keyup', function () {
            var city = $(this).val();
            $.ajax({
                url: '{{route('city.list')}}',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'city': city,
                },
                success: function (response) {
                    $("#list").html(response.output);
                },
                error: function (error) {
                    alert(error);
                }
            });
        })
    });
    $(document).on('click', 'li', function () {
        if ($(this).attr('id') !== 'noRoom' && $(this).attr('id') !== 'facility') {
            var city = $(this).text();
            $("#destination").val(city);
            $("#list").html("");
        }
    });
</script>
</body>
</html>
