<?php

namespace App\Http\Resources\Home\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TestimonialCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            "testimonials"=>$this->collection->map(function($item){

        return [
            "id"=>$item->id,
            "name"=>$item->name,
            "title"=>$item->title,
            "status"=>$item->status,
            "image"=>$item->image?baseUrl().$this->image:null,
            "body"=>$item->body,
        ];
            })


        ];
    }


}
