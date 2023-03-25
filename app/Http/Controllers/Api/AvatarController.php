<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Rules\ExistsCustom;

class AvatarController extends Controller
{
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profileIMG' => 'required|image',
                'idUser' => ['integer', new ExistsCustom("users", "id")],
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

        if (!empty($validatedData["idUser"])) {
            $user = User::find($validatedData["idUser"]);
        } else {
            $user = User::find($request->user()->id);
        }

        $this->authorize('update', $user);

        $imageStoreName = time() . '.' . $validatedData['profileIMG']->getClientOriginalExtension();
        $validatedData['profileIMG']->move(public_path('avatars'), $imageStoreName);

        $user->profileIMG = $imageStoreName;

        if ($user->save()) {
            return response()->json(
                [
                    'messsage' => "your profileIMG has been updated",
                    'profileIMG' => $imageStoreName,
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
