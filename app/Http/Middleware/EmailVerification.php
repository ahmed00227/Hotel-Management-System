<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->email_verified_at!=null) {
            return $next($request);
        }
        else
            $request->session()->put('redirect_from', $request->path());

        return redirect()->route('otp-page')->with('note','Verify your account first to proceed');
    }
}
