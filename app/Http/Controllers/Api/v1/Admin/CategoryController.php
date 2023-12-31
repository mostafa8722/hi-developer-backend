<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\CategoryCollection;
use App\Http\Resources\v1\Admin\Resources\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller

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

        $user = User::whereApi_token($request->bearerToken())->first();
        Category::create([
            "user_id"=>$user->id,
            "title"=>$request->title,

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

        $category->update([
            "title"=>$request->title,

        ]);

        return new CategoryResource($category);
    }
    public  function  delete(Category $category ){
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
        else if(strlen($request->title)<3  )
            $message = "عنوان باید حداقل شامل 3 حرف باشد";
        else if(strlen($request->title)>200  )
            $message = "عنوان حداکثر شامل 200 حرف می باشد";


        return $message;
    }


}
