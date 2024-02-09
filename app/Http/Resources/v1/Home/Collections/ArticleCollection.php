<?php

namespace App\Http\Resources\v1\Home\Collections;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{

    public function user($value){
        $this->user = $value;
        return $this;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            "articles"=>$this->collection->map(function($item){
                $isLike = Like::where("user_id","=",$this->user)->where("article_id","=",$item->id)->first();
                return [
                    "id"=>$item->id,
                    "title"=>$item->title,
                    "abstract"=>$item->abstract,
                    "slug"=>$item->slug,
                    "viewCount"=>$item->viewCount,
                    "comment"=>$item->commentCount." comment".($item->commentCount>1?"s":""),
                    "category_id"=>$item->category_id,
                    "category"=>$item->category,
                    "status"=>$item->status,
                    "image"=>$item->images["thumb"]?baseUrl().$item->images["thumb"]:null,
                    "tags"=>$item->tags,
                    "isLiked"=>$isLike?true:false,
                    "like"=>Like::where("article_id","=",$item->id)->get()->count(),
                    "user"=>[
                        "name"=>$item->user->name." ".$item->user->family,
                        "image"=>baseUrl().$item->user->avatar,
                    ],
                ];
            })


        ];
    }


}
