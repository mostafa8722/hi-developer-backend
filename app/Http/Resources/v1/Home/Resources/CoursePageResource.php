<?php

namespace App\Http\Resources\v1\Home\Resources;

use App\Http\Resources\v1\Home\Collections\ArticleCollection;
use App\Http\Resources\v1\Home\Collections\CategoryCollection;
use App\Http\Resources\v1\Home\Collections\CommentCollection;
use App\Http\Resources\v1\Home\Collections\CourseCollection;
use App\Http\Resources\v1\Home\Collections\EpsiodeCollection;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursePageResource extends JsonResource

{
    public function categories($value){
        $this->categories = $value;
        return $this;
    }
    public function episodes($value){
        $this->episodes = $value;
        return $this;
    }


    public function courses($value){
        $this->courses = $value;
        return $this;
    }
    public function comments($value){
        $this->comments = $value;
        return $this;
    }
    public function user($value){
        $this->user = $value;
        return $this;
    }
    public function toArray($request)
    {
        return [
            new CourseResource($this),
             CourseCollection::make($this->courses)->user($this->user),
            new  EpsiodeCollection($this->episodes),
            new CategoryCollection($this->categories),
            new CommentCollection($this->comments),

        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
}
