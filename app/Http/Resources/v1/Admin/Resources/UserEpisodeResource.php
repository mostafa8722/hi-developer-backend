<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEpisodeResource extends JsonResource
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
            "mobile"=>$this->mobile,
            "username"=>$this->username,
            "email"=>$this->email,
            "status"=>$this->status,
            "avatar"=>$this->avatar,
            "body"=>$this->body,
        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
