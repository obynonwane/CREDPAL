<?php

namespace App\Http\Resources;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->resource;

        //Get the User Token
        $token = JWTAuth::fromUser($user);
        return [
            "user" => [
                "id" => $this->id,
                "email" => $this->email,
                "first_name" => $this->sname,
                "last_name" => $this->sname,
                "phone" => $this->phone_number,
                "base_currency" => $this->base_currency

            ],

            "token" => $token
        ];
    }
}
