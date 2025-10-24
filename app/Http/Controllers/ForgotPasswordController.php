<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordResetCode;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.forgot-password-email');
    }

    // Send code to email
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate random 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete any existing codes for this email
        PasswordResetCode::where('email', $request->email)->delete();

        // Create new code with 5-minute expiration
        PasswordResetCode::create([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(5), // 5-minute expiration
        ]);

        // Send email
        Mail::send('emails.password-reset-code', ['code' => $code], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Code');
        });

        return redirect()->route('password.verify.form')->with([
            'success' => 'Verification code sent to your email! The code will expire in 5 minutes.',
            'email' => $request->email
        ]);
    }

    // Show code verification form
    public function showVerifyForm()
    {
        return view('auth.verify-code');
    }

    // Verify the code
    public function verifyCode(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);

        $resetCode = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();
        if (!$resetCode) {
            return back()->withErrors(['code' => 'Invalid verification code!'])->withInput();
        }

        // Check if code is expired
        if ($resetCode->isExpired()) {
            $resetCode->delete(); // Clean up expired code
            return back()->withErrors(['code' => 'Verification code has expired! Please request a new one.'])->withInput();
        }

        // Code is valid, show password reset form
        return redirect()->route('password.reset.form')->with([
            'email' => $request->email,
            'code' => $request->code
        ]);
    }

    // Show password reset form
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    // Reset the password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        // Verify code again and check expiration
        $resetCode = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$resetCode) {
            return back()->withErrors(['code' => 'Verification code not found!'])->withInput();
        }

        if ($resetCode->isExpired()) {
            $resetCode->delete();
            return back()->withErrors(['code' => 'Verification code has expired! Please start over.'])->withInput();
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // Delete used code
        PasswordResetCode::where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password reset successfully!');
    }

    // Optional: Clean up expired codes (you can run this periodically)
    public function cleanupExpiredCodes()
    {
        $deleted = PasswordResetCode::where('expires_at', '<', Carbon::now())->delete();
        return "Cleaned up $deleted expired codes";
    }
}
