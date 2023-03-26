<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthenticateResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
            'is_admin' => $this->is_admin,
            'name' => $this->name,
            'profileIMG' => $this->profileIMG,
            'email' => $this->email,
            'idUser' => $this->id,
        ];
    }
}
