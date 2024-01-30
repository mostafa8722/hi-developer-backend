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


public function __construct($categories,$articles)
{
    $this->categories = $categories;
    $this->articles = $articles;
}

    public function toArray($request)
    {
        return [
           new ArticleCollection($this->articles),
            new CategoryCollection($this->categories),

        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
}
