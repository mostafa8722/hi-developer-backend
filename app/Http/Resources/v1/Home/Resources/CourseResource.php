<?php

namespace App\Http\Resources\v1\Home\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "course"=>[
                "id"=>$this->id,
                "user_id"=>$this->user_id,
                "category_id"=>$this->category_id,
                "title"=>$this->title,
                "abstract"=>$this->abstract,
                "body"=>$this->body,
                "type"=>$this->type,
                "slug"=>$this->slug,
                "images"=>$this->images,
                "price"=>$this->price,
                "tags"=>$this->tags,
                "viewCount"=>$this->viewCount,
                "commentCount"=>$this->commentCount,
                "time"=>$this->time,

            ]
        ];
    }
}
