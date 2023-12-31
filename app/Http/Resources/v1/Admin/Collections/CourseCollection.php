<?php

namespace App\Http\Resources\v1\Admin\Collections;

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
            "data"=>$this->collection->map(function($item){

                return [
                    "id"=>$item->id,
                    "user_id"=>$item->user_id,
                    "category_id"=>$item->category_id,
                    "title"=>$item->title,
                    "abstract"=>$item->abstract,
                    "body"=>$item->body,
                    "type"=>$item->type,
                    "slug"=>$item->slug,
                    "images"=>$item->images,
                    "tags"=>$item->tags,
                    "viewCount"=>$item->viewCount,
                    "commentCount"=>$item->commentCount,
                    "time"=>$item->time,
                    "status"=>$item->status,


                ];
            })


        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
