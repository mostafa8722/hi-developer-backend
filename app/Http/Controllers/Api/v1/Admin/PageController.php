<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\PageCollection;
use App\Http\Resources\v1\Admin\Resources\PageResource;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends AdminController
{

    public function index(Request $request){


        $pages = new Page();
        if(isset($request->title))
            $pages = $pages->where("title","LIKE","%".$request->title."%");



        $pages = $pages->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new PageCollection($pages);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Page $page){
        return new PageResource($page);
    }
    public function store(Request $request){

        if($this->checkPageValidation($request)){
            return  response([
                "data"=>$this->checkPageValidation($request),
                "status" =>422
            ],422);
        }

        $src = null;
        if(isset($request->images)){
            $image = $request->images;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"pages",time().$ext);
        }
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        Page::create([
            "user_id"=>$user->id,
            "title"=>$request->title,
            "body"=>$request->body,
            "slug"=>$request->slug,
            "status"=>$request->status,
            "images"=>$src,
            "abstract"=>$request->abstract,
            "tags"=>$request->tags,
        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Page $page){

        if($this->checkPageValidation($request)){
            return  response([
                "data"=>$this->checkPageValidation($request),
                "status" =>422
            ],422);
        }

        $src = null;
        if(isset($request->images)){
            $image = $request->images;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"pages",time().$ext);
        }else{
            $src = json_decode($request->orginImage, true);
        }
        $page->update([
            "title"=>$request->title,
            "body"=>$request->body,
            "slug"=>$request->slug,
            "status"=>$request->status,
            "images"=>$src,
            "abstract"=>$request->abstract,
            "tags"=>$request->tags,
        ]);

        return new PageResource($page);
    }
    public  function  destroy(Page $page ){
        $page->delete();
        return  response([
            "data"=>"page deleted! ",
            "status" =>200
        ]);
    }
    public  function checkPageValidation(Request $request){

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
