<?php

namespace App\Http\Resources\v1\Home\Resources;

use App\Http\Resources\v1\Home\Collections\ArticleCollection;
use App\Http\Resources\v1\Home\Collections\CategoryCollection;
use App\Http\Resources\v1\Home\Collections\CommentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlePageResource extends JsonResource
{
        public function categories($value){
        $this->categories = $value;
        return $this;
    }


    public function articles($value){
        $this->articles = $value;
        return $this;
    }
    public function comments($value){
        $this->comments = $value;
        return $this;
    }
    public function toArray($request)
    {
        return [
            new ArticleResource($this),
            new ArticleCollection($this->articles),
            new CategoryCollection($this->categories),
            new CommentCollection($this->comments),

        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
}
