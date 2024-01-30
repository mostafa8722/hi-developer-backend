<?php

namespace App\Http\Resources\v1\Home\Collections;

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
            "categories"=>$this->collection->map(function($item){

                return [
                    "id"=>$item->id,
                    "title"=>$item->title,


                ];
            })


        ];
    }
}
