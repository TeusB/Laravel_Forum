<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Rules\ExistsCustom;


class PasswordController extends Controller
{
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'repeatPassword' => 'required',
                'newPassword' => 'required|min:5|max:1000',
                'idUser' => ['integer', new ExistsCustom("users", "id")],
            ])->stopOnFirstFailure();

            $validatedData = $validator->validate();
        } catch (ValidationException $ex) {
            $error = $ex->validator->errors()->first();
            return response()->json(
                [
                    'error' => $error,
                ],
                $ex->status
            );
        }

        if (!empty($validatedData["idUser"])) {
            $user = User::find($validatedData["idUser"]);
        } else {
            $user = User::find($request->user()->id);
        }

        $this->authorize('update', $user);

        $user->password = Hash::make($validatedData["password"]);

        if ($user->save()) {
            return response()->json(
                [
                    'messsage' => "your account has been updated",
                ],
                200
            );
        }

        return response()->json(
            [
                'error' => "could not update account",
            ],
            500
        );
    }
}
