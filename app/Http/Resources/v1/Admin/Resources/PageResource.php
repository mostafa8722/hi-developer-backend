<?php

namespace App\Http\Resources\v1\Admin\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            "body"=>$this->body,
            "abstract"=>$this->abstract,
            "slug"=>$this->slug,
            "status"=>$this->status,
            "images"=>$this->images,
            "tags"=>$this->tags,
        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
