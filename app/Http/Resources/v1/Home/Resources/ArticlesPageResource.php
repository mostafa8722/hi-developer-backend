<?php

namespace App\Http\Resources\v1\Home\Resources;

use App\Http\Resources\Home\Collections\TestimonialCollection;
use App\Http\Resources\v1\Home\Collections\ArticleCollection;
use App\Http\Resources\v1\Home\Collections\CategoryCollection;
use App\Http\Resources\v1\Home\Collections\CourseCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected  $categories;
    protected  $articles;
    protected  $user;


public function __construct($user,$categories,$articles)
{
    $this->user = $user;
    $this->categories = $categories;
    $this->articles = $articles;
}

    public function toArray($request)
    {
        return [
            ArticleCollection::make($this->articles)->user($this->user),
            new CategoryCollection($this->categories),

        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
}
