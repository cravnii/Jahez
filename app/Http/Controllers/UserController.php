<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\Users\UsersResources;
use App\Models\User;


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

    public function store(UserStoreRequest $request)
    {
        $validatedData = $request->validated();
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
            ], 404);
        }

        return response()->json([
            'user' => new UsersResources($user),
        ]);
    }


    public function update(UserUpdateRequest $request,User $user)
    {
        $validatedData = $request->validated();

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

