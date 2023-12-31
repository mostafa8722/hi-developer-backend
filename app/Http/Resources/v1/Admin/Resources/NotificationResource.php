<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            "user"=>$this->user,
            "body"=>$this->body,
            "seen"=>$this->seen,
        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
