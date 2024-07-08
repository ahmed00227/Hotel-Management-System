<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Creation Form</title>
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px); /* Adjust the height based on the navbar */
            padding-top: 100px; /* Ensure the form is below the navbar */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 1000px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
            width: 45%;
            padding: 8px;

        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select,
        .form-group input[type="file"] {
            width: 50%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .full-width {
            width: 100%;
        }
    </style>
</head>
<body>
@include('header')
{{$errors}}
<div class="form-container">
    <form method="post" action="{{route('room.store')}}" enctype="multipart/form-data">
        @csrf
        <h2>Room Creation Form</h2>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" maxlength="80" required>
        </div>
        <div class="form-group full-width">
            <label for="description">Room Description</label>
            <textarea id="description" name="description" maxlength="300" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Per Night Price</label>
            <input type="number" id="price" name="daily_rent" required>
            <label for="room_pic">Room Picture</label>
            <input type="file" id="room_pic" name="room_pic" required>
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <select id="country" name="country" required>
                <option value="">Select a country</option>
                <option value="United States">United States</option>
                <option value="Canada">Canada</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="Australia">Australia</option>
                <option value="Japan">Japan</option>
                <option value="China">China</option>
                <option value="India">India</option>
                <option value="Brazil">Brazil</option>
                <option value="Russia">Russia</option>
                <option value="Mexico">Mexico</option>
                <option value="Italy">Italy</option>
                <option value="Spain">Spain</option>
                <option value="South Korea">South Korea</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Turkey">Turkey</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Argentina">Argentina</option>
            </select>
            <label for="city">City</label>
            <select id="city" name="city" required disabled>
                <option value="">Select a city</option>
                <!-- Add city options here -->
            </select>
        </div>
        <div class="row">
            <div class="form-group full-width col-4">
                <fieldset>
                    <br>
                    <label><strong>Select Facilities </strong></label>
                    <details>
                        <summary>Select Facilities you want</summary>
                        <ul id="facility-list">
                            @foreach($facilities as $facility)
                                <li>
                                    <label><input type="checkbox" name="facility_id[]" id="facility-{{$facility->id}}"
                                                  value="{{ $facility->id }}"
                                                  onchange="toggleCondition({{ $facility->id }})">
                                        {{ $facility->facility_name }}</label>
                                    <div style="display: none" id="condition-{{$facility->id}}">
                                        <label for="condition">
                                            Facility Condition
                                        </label>
                                        <select id="condition-{{$facility->id}}-select" name="facility_condition[]">
                                            <option value="">choose an option</option>
                                            <option value="1">Good</option>
                                            <option value="2">Excellent</option>
                                            <option value="3">Premium</option>
                                        </select>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </details>
                </fieldset>
            </div>
            <div class="form-group full-width col-8">
                <label for="address">Address</label>
                <textarea id="address" name="address" maxlength="200" rows="3" required></textarea>
            </div>
        </div>
        <button type="submit">Create Room</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
    function toggleCondition(facilityId) {
        var checkbox = document.getElementById('facility-' + facilityId);
        var conditionDiv = document.getElementById('condition-' + facilityId);
        var selectBox = document.getElementById('condition-' + facilityId + '-select');

        if (checkbox.checked) {
            conditionDiv.style.display = 'block';
        } else {
            conditionDiv.style.display = 'none';
            selectBox.value = '';  // Reset select box to default value
        }
    }

    $(document).ready(function () {
        $('#country').change(function () {
            const selectedCountry = $(this).val();

            if (selectedCountry) {
                $('#city').prop('disabled', false);

                // Make AJAX call to Laravel backend
                $.ajax({
                    url: '{{route('city-country')}}', // Replace with your actual API endpoint
                    type: 'POST',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'country': selectedCountry
                    },
                    success: function (response) {
                        console.log(response)
                        // Clear existing options in dependent dropdown
                        $('#city').empty();
                        if (response && Array.isArray(response.cities)) {
                            response.cities.forEach(function (city) {
                                const newOption = $('<option>').val(city).text(city);
                                $('#city').append(newOption);
                            });
                        } else {
                            console.error('Unexpected response format or empty cities array:', response);
                            // Handle unexpected response or empty cities array
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching data:', error);
                        // Handle errors gracefully (e.g., display an error message)
                    }
                });
            } else {
                $('#city').prop('disabled', true);
                $('#city').empty(); // Clear options
            }
        });
    });
</script>
</body>
</html>
