<?php

namespace App\Http\Resources\v1\Home\Collections;

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
            "articles"=>$this->collection->map(function($item){

                return [
                    "id"=>$item->id,
                    "title"=>$item->title,
                    "abstract"=>$item->abstract,
                    "slug"=>$item->slug,
                    "viewCount"=>$item->viewCount,
                    "commentCount"=>$item->commentCount,
                    "category_id"=>$item->category_id,
                    "category"=>$item->category,
                    "status"=>$item->status,
                    "images"=>$item->images,
                    "tags"=>$item->tags,
                ];
            })


        ];
    }


}
