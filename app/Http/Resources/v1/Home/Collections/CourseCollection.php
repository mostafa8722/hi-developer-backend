<?php

namespace App\Http\Resources\v1\Home\Collections;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

    public function user($value){
        $this->user = $value;
        return $this;
    }
    public function toArray($request)
    {
        return [
            "courses"=>$this->collection->map(function($item){
                $isLike = Like::where("user_id","=",$this->user)->where("course_id","=",$item->id)->first();
                return [
                    "id"=>$item->id,
                    "user_id"=>$item->user_id,
                    "category"=>$item->category,
                    "title"=>$item->title,
                    "abstract"=>$item->abstract,
                    "body"=>$item->abstract,
                    "type"=>$item->type,
                    "image"=>$item->images["thumb"]?baseUrl().$item->images["thumb"]:null,
                    "slug"=>preg_replace('/\s+/', '_', trim(strtolower($item->title))),

                    "isLiked"=>$isLike?true:false,
                    "like"=>Like::where("course_id","=",$item->id)->get()->count(),
                    "tags"=>$item->tags,
                    "price"=>$item->price===0?"free":($item->price."$"),
                    "viewCount"=>$item->viewCount,
                    "commentCount"=>$item->commentCount,
                    "time"=>$item->time,

                ];
            })


        ];
    }
}
