<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthenticationService;
use App\Services\AdministrationService;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $authenticationService;
    protected $administrationService;

    public function __construct(AuthenticationService $authenticationService, AdministrationService $administrationService)
    {
        $this->authenticationService = $authenticationService;
        $this->administrationService = $administrationService;
    }

    public function loginPage()
    {
        return view('authentication.login');
    }

    public function login(LoginRequest $request)
    {
        if ($this->authenticationService->login($request)) {
            $request->session()->regenerate();
            return redirect()->intended(session('redirect_from'))->with('note', 'LoggedIn Successfully.');
        } else {
            return back()->with('note', 'Invalid Credentials');
        }
    }

    public function signupPage()
    {
        return view('authentication.signup');
    }

    public function registration(SignUpRequest $request)
    {
        $this->authenticationService->signup($request);
        return redirect()->intended('/user/verification')->with('note', 'Registration successful');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:4'
        ]);
        if ($this->authenticationService->emailVerification($request->otp)) {
            return redirect()->intended('/', session('redirect_from'))->with('note', 'Your email has been verified successfully');
        } else {
            return 'This token has expired';
        }
    }

    public function show()
    {
        return view('user_profile');
    }

    public function resendEmail()
    {
        $this->authenticationService->resendEmail();
    }

    public function logout()
    {
        $this->authenticationService->logout();
        return redirect()->route('login-page');
    }

    public function showBookings($id)
    {
        if (Auth::user()->role == 1 || Auth::id() == $id) {
            $user = $this->administrationService->showBookings($id);
            return view('booking.users_bookings', compact('user'));
        }
        else
            abort(403,view('errors.403'));
    }

    //owner controller code
    public function createOwner(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        if ($this->administrationService->createOwner($request->otp)) {
            return redirect()->intended(route('home'))->with('note', 'Now you can post your own apartments for rent');
        } else
            return redirect()->back()->with('Invalid token');
    }

    public function owner_request()
    {
        $this->administrationService->owner_request();
        return view('owner_otp');
    }

    public function indexOwners()
    {
        $owners = $this->administrationService->indexOwners();

        return view('owner_index', compact('owners'));
    }

    public function indexUsers()
    {
        $users = $this->administrationService->indexUsers();

        return view('user_index', compact('users'));
    }

    public function showOwner($id)
    {
        if ((Auth::user()->role == User::$ownerRole && Auth::id() != $id) || (Auth::user()->role == User::$customerRole)) {
            abort(403, view('errors.403'));
        }
        $owner = $this->administrationService->showOwner($id);
        return view('owner_rooms', compact('owner'));
    }
}
