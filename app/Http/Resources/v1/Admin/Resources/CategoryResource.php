<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "user_id"=>$this->user_id,
            "color"=>$this->color,
            "title"=>$this->title,
            "status"=>$this->status,
            "image"=>$this->image?baseUrl().$this->image:null,
            "body"=>$this->body,

        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
