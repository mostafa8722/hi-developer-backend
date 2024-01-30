<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\TestimonialCollection;
use App\Http\Resources\v1\Admin\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestimonialController extends Controller
{
    public function index(Request $request){



        $testimonials = new Testimonial();
        if(isset($request->name))
            $testimonials = $testimonials->where("name","LIKE","%".$request->name."%");

        if(isset($request->title))
            $testimonials = $testimonials->where("title","LIKE","%".$request->title."%");

        if(isset($request->mobile))
            $testimonials = $testimonials->where("mobile","LIKE","%".$request->mobile."%");




        $testimonials = $testimonials->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new TestimonialCollection($testimonials);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Testimonial $testimonial){
        return new TestimonialResource($testimonial);
    }
    public function store(Request $request){

        if($this->checkTestimonialValidation($request)){
            return  response([
                "data"=>$this->checkTestimonialValidation($request),
                "status" =>422
            ],422);
        }
        $src = null;
        $testimonial = Testimonial::whereName($request->name)->first();
        if($testimonial)
            return  response([
                "data"=>"name has aleady existed",
                "status" =>422
            ],422);

        if(isset($request->image)){
            $image = $request->image;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadFile($image,"testimonials",time().$ext);
        }

        Testimonial::create([

            "name"=>$request->name,
            "title"=>$request->title,
            "image"=>$src,
            "body"=>$request->body,

        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Testimonial $testimonial){

        if($this->checkTestimonialValidation($request)){
            return  response([
                "data"=>$this->checkTestimonialValidation($request),
                "status" =>422
            ],422);
        }

        $src = null;
        if(isset($request->image)){
            $image = $request->image;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadFile($image,"testimonials",time().$ext);
        }else{
            $src = $testimonial->image??$src;
        }
        $testimonial->update([
            "name"=>$request->name,
            "title"=>$request->title,
            "image"=>$src,
            "body"=>$request->body,

        ]);

        return new TestimonialResource($testimonial);
    }
    public  function  destroy(Testimonial $testimonial ){
        $testimonial->delete();
        return  response([
            "data"=>"testimonial deleted! ",
            "status" =>200
        ]);
    }
    public  function checkTestimonialValidation(Request $request){

        $message = "";
        if(!isset($request->name)  )
            $message = "نام نمی تواند خالی باشد";
        else if(strlen($request->name)<3  )
            $message = "نام باید حداقل شامل 3 حرف باشد";
        else if(strlen($request->name)>200  )
            $message = "نام حداکثر شامل 200 حرف می باشد";
        else if(!isset($request->title)  )
            $message = "ایمیل نمی تواند خالی باشد";
        else if(!isset($request->body)  )
            $message = "توضیحات نمی تواند خالی باشد";



        return $message;
    }

}
