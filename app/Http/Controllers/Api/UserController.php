<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Rules\UniqueCustom;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $this->authorize('view', $user = User::findorFail($request->user()->id));
        return response()->json(
            [
                'user' => new UserProfileResource($user),
            ],
            200,
        );
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', new UniqueCustom("users", "name")]
            ])->stopOnFirstFailure();

            $validatedData = $validator->validate();
        } catch (ValidationException $ex) {
            $error = $ex->validator->errors();
            return response()->json(
                [
                    'error' => $error,
                ],
                $ex->status
            );
        }
        $user = User::findorFail($request->user()->id);
        $user->name = $validatedData["name"];

        if ($user->save()) {
            return response()->json(
                [
                    'success' => 'account is gewijzigd',
                ],
                200,
            );
        }
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', new UniqueCustom("users", "email")],
                'password' => 'required|max:50|min:6',
                'name' => ['required', new UniqueCustom("users", "name")]
            ])->stopOnFirstFailure();

            $validatedData = $validator->validate();
        } catch (ValidationException $ex) {
            $error = $ex->validator->errors();
            return response()->json(
                [
                    'error' => $error,
                ],
                $ex->status
            );
        }

        $user = new user();
        $user->name = $validatedData["name"];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);

        if ($user->save()) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $token = $user->createToken('token')->plainTextToken;
                return response()->json(
                    [
                        'token' => $token,
                    ],
                    201,
                );
            }
        }

        return response()->json(
            [
                'error' => 'Could not register',
            ],
            500
        );
    }
}
