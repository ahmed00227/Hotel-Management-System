<?php

namespace App\Services;

use App\Jobs\OwnershipConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function showBookings($id)
    {
        return User::findOrFail($id);
    }

    public function createOwner($otp)
    {

        if (Auth::user()->email_verification_otp == $otp) {

            $user = Auth::user();
            $user->email_verification_otp = null;
            $user->owner_since = now();
            $user->role = 2;
            $user->save();
            return true;
        } else
            return false;
    }

    public function owner_request()
    {
        $user = Auth::user();
        $user->email_verification_otp = random_int(1000, 9999);
        $user->save();
        dispatch(new OwnershipConfirmation($user));
        return true;
    }

    public function indexOwners()
    {
        return User::where('role', '=', User::$ownerRole)->get();
    }

    public function indexUsers()
    {
        return User::get();

    }

    public function showOwner($id)
    {
        return User::find($id);
    }
}
