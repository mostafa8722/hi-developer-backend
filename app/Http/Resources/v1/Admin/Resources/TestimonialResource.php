<?php

namespace App\Http\Resources\v1\Admin\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "title"=>$this->title,
            "status"=>$this->status,
            "image"=>$this->image?baseUrl().$this->image:null,
            "body"=>$this->body,
        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
