<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user instanceof User) {
            return response()->json(['error' => 'Invalid email'], 401);
        }

        $token = Str::random(64);
        $user->forceFill([
            'remember_token' => $token,
        ])->save();

        $notification = new ResetPasswordNotification($token);
        $user->notify($notification);

        return response()->json(['message' => 'Password reset link has been sent to your email.'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user instanceof User) {
            return response()->json(['error' => 'Invalid email or token'], 401);
        }

        if (!hash_equals($user->getRememberToken(), $request->token)) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user->password = bcrypt($request->password);
        $user->setRememberToken(null);
        $user->save();

        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    }
}
