@extends('authentication.form_layout')
@section('title')
    Login
@endsection
@section('form')
    <div class="col-md-5 form-container">
        <h2 class="form-title">Login Form</h2>
        <form action="{{route('login')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group ">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       placeholder="Enter your email" required>
                <div class="form-text text-danger">@error('email') {{ $message }} @enderror</div>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       name="password"
                       placeholder="Enter your password" required>
                <div class="form-text text-danger">@error('password') {{ $message }} @enderror</div>
            </div>
            <button type="submit" class="btn btn-success btn-block me-2">login</button>
            <a href="{{route('signup-page')}}" class="text-success"><strong>Don't have an account?</strong></a>
        </form>
    </div>
@endsection
