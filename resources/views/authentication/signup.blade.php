@extends('authentication.form_layout')
@section('title')
    Signup
@endsection
@section('form')
    <div class="col-md-5 form-container">
        <h2 class="form-title">Signup Form</h2>
        <form action="{{route('signup')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                       placeholder="Enter your full name" required>
                <div class="form-text text-danger">@error('name') {{ $message }} @enderror</div>
            </div>
            <div class="form-group ">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       placeholder="Enter your email" required>
                <div class="form-text text-danger">@error('email') {{ $message }} @enderror</div>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       name="password" placeholder="Enter your password" required>
                <div class="form-text text-danger">@error('password') {{ $message }} @enderror</div>
            </div>
            <div class="form-group">
                <label for="confirm-password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                       id="confirm-password" name="password_confirmation" placeholder="Confirm your password" required>
                <div class="form-text text-danger">@error('password_confirmation') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="profile_pic" class="form-label">Profile Picture</label>
                <input name="profile_pic" type="file"
                       class="form-control @error('profile_pic') is-invalid @enderror">
                <div class="form-text text-danger">@error('profile_pic') {{ $message }} @enderror</div>

            </div>
            <button type="submit" class="btn btn-success btn-blo me-2ck">Sign Up</button>
            <a href="{{route('login-page')}}" class="text-success"><strong>Already registered?</strong></a>
        </form>
    </div>
@endsection
