<?php

namespace App\Http\Resources\v1\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
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
                    "parent_id"=>$item->parent_id,
                    "course_id"=>$item->course_id,
                    "article_id"=>$item->article_id,
                    "episode_id"=>$item->episode_id,
                    "comment"=>$item->comment,
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
