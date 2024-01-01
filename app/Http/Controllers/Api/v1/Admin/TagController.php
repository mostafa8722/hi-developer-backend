<?php

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Resources\v1\Admin\Collections\TagCollection;
use App\Http\Resources\v1\Admin\Resources\TagResource;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class TagController extends AdminController
{

    public function index(Request $request){


        $tags = new Tag();


        $tags = $tags->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new TagCollection($tags);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Tag $tag){
        return new TagResource($tag);
    }
    public function store(Request $request){

        if($this->checkTagValidation($request)){
            return  response([
                "data"=>$this->checkTagValidation($request),
                "status" =>422
            ],422);
        }
        $user = User::whereApi_token($request->bearerToken())->first();
        Tag::create([
            "user_id"=>$user->id,
            "title"=>$request->title,

        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Tag $tag){

        if($this->checkTagValidation($request)){
            return  response([
                "data"=>$this->checkTagValidation($request),
                "status" =>422
            ],422);
        }

        $tag->update([
            "title"=>$request->title,

        ]);

        return new TagResource($tag);
    }
    public  function  delete(Tag $tag ){
        $tag->delete();
        return  response([
            "data"=>"دسترسی  با موفقیت حذف شد ",
            "status" =>200
        ]);
    }
    public  function checkTagValidation(Request $request){

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
