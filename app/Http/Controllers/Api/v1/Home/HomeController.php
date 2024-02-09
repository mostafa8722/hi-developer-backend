<?php

namespace App\Http\Controllers\Api\v1\Home;

use App\Http\Controllers\Controller;

use App\Http\Resources\v1\Home\Resources\ArticlePageResource;
use App\Http\Resources\v1\Home\Resources\ArticlesPageResource;
use App\Http\Resources\v1\Home\Resources\CoursePageResource;
use App\Http\Resources\v1\Home\Resources\CoursesPageResource;
use App\Http\Resources\v1\Home\Resources\CustomPageResource;
use App\Http\Resources\v1\Home\Resources\EpisodePageResource;

use App\Http\Resources\v1\Home\Resources\HomeResource;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;

use App\Models\Episode;
use App\Models\Page;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public  function  index(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $user = $user?$user->id:0;
        $categories = Category::oldest()->get();
        $testimonials = Testimonial::whereStatus("published")->latest()->get();
        $courses = Course::whereStatus("published")->latest()->limit(6)->get();
        $articles = Article::whereStatus("published")->latest()->limit(7)->get();
        return new  HomeResource($user,$articles,$courses,$categories,$testimonials);
    }

    public  function  articles(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $user = $user?$user->id:0;
        $categories = Category::oldest()->get();
        $articles = Article::join('categories', 'categories.id', '=', 'articles.category_id');
        if(isset($request->categories) &&  isset(explode(',', $request->categories)[0]))
            $articles = $articles ->whereIn("categories.title",($this->MapArray(explode(',', $request->categories))));




        $articles= $articles->where("articles.status","=","published")->orderBy('articles.id', isset($request->sort) && strtolower($request->sort)==="oldest" ?'ASC':'DESC')->paginate(15);


        return   new ArticlesPageResource($categories,$articles);
    }

    public  function  article( $slug,Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $user = $user?$user->id:0;
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
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $user = $user?$user->id:0;
        $courses = Course::join('categories', 'categories.id', '=', 'courses.category_id');

        if(isset($request->categories) &&  isset(explode(',', $request->categories)[0]))
        $courses = $courses ->whereIn("categories.title",($this->MapArray(explode(',', $request->categories))));


        if(isset($request->types) &&  isset(explode(',', $request->types)[0]))
            $courses = $courses ->whereIn("courses.type",($this->MapArray(explode(',', $request->types))));

        $categories = Category::oldest()->get();

        $courses= $courses->where("courses.status","=","published")->orderBy('courses.id', isset($request->sort) && strtolower($request->sort)==="oldest" ?'ASC':'DESC')->paginate(15);
        return  new CoursesPageResource($categories,$courses);
    }
    public  function  course( $slug,Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $user = $user?$user->id:0;
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
        return  CoursePageResource::make($course)->user($user)->courses($courses)->episodes($episodes)->categories($categories)->comments($comments);
    }
    public  function  episode($slug,$number,Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $user = $user?$user->id:0;
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
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $user = $user?$user->id:0;
        return  new CustomPageResource($page);
    }
    public  function MapArray($arr){
        $map = [];
        $i=0;
        foreach ($arr as $row) {
            $map[$i] =   $row  ;
            $i++;
        }
        return $map;
    }
}
