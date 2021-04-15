<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;

use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    //
    public function index(){
        Gate::authorize('view', 'users');
        $users = User::paginate();
        return UserResource::collection($users);
    }

    public function show(User $user){
        Gate::authorize('view', 'users');
        return new UserResource($user);
    }

    public function store(UserCreateRequest $request){
        Gate::authorize('edit', 'users');
        $user = User::create($request->only('first_name', 'last_name', 'email', 'role_id')+[
            'password' => Hash::make(1234),
        ]);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }


    public function update(UserUpdateRequest $request, User $user){
        Gate::authorize('edit', 'users');
        $user->update($request->only('first_name', 'last_name', 'email' , 'role_id'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }


    public function destroy(User $user){
        Gate::authorize('edit', 'users');
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function user(){
        $user = auth()->user();
        return (new UserResource($user))->additional([
            'data'=> [
                'permissions' => $user->permissions(),
            ]
        ]);
    }


    public function updateInfo(UpdateInfoRequest $request){
        $user = auth()->user();
        $user->update($request->only('first_name', 'last_name', 'email'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }


    public function updatePassword(UpdatePasswordRequest $request){
        $user = auth()->user();
        $user->update([
            "password" => Hash::make($request->input('password')),
        ]);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }


}
