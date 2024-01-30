<?php

namespace App\Http\Resources\v1\Admin\Collections;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
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
                    "title"=>$item->title,
                    "body"=>$item->body,
                    "abstract"=>$item->abstract,
                    "slug"=>$item->slug,
                    "viewCount"=>$item->viewCount,
                    "commentCount"=>$item->commentCount,
                    "category"=>$item->category,
                    "status"=>$item->status,
                    "images"=>$item->images,
                    "tags"=>$item->tags,


                ];
            })

        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
