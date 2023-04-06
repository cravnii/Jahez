<?php

namespace App\Http\Controllers;

use App\Http\Resources\Users\UsersResources;
use App\Models\User;
use App\Rules\PhoneRule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return response()->json([
            'data' => [
               'users'=>  UsersResources::collection($users) ,
            ]
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'gender' => ['required'],
            'password' => ['required', 'string', 'min:8', 'regex:/^[a-zA-Z0-9$#@!%^&*()\-_=+{};:,<.>\/?|[\]~`]+$/'],
            'phone_number' => ['required', new PhoneRule()]

        ]);

        $validatedData['password'] = bcrypt($request->input('password'));

        User::create($validatedData);
        return response()->json([
            'message' => 'User was created successfully'
        ]);
    }

    public function show(User $user)
    {
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 200);
        }

        return response()->json([
            'user' => $user
        ]);
    }



    public function update(Request $request, $user)
    {
        $user = User::find($user);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'phone_number' => 'required'
        ]);

        $validatedData['password'] = bcrypt($request->input('password'));

        $user->update($validatedData);

        return response()->json([
            'message' => 'User was updated successfully'
        ]);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

}

