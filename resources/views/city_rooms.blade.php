@extends('layout')

@section('body')
    <style>
        .hidden {
            display: none;
        }

        #filterForm {
            margin-top: 20px;
        }
    </style>

    <div>
        <h3>Current weather of {{$city}}</h3>
        <h4>{{$weather['temp_c']}} °C</h4>
        <img src="https:{{$weather['condition']['icon']}}" alt="icon" width="80" class="dropdown-toggle "
             aria-expanded="false" aria-haspopup="true">
        <p>{{$weather['condition']['text']}}</p>
    </div>

    <div class="d-flex justify-content-between align-content-center m-3">
        <h4>Available Rooms</h4>
        <button id="filterButton" class="btn btn-outline-info ">Filter</button>
    </div>

    <div class="container" style="align-content: end">
        <div id="filterForm" class="hidden">
            <form id="filter" onsubmit="applyFilter(event)">
                <div class="row">

                    <div class="col-4">
                        <label for="price">Max daily price:</label>
                        <input type="number" id="price" name="price" min="100" step="1">
                    </div>
                    <div class="form-group">
                        <fieldset>
                            <br>
                            <label>Select Facilities</label>
                            <details>
                                <summary>Select Facilities you want</summary>
                                <ul id="facility-list">
                                    @foreach($facilities as $facility)
                                        <li id="facility">
                                            <label><input type="checkbox" name="facility_id[]"
                                                          value="{{ $facility->id }}">{{ $facility->facility_name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        </fieldset>
                    </div>
                </div>

                <button type="submit" class="btn btn-info">Apply Changes</button>
            </form>
        </div>
    </div>

    @if($filteredRooms->isEmpty())
        <h5 class="bg-body-secondary">No Room match your search</h5>
    @endif

    <div class="room-grid" id="rooms">
        @foreach($filteredRooms as $room)
            <div class="room" id="room-{{$room->id}}">
                <img src="{{ asset('storage/avatars/'.$room->room_pic)}}" alt="icon">
                <h3>{{$room->title}}</h3>
                <p>{{$room->description}}</p>
                <span class="price">${{$room->daily_rent}}/night</span>
                <p class="text-success">{{$room->booking_status}}</p>
                <a href="{{route('room.show',$room->id)}}">Check Details</a>
            </div>
        @endforeach
    </div>

    <script>
        document.getElementById('filterButton').addEventListener('click', function () {
            var filterForm = document.getElementById('filterForm');
            if (filterForm.classList.contains('hidden')) {
                filterForm.classList.remove('hidden');
                document.getElementById('filterButton').textContent = 'Hide Filter';
            } else {
                filterForm.classList.add('hidden');
                document.getElementById('filterButton').textContent = 'Filter';
            }
        });

        function applyFilter(event) {
            event.preventDefault();

            var price = document.getElementById('price').value;
            var facilities = Array.from(document.getElementsByName('facility_id[]'))
                .filter(input => input.checked)
                .map(input => input.value);
            var city = "{{$city}}";
            var start_date = document.getElementById('start_date').value;

            var days = document.getElementById('days').value;


            $.ajax({
                    url: '{{route('filter-rooms')}}',
                    type: 'POST',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'city': city,
                        'price': price,
                        'start_date': start_date,
                        'no_of_days': days,
                        'facility_id': facilities
                    },
                    success: function (response) {
                        if (response.status) {
                            console.log(response)
                            $('#rooms').empty();
                            if (response.rooms.length === 0) {
                                var roomElement = `<div class="text-danger m-4 "><h2>No Rooms Matched your search</h2></div>`;
                                $('#rooms').append(roomElement);

                            }
                            response.rooms.forEach(function (room) {
                                    var roomElement = `
                                              <div class="room" id="room-${room.id}">
                                        <img src="{{ asset('storage/avatars/${room.room_pic}') }}" alt="icon">
                                              <h3>${room.title}</h3>
                                              <p>${room.description}</p>
                                             <span class="price">$${room.daily_rent}/night</span>
                                             <p class="text-success">${room.booking_status}</p>
                                            <a href="{{ url('room/') }}/${room.id}">Check Details</a>
                                              </div>`;

                                    $('#rooms').append(roomElement);
                                }
                            )
                            ;
                        } else {
                            console.error('Error:', response.message);
                        }
                    },
                    error:

                        function (error) {
                            console.error('Error:', error);
                        }
                }
            )
            ;
        }
    </script>
@endsection
