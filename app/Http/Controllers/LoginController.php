<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $maxAttempts = 5;
        $decaySeconds = 60; // lockout duration in seconds
        $key = $this->throttleKey($request);

        // If locked out, return retryAfter (seconds left)
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            if ($seconds < $decaySeconds && $seconds > 0) {
                $seconds = $decaySeconds;
            }
            return back()
                ->withErrors(['login' => "Too many attempts. Try again in $seconds seconds."],'login')
                ->with('retryAfter', $seconds);
        }

        // Attempt login
        if (Auth::attempt($credentials)) {
            // on success clear attempts and regenerate session
            RateLimiter::clear($key);
            $request->session()->regenerate();
            $user = Auth::user();

            return ($user->role === 'admin')
                ? redirect()->route('admin')
                : redirect()->intended('/');
        }

        // on failure, increment attempts
        RateLimiter::hit($key, $decaySeconds);

        return back()
            ->withErrors(['login' => 'The provided credentials do not match our records.'],'login')
            ->withInput();
    }

    /**
     * Build a throttle key that matches ThrottlesLogins behavior:
     * lowercased email + '|' + IP
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect(route('login'));
    }
}
