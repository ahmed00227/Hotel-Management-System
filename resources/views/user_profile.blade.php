<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile </title>
    <style>


        body, html {
            height: 100%;
        }



        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            height: 100vh; /* Full viewport height */
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
        }


    </style>
</head>
<body>
@php
    $user=\Illuminate\Support\Facades\Auth::user();
@endphp
@include('header')
<div class="row">
    <div class="sidebar col-2 bg-dark ">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>

            @if(\Illuminate\Support\Facades\Auth::user()->role==1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('owner.index') }}">Owners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('room.index') }}">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('booking.index') }}">Bookings</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('show-bookings',\Illuminate\Support\Facades\Auth::id()) }}">My
                    Bookings</a>
            </li>
            @if(\Illuminate\Support\Facades\Auth::user()->role==3)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('owner_request') }}">Become a Renter</a>
                </li>
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->role!=3)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('owner_show',\Illuminate\Support\Facades\Auth::id()) }}">My
                        rooms</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a>
            </li>
        </ul>
    </div>
    <div class="container col-6 mt-5 col col-4">
        <h1 class="text-center mb-3">My Profile</h1>

        <table class="table table-striped table-bordered">
            <tr>

                <th>Profile Picture</th>
                <td>
                    <div>

                        <img
                            src="{{ asset('storage/avatars/' . $user->profile_pic)}}" alt="dp" width="100"
                            class=" rounded-4 " aria-expanded="false" aria-haspopup="true">
                    </div>
                </td>
            </tr>
            <tr>
                <th width="200px">User Name :</th>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <th width="200px">User Role :</th>
                <td>@if($user->role==1)
                        Admin
                    @elseif($user->role==2)
                        Renter
                    @else
                        Customer
                    @endif</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{$user->email}}</td>
            </tr>

            <tr>
                <td>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{route('home')}}" class="btn btn-outline-dark ">Back to home</a>
                </div>
            </td>
        </tr>
    </table>
</div>
</div>
</body>
</html>
