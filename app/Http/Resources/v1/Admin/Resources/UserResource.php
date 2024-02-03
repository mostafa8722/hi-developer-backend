<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "family"=>$this->family ,
            "mobile"=>$this->mobile,
            "body"=>$this->body,
            "username"=>$this->username,
            "api_token"=>$this->api_token,
            "email"=>$this->email,

            "avatar"=>$this->avatar?baseUrl().$this->avatar:null,


        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
