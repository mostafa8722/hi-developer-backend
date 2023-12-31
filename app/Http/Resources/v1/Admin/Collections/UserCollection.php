<?php

namespace App\Http\Resources\v1\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
                    "name"=>$item->name,
                    "mobile"=>$item->mobile,
                    "username"=>$item->username,
                    "email"=>$item->email,
                    "status"=>$item->status,
                    "avatar"=>$item->avatar,
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
