<?php

namespace App\Http\Resources\v1\Home\Collections;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentUserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

    public function toArray($request)
    {
        return [
            "comments"=>$this->collection->map(function($item){
    $comments = Comment::whereParent_id($item->id)->oldest()->get();

    $course =Course::whereId($item->course_id)->first();
    $article =Article::whereId($item->article_id)->first();
    $episode =Episode::whereId($item->episode_id)->first();

                return [
                    "id"=>$item->id,
                    "comment"=>$item->comment,

                    "user"=>[
                        "name"=>$item->user->name." ".$item->user->family,
                        "image"=>baseUrl().$item->user->avatar,
                    ],
                    "title"=>$item->course_id!=0 ? $course->title :
                        ($item->article_id!=0 ? $article->title :
                            $episode->title),

                    "image"=>$item->course_id!=0 ?$this->showImage($course)  :
                        ($item->article_id!=0 ? $this->showImage($article):
                            null),
                   "status"=>$item->status,
                    "slug"=>$item->course_id!=0 ?"/courses/".$course->slug :
                        ($item->article_id!=0 ? "/articles/".$article->slug:
                            "/courses/".Course::whereId($episode->course_id)->first()->slug."/".$episode->id),
                ];
            })


        ];
    }
    public function with($request)
    {
        return ["status"=>200];
    }
    public function showImage($item){
        return $item->images["thumb"]?baseUrl().$item->images["thumb"]:null;
    }
}
