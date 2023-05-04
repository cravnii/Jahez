<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\LoginNotification;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\Contracts\View\View
     */

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

        Notification::route('mail', $user->email)
            ->notify(new LoginNotification(
                $data['name'],
                $data['email'],
                $data['device'],
                $data['browser'],
                $data['platform'],
                $data['ip'],
                $data['time']
            ));

        return view('auth.login', compact('data'));
    }



    /**
     * Login the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();
            $agent = new Agent();
            $device = $agent->device() ?: 'N/A';
            $browser = $agent->browser() ?: 'N/A';
            $platform = $agent->platform() ?: 'N/A';
            $ip_address = $request->ip();
            $time = Carbon::now()->toDateTimeString();


            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'ip' => $ip_address,
                'time' => $time,
                'device'=> $device,
                'browser'=>$browser,
                'platform'=> $platform
            ];

            // Send notification to the user
                $user->notify(new LoginNotification(
                $data['name'],
                $data['email'],
                $data['device'],
                $data['browser'],
                $data['platform'],
                $data['ip'],
                $data['time']
            ));


            // Send delayed email notification to the user
            Notification::route('mail', $user->email)
            ->notify((new LoginNotification(
                $data['name'],
                $data['email'],
                $data['device'],
                $data['browser'],
                $data['platform'],
                $data['ip'],
                $data['time']
            ))->delay(now()->addSeconds(10)));

            // Generate and return an API token
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token, 'ip_address' => $ip_address]);
        } else {
            // Return an error response if authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }



    /**
     * Send login email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function sendLoginEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid login details'], 422);
        }
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'device' => (new Agent())->device(),
            'browser' => (new Agent())->browser(),
            'platform' => (new Agent())->platform(),
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ];


        Notification::route('mail', $user->email)
            ->notify((new LoginNotification(
                $data['name'],
                $data['email'],
                $data['device'],
                $data['browser'],
                $data['platform'],
                $data['ip'],
                $data['time']
            ))->delay(now()->addSeconds(10)));

        return 'Email sent successfully!';
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }



}
