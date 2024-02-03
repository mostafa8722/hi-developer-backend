<?php

namespace App\Http\Resources\v1\Home\Resources;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           "article"=>[
               "id"=>$this->id,
               "title"=>$this->title,
               "body"=>$this->body,
               "abstract"=>$this->abstract,
               "slug"=>$this->slug,
               "viewCount"=>$this->viewCount,
               "commentCount"=>$this->commentCount,
               "category"=>$this->category,
               "likeCount"=>$this->likes->count(),
               "status"=>$this->status,
               "image"=>$this->images?baseUrl().$this->images["images"]["orginal"] :null,
               "tags"=>$this->MapArray(explode(',', $this->tags))


           ]
        ];
    }

    public  function MapArray($arr){
        $map = [];
        $i=0;
        foreach ($arr as $row) {
            $tag = Tag::whereId($row)->first()->title;
            $map[$i] =   preg_replace('/\s+/', '_', trim(strtolower($tag)))  ;
            $i++;
        }
        return $map;
    }
}
