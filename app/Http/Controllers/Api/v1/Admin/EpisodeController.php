<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\EpisodeCollection;
use App\Http\Resources\v1\Admin\Resources\EpisodeResource;
use App\Models\Episode;

use App\Models\User;
use Illuminate\Http\Request;

class EpisodeController extends AdminController
{

    public function index(Request $request){


        $episodes = new Episode();
        if(isset($request->title))
            $episodes = $episodes->where("title","LIKE","%".$request->title."%");
        if(isset($request->course_id))
            $episodes = $episodes->where("course_id","=",$request->course_id);


        $episodes = $episodes->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new EpisodeCollection($episodes);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Episode $episode){
        return new EpisodeResource($episode);
    }
    public function store(Request $request){

        if($this->checkEpisodeValidation($request)){
            return  response([
                "data"=>$this->checkEpisodeValidation($request),
                "status" =>422
            ],422);
        }

        $user = User::whereApi_token($request->bearerToken())->first();
        $episode=   Episode::create([
            "user_id"=>$user->id,
            "title"=>$request->title,
            "body"=>$request->body,
            "course_id"=>$request->course_id,
            "status"=>$request->status,
            "abstract"=>$request->abstract,
            "tags"=>$request->tags,
            "type"=>$request->type,
            "videoUrl"=>$request->videoUrl,
            "time"=>$request->time,
            "time_published"=>$request->time_published,
            "number"=>$request->number,




        ]);
        $this->setCoutrseTime($episode);
        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Episode $episode){

        if($this->checkEpisodeValidation($request)){
            return  response([
                "data"=>$this->checkEpisodeValidation($request),
                "status" =>422
            ],422);
        }

        $episode->update([
            "title"=>$request->title,
            "body"=>$request->body,
            "course_id"=>$request->course_id,
            "status"=>$request->status,
            "abstract"=>$request->abstract,
            "tags"=>$request->tags,
            "type"=>$request->type,
            "videoUrl"=>$request->videoUrl,
            "time"=>$request->time,
            "time_published"=>$request->time_published,
            "number"=>$request->number,
        ]);
        $this->setCoutrseTime($episode);
        return new EpisodeResource($episode);
    }
    public  function  delete(Episode $episode ){
        $episode->delete();
        return  response([
            "data"=>"episode deleted! ",
            "status" =>200
        ]);
    }
    public  function checkEpisodeValidation(Request $request){

        $message = "";
        if(!isset($request->title)  )
            $message = "عنوان نمی تواند خالی باشد";
        else if(strlen($request->title)<3  )
            $message = "عنوان باید حداقل شامل 3 حرف باشد";
        else if(strlen($request->title)>200  )
            $message = "عنوان حداکثر شامل 200 حرف می باشد";


        return $message;
    }


}
