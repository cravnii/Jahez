<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $user = Auth::user();
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $time = Carbon::now()->toDateTimeString();
        $agent = new Agent();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'device' => $agent->device() ?: 'N/A',
            'browser' => $agent->browser() ?: 'N/A',
            'platform' => $agent->platform() ?: 'N/A',
            'ip' => $ip_address,
            'time' => $time,
            'loginUrl' => 'https://example.com/dashboard',
            'loginText' => 'Go to Dashboard',
            'thanks' => 'Thank you for using our service!',
        ];

        $user->notify(new LoginNotification($data));
    }




    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $data = new LoginNotification([
                'name' => $user->name,
                'email' => $user->email,
                'device' => $request->header('User-Agent'),
                'browser' => $request->header('X-Browser') ?: 'N/A',
                'platform' => $request->header('X-Platform') ?: 'N/A',
                'ip_address' => $request->ip(),
                'time' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            $user->notify($data);

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token, 'ip_address' => $request->ip()]);
        } else {
            return response()->json([
                'massage' => 'email or password in uncorrect'
            ]);
        }
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // Log out the user by invalidating their session
        Auth::logout();

        // Redirect the user to the login page
        return redirect('/login');
    }
}
