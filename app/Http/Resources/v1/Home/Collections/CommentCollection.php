<?php

namespace App\Http\Resources\v1\Home\Collections;

use App\Models\Course;
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
            "comments"=>$this->collection->map(function($item){


                return [
                    "id"=>$item->id,
                    "comment"=>$item->comment,
                    "user"=>[
                        "name"=>$item->user->name." ".$item->user->family,
                        "image"=>baseUrl().$item->user->avatar,
                    ],


                ];
            })


        ];
    }
}
