<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "first name" => $this->fname,
            "Last name" => $this->sname,
            "Phone" => $this->phone_number,
            "email" => $this->email,
            "base currency" => $this->base_currency,
        ];
    }
}
