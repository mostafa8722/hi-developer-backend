<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\CourseCollection;
use App\Http\Resources\v1\Admin\Resources\CourseResource;
use App\Models\Course;

use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends AdminController
{

    public function index(Request $request){


        $courses = new Course();
        if(isset($request->title))
            $courses = $courses->where("title","LIKE","%".$request->title."%");
        if(isset($request->category_id))
            $courses = $courses->where("category_id","=",$request->category_id);


        $courses = $courses->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new CourseCollection($courses);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Course $course){
        return new CourseResource($course);
    }
    public function store(Request $request){

        if($this->checkCourseValidation($request)){
            return  response([
                "data"=>$this->checkCourseValidation($request),
                "status" =>422
            ],422);
        }
        $src = null;
        if(isset($request->images)){
            $image = $request->images;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"courses",time().$ext);
        }
        $user = User::whereApi_token($request->bearerToken())->first();
        Course::create([
            "user_id"=>$user->id,
            "title"=>$request->title,
            "body"=>$request->body,
            "category_id"=>$request->category_id,
            "status"=>$request->status,
            "images"=>$src,
            "abstract"=>$request->abstract,
            "type"=>$request->type,
            "tags"=>$request->tags,
            "price"=>$request->price,
        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Course $course){

        if($this->checkCourseValidation($request)){
            return  response([
                "data"=>$this->checkCourseValidation($request),
                "status" =>422
            ],422);
        }
        $src = null;
        if(isset($request->images)){
            $image = $request->images;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"courses",time().$ext);
        }else{
            $src = $course->image??$src;
        }
        $course->update([
            "title"=>$request->title,
            "body"=>$request->body,
            "category_id"=>$request->category_id,
            "status"=>$request->status,
            "images"=>$src,
            "abstract"=>$request->abstract,
            "tags"=>$request->tags,
            "type"=>$request->type,
            "price"=>$request->price,
        ]);

        return new CourseResource($course);
    }
    public  function  destroy(Course $course ){
        $course->delete();
        return  response([
            "data"=>"course deleted! ",
            "status" =>200
        ]);
    }
    public  function checkCourseValidation(Request $request){

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
