@php
    $user=\Illuminate\Support\Facades\Auth::user();
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            transform: translate(-50%, 5px);
            transform-origin: top left;
        }
    </style>
</head>
<body>
<header class="bg-body-secondary bg-success-subtle d-flex p-3 px-5 justify-content-between ">
    <div class="logo text-primary-subtle">
        <a href="{{route('home')}}" class="text-decoration-none text-primary-subtle">
            <img src="{{ asset('storage/avatars/logo')}}" alt="icon" width="50">
        </a>
    </div>
    <nav class="nav">
        <li><a href="{{route('about')}}" class="nav-link text-dark"><strong>About</strong></a></li>
        @if($user!=null)
            <li class="nav-item dropdown">
                <img src="{{ asset('storage/avatars/'.\Illuminate\Support\Facades\Auth::user()->profile_pic)}}" alt="dp"
                     width="40" class="dropdown-toggle rounded-5 " aria-expanded="false" aria-haspopup="true">
                <ul class="dropdown-menu bg-success-subtle">
                    <li><a class="dropdown-item text-dark"
                           href="#">{{\Illuminate\Support\Facades\Auth::user()->name}}</a></li>
                    <hr>
                    <li><a class="dropdown-item text-dark" href="{{route('user.show')}}">My Profile</a></li>

                    <li>
                        <button class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            logout
                        </button>
                    </li>
                </ul>
            </li>
        @else
            <a href="{{route('login-page')}}" class="nav-link text-dark"><strong>Login</strong></a>
        @endif
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-dark" id="exampleModalLabel">Logout Confirmation!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-danger">
                        Are you sure that you want to logout of this site!
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('logout')}}" type="button" class="btn btn-danger">Confirm Logout!</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

@if(session('note'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{session('note')}}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.querySelector('.toast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
