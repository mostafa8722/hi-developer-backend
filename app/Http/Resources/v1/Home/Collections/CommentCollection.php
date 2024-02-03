<?php

namespace App\Http\Resources\v1\Home\Collections;

use App\Models\Comment;
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
    $comments = Comment::whereParent_id($item->id)->oldest()->get();

                return [
                    "id"=>$item->id,
                    "comment"=>$item->comment,
                    "parent_id"=>$item->parent_id,
                    "user"=>[
                        "name"=>$item->user->name." ".$item->user->family,
                        "image"=>baseUrl().$item->user->avatar,
                    ],
                    "comments"=>$comments->map(function ($comment){
                        return [
                            "id"=>$comment->id,
                            "comment"=>$comment->comment,
                            "parent_id"=>$comment->parent_id,
                            "user"=>[
                                "name"=>$comment->user->name." ".$comment->user->family,
                                "image"=>baseUrl().$comment->user->avatar,
                            ],
                            "comments"=>[]
                        ];
                    })


                ];
            })


        ];
    }
}
