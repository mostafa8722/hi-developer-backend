<?php

namespace App\Http\Controllers\Api\v1\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Home\Collection\BlogCollection;
use App\Http\Resources\v1\Home\Resources\AboutResource;
use App\Http\Resources\v1\Home\Resources\ArticlePageResource;
use App\Http\Resources\v1\Home\Resources\ArticlesPageResource;
use App\Http\Resources\v1\Home\Resources\CoursePageResource;
use App\Http\Resources\v1\Home\Resources\CoursesPageResource;
use App\Http\Resources\v1\Home\Resources\CustomPageResource;
use App\Http\Resources\v1\Home\Resources\EpisodePageResource;
use App\Http\Resources\v1\Home\Resources\HeaderResource;
use App\Http\Resources\v1\Home\Resources\HomeResource;
use App\Http\Resources\v1\Home\Resources\ProjectResource;
use App\Http\Resources\v1\Home\Resources\ResumeResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;

use App\Models\Episode;
use App\Models\Page;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public  function  index(Request $request){
        $categories = Category::oldest()->get();
        $testimonials = Testimonial::whereStatus("published")->latest()->get();
        $courses = Course::whereStatus("published")->latest()->limit(6)->get();
        $articles = Article::whereStatus("published")->latest()->limit(7)->get();
        return new  HomeResource($articles,$courses,$categories,$testimonials);
    }

    public  function  articles(Request $request){

        $categories = Category::oldest()->get();
        $articles = new Article();
         $articles = $articles->whereStatus("published")->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return   new ArticlesPageResource($categories,$articles);
    }

    public  function  article( $slug,Request $request){
        $article = Article::whereSlug($slug)->first();
        if(!$article)
            return  response([
                "data"=>"Not Found",
                "status" =>404
            ],404);

        $categories = Category::oldest()->get();
        $articles = new Article();
        $articles = $articles->whereStatus("published")->oldest()->limit(3)->get();
        $comments = Comment::whereArticle_id($article->id)->whereParent_id(0)->latest()->paginate(15);
        return  ArticlePageResource::make($article)->articles($articles)->categories($categories)->comments($comments);
    }
    public  function  courses(Request $request){
        $categories = Category::oldest()->get();
        $courses = new Course();
        $courses= $courses->whereStatus("published")->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return  new CoursesPageResource($categories,$courses);
    }
    public  function  course( $slug,Request $request){
        $course = Course::whereSlug($slug)->first();
        if(!$course)
        return  response([
            "data"=>"Not Found",
            "status" =>404
        ],404);
        $categories = Category::oldest()->get();
        $courses = new Course();
        $courses = $courses->whereStatus("published")->limit(3)->oldest()->get();
        $episodes = Episode::whereCourse_id($course->id)->orderBy("number","ASC")->get();
        $comments = Comment::whereCourse_id($course->id)->whereParent_id(0)->latest()->paginate(15);
        return  CoursePageResource::make($course)->courses($courses)->episodes($episodes)->categories($categories)->comments($comments);
    }
    public  function  episode($slug,$number){
        $course = Course::whereSlug($slug)->first();
        if(!$course)
            return  response([
                "data"=>"Not Found",
                "status" =>404
            ],404);
        $episode= Episode::whereCourse_id($course->id)->whereNumber($number)->first();
        if(!$episode)
            return  response([
                "data"=>"Not Found",
                "status" =>404
            ],404);
        $categories = Category::oldest()->get();
        $courses = new Course();
        $courses = $courses->whereStatus("published")->oldest()->limit(3)->get();
        $episodes = Episode::whereCourse_id($course->id)->orderBy("number","ASC")->get();
        $comments = Comment::whereEpisode_id($episode->id)->whereParent_id(0)->latest()->paginate(15);
        return  EpisodePageResource::make($episode)->courses($courses)->episodes($episodes)->categories($categories)->comments($comments);;
    }

    public  function  customPage(Page $page,Request $request){

        return  new CustomPageResource($page);
    }


}
