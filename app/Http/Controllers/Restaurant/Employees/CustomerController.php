<?php

namespace App\Http\Controllers\Restaurant\Employees;

use Illuminate\Routing\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UsersResources;
use App\Models\User;


class CustomerController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return response()->json([
            'data' => [
                'users' =>  UsersResources::collection($users),
            ]
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        User::create($validatedData);

        return response()->json(['message' => 'User created successfully'], 201);
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


    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        $user->update($validatedData);

        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User created successfully'], 201);
    }
}
