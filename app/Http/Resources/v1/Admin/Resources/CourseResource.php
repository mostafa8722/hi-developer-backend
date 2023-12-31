<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            "category_id"=>$this->category_id,
            "title"=>$this->title,
            "abstract"=>$this->abstract,
            "body"=>$this->body,
            "type"=>$this->type,
            "slug"=>$this->slug,
            "images"=>$this->images,
            "tags"=>$this->tags,
            "viewCount"=>$this->viewCount,
            "commentCount"=>$this->commentCount,
            "time"=>$this->time,
            "status"=>$this->status,

        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
