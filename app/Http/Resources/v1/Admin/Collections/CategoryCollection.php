<?php

namespace App\Http\Resources\v1\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
                    "color"=>$item->color,
                    "title"=>$item->title,
                    "status"=>$item->status,
                    "image"=>$item->image?baseUrl().$item->image:null,
                    "body"=>$item->body,


                ];
            })

        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
