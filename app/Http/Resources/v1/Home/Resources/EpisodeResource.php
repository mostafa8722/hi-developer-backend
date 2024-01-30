<?php

namespace App\Http\Resources\v1\Home\Resources;

use App\Http\Resources\v1\Home\Collections\CategoryCollection;
use App\Http\Resources\v1\Home\Collections\CourseCollection;
use App\Http\Resources\v1\Home\Collections\EpsiodeCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


    public function toArray(Request $request): array
    {
        return [
            "episode"=>[
                "id"=>$this->id,
                "user_id"=>$this->user_id,
                "course"=>$this->course,
                "title"=>$this->title,
                "abstract"=>$this->abstract,
                "body"=>$this->body,
                "type"=>$this->type,
                "slug"=>$this->slug,
                "videoUrl"=>$this->videoUrl,
                "tags"=>$this->tags,
                "viewCount"=>$this->viewCount,
                "commentCount"=>$this->commentCount,
                "downloadCount"=>$this->downloadCount,
                "number"=>$this->number,
                "time"=>$this->time,
                "free"=>$this->free,
                "time_published"=>$this->time_published,
                "status"=>$this->status,


            ]
        ];
    }
}
