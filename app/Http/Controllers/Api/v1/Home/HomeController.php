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
        $testimonials = Testimonial::whereStatus("published")->latest()->get(6);
        $courses = Course::whereStatus("published")->latest()->get(6);
        $articles = Article::whereStatus("published")->latest()->get(7);
        return new  HomeResource($articles,$courses,$categories,$testimonials);
    }

    public  function  articles(Request $request){
        $episode = Episode::latest()->first();

        $categories = Category::oldest()->get();
        $course =$episode->course;
        return $this->getCourseTimes($course->episodes->pluck("time"));;;
        return $episode->course;;
        $articles = new Article();
         $articles = $articles->whereStatus("published")->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return   new ArticlesPageResource($categories,$articles);
    }
    public function getCourseTimes($times){
        $timeStamp = Carbon::parse("00:00:00");
        foreach ($times as $t){
            $time = strtotime(strlen($t) ===5?"00:".$t:$t) ;

            $timeStamp->addSecond($time);
        }
        return $timeStamp->format("H:i:s");
    }
    public  function  article(Article $article,Request $request){

        $ep = Episode::latest()->first();

        return $ep;
        $categories = Category::oldest()->get();
        $articles = new Article();
        $articles = $articles->whereStatus("published")->oldest()->limit(3)->get();
        return  ArticlePageResource::make($article)->articles($articles)->categories($categories);
    }
    public  function  courses(Request $request){
        $categories = Category::oldest()->get();
        $courses = new Course();
        $courses= $courses->whereStatus("published")->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return  new CoursesPageResource($categories,$courses);
    }
    public  function  course(Course $course,Request $request){
        $categories = Category::oldest()->get();
        $courses = new Course();
        $courses = $courses->whereStatus("published")->oldest()->get(3);
        $episodes = Episode::whereCourse_id($course->id)->orderBy("number","ASC")->get();
        return  CoursePageResource::make($course)->courses($courses)->episodes($episodes)->categories($categories);
    }
    public  function  episode(Episode $episode,Request $request){
        $categories = Category::oldest()->get();
        $courses = new Course();
        $courses = $courses->whereStatus("published")->oldest()->get(3);
        $episodes = Episode::whereCourse_id($episode->id)->orderBy("number","ASC")->get();
        return  EpisodePageResource::make($episode)->courses($courses)->episodes($episodes)->categories($categories);
    }

    public  function  customPage(Page $page,Request $request){

        return  new CustomPageResource($page);
    }


}
