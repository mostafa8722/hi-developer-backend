<?php

namespace App\Http\Resources\v1\Home\Collections;

use App\Models\Course;
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

                $count = Course::whereCategory_id($item->id)->get()->count();
                return [
                    "id"=>$item->id,
                    "title"=>$item->title,
                    "color"=>$item->color,
                    "image"=>$item->image?baseUrl().$item->image:null,
                    "countCourse"=>$count." ".($count>1?"Courses":"Course"),
                    "slug"=>"/courses?categories=".preg_replace('/\s+/', '-', trim(($item->title))),


                ];
            })


        ];
    }
}
