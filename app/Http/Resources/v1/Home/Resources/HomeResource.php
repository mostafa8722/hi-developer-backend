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
    protected  $user;
    public function __construct($user,$articles,$courses,$categories,$testimonials)
    {
        $this->categories = $categories;
        $this->courses = $courses;
        $this->articles = $articles;
        $this->testimonials = $testimonials;
        $this->user = $user;
    }


    public function toArray($request)
    {
        return [
             ArticleCollection::make($this->articles)->user($this->user),
             CourseCollection::make($this->courses)->user($this->user),
            new CategoryCollection($this->categories),
            new TestimonialCollection($this->testimonials),
        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
}
