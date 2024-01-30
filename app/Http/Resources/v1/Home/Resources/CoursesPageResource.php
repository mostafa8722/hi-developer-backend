<?php

namespace App\Http\Resources\v1\Home\Resources;

use App\Http\Resources\v1\Home\Collections\ArticleCollection;
use App\Http\Resources\v1\Home\Collections\CategoryCollection;
use App\Http\Resources\v1\Home\Collections\CourseCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected  $categories;
    protected  $courses;
    public function __construct($categories,$courses)
    {
        $this->categories = $categories;
        $this->courses = $courses;
    }

    public function toArray($request)
    {
        return [
            new CourseCollection($this->courses),
            new CategoryCollection($this->categories),

        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
}
