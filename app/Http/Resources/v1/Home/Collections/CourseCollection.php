<?php

namespace App\Http\Resources\v1\Home\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            "articles"=>$this->collection->map(function($item){

                return [
                    "id"=>$item->id,
                    "user_id"=>$item->user_id,
                    "category"=>$item->category,
                    "title"=>$item->title,
                    "abstract"=>$item->abstract,
                    "body"=>$item->body,
                    "type"=>$item->type,
                    "slug"=>$item->slug,
                    "images"=>$item->images,
                    "tags"=>$item->tags,
                    "price"=>$item->price,
                    "viewCount"=>$item->viewCount,
                    "commentCount"=>$item->commentCount,
                    "time"=>$item->time,

                ];
            })


        ];
    }
}
