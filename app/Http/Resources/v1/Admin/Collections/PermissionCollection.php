<?php

namespace App\Http\Resources\v1\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
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
                    "title"=>$item->title,
                    "en_title"=>$item->en_title,
                    "body"=>$item->body,
                    "section"=>$item->section,


                ];
            })


        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
