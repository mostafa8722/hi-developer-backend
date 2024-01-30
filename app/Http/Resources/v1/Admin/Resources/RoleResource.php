<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            "title"=>$this->title,
            "en_title"=>$this->en_title,
            "body"=>$this->body,
            "permissions"=>$this->permissions


        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
