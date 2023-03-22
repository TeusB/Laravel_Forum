<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{

    public function logOut(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'message' => 'you are signed out',
            ],
            200
        );
    }

    public function authenticate(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
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

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $validatedData['email'])->firstOrFail();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json(
                [
                    'idUser' => $user->id,
                    'token' => $token,
                ],
                200,
            );
        }

        return response()->json(
            [
                'error' => 'invalid combination of email and password',
            ],
            401
        );
    }
}
