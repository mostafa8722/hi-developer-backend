<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            "viewCount"=>$this->viewCount,
            "commentCount"=>$this->commentCount,
            "category_id"=>$this->category_id,
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
