<?php

namespace App\Http\Resources\v1\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
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
                    "user"=>$item->user,
                    "body"=>$item->body,
                    "seen"=>$item->seen,


                ];
            })


        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
