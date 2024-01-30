<?php

namespace App\Http\Resources\v1\Home\Resources;

use App\Http\Resources\Home\Collections\TestimonialCollection;
use App\Http\Resources\v1\Home\Collections\ArticleCollection;
use App\Http\Resources\v1\Home\Collections\CategoryCollection;
use App\Http\Resources\v1\Home\Collections\CourseCollection;
use Illuminate\Http\Resources\Json\JsonResource;


class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected  $categories;
    protected  $articles;
    protected  $courses;
    protected  $testimonials;
    public function __construct($articles,$courses,$categories,$testimonials)
    {
        $this->categories = $categories;
        $this->courses = $courses;
        $this->articles = $articles;
        $this->testimonials = $testimonials;
    }


    public function toArray($request)
    {
        return [
            new ArticleCollection($this->articles),
            new CourseCollection($this->courses),
            new CategoryCollection($this->categories),
            new TestimonialCollection($this->testimonials),
        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
}
