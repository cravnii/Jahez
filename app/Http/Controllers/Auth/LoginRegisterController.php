<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function register(){
        return view('auth.register');
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required','unique:users'],
            'gender' => 'required',
            'phone number' => ['required','min:10'],
            'password' => ['required','min:8'],
        ]);
    
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'phone number' => $data['mobile'],
            'password' =>$data['password'],
        ]);

        Auth::login($user);

        return redirect('/home');
    }

    public function login()
    {
        return view('auth.login');
    }

}