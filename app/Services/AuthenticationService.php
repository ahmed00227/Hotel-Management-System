<?php

namespace App\Services;

use App\Jobs\SignUpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function login($credentials)
    {
        if (Auth::attempt(['email' => $credentials->email, 'password' => $credentials->password])) {
            return true;
        } else {
            return false;
        }
    }

    public function signup($request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->email;
        if ($request->hasFile('profile_pic')) {
            $name = time() . '_userDP_' . $request->profile_pic->getClientOriginalName();
            $request->file('profile_pic')->storeAs('public/avatars', $name);
            $user->profile_pic = $name;
        }
        $user->email_verification_otp = random_int(1000, 9999);
        $user->save();
        dispatch(new SignUpMail($user));
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        $request->session()->regenerate();

    }

    public function emailVerification($otp)
    {

        $user = Auth::user();
        if ($user->email_verification_otp == $otp) {
            $user->email_verified_at = now();
            $user->email_verification_otp = null;
            $user->save();
            return true;
        } else {
            return false;
        }
    }

    public function resendEmail()
    {
        $user = Auth::user();
        $user->email_verification_otp = random_int(1000, 9999);
        $user->save();
        dispatch(new SignUpMail($user));
        return redirect()->back()->with('note', 'Email sent successfully');
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
    }
}
