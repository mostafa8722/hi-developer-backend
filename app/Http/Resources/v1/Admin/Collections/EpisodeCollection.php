<?php

namespace App\Http\Resources\v1\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EpisodeCollection extends ResourceCollection
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
                    "course"=>$item->course,
                    "title"=>$item->title,
                    "abstract"=>$item->abstract,
                    "body"=>$item->body,
                    "type"=>$item->type,
                    "slug"=>$item->slug,
                    "videoUrl"=>$item->videoUrl,
                    "tags"=>$item->tags,
                    "viewCount"=>$item->viewCount,
                    "commentCount"=>$item->commentCount,
                    "downloadCount"=>$item->downloadCount,
                    "number"=>$item->number,
                    "time"=>$item->time,
                    "free"=>$item->free,
                    "time_published"=>$item->time_published,
                    "status"=>$item->status,

                ];

            })


        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
