<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\CategoryCollection;
use App\Http\Resources\v1\Admin\Resources\CategoryResource;
use App\Models\Category;

use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends AdminController

{

    public function index(Request $request){


        $categories = new Category();
        if(isset($request->title))
            $categories = $categories->where("title","LIKE","%".$request->title."%");
        if(isset($request->category_id))
            $categories = $categories->where("category_id","=",$request->category_id);


        $categories = $categories->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new CategoryCollection($categories);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Category $category){
        return new CategoryResource($category);
    }
    public function store(Request $request){

        if($this->checkCategoryValidation($request)){
            return  response([
                "data"=>$this->checkCategoryValidation($request),
                "status" =>422
            ],422);
        }


        $src = null;
        $category = Category::whereTitle($request->title)->first();
        if($category)
            return  response([
                "data"=>"title has aleady existed",
                "status" =>422
            ],422);

        if(isset($request->image)){
            $image = $request->image;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadFile($image,"categories",($request->title).$ext);
        }

        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        Category::create([
            "user_id"=>$user->id,
            "color"=>$request->color,
            "title"=>$request->title,
            "image"=>$src,
            "body"=>$request->body,
            "status"=>$request->status,

        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Category $category){

        if($this->checkCategoryValidation($request)){
            return  response([
                "data"=>$this->checkCategoryValidation($request),
                "status" =>422
            ],422);
        }


        $src = null;
        if(isset($request->image)){
            $image = $request->image;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadFile($image,"categories",($request->title).$ext);
        }else{
            $src = $category->image??$src;
        }
        $category->update([
            "color"=>$request->color,
            "title"=>$request->title,
            "image"=>$src,
            "body"=>$request->body,
            "status"=>$request->status,

        ]);

        return new CategoryResource($category);
    }
    public  function  destroy(Category $category ){
        $category->delete();
        return  response([
            "data"=>"category deleted!",
            "status" =>200
        ]);
    }
    public  function checkCategoryValidation(Request $request){

        $message = "";
        if(!isset($request->title)  )
            $message = "عنوان نمی تواند خالی باشد";
        else if(strlen($request->title)<2  )
            $message = "عنوان باید حداقل شامل 3 حرف باشد";
        else if(strlen($request->title)>200  )
            $message = "عنوان حداکثر شامل 200 حرف می باشد";


        return $message;
    }


}
