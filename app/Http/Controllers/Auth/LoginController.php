<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Notification;

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
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // return [auth()->attempt($credentials)] ;

    if (auth()->attempt($credentials)) {
        $user = auth()->user();

        $noti = new LoginNotification([
            'name' => $user->name,
            'email' => $user->email,
            'device' => $request->header('User-Agent'),
            'browser' => $request->header('X-Browser') ?: 'N/A',
            'platform' => $request->header('X-Platform') ?: 'N/A',
            'ip_address' => $request->ip(),
            'time' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


        $user->notify($noti);


        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token, 'ip_address' => $request->ip()]);
    } else {

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}


    /**
     * Send login email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    // public function sendLoginEmail(Request $request)
    // {
    //     $agent = new Agent();
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'Invalid login details'], 422);
    //     }
    //     $data = [
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'device' => $agent->device() ?: 'N/A',
    //         'browser' => $agent->browser() ?: 'N/A',
    //         'platform' => $agent->platform() ?: 'N/A',
    //         'ip' => $request->ip(),
    //         'time' => now()->toDateTimeString(),
    //         'loginUrl' => 'https://example.com/dashboard',
    //         'loginText' => 'Go to Dashboard',
    //         'thanks' => 'Thank you for using our service!',
    //     ];

    //     Notification::route('mail', $user->email)
    //    ->notify(new LoginNotification($data));

    //     return 'Email sent successfully!';
    // }


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
