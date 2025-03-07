<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\ArticleCollection;
use App\Http\Resources\v1\Admin\Resources\ArticleResource;
use App\Models\Article;

use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends AdminController
{

    public function index(Request $request){


        $articles = new Article();
        if(isset($request->title))
            $articles = $articles->where("title","LIKE","%".$request->title."%");
        if(isset($request->category_id))
            $articles = $articles->where("category_id","=",$request->category_id);


        $articles = $articles->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new ArticleCollection($articles);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Article $article){
        return new ArticleResource($article);
    }
    public function store(Request $request){

        if($this->checkArticleValidation($request)){
            return  response([
                "data"=>$this->checkArticleValidation($request),
                "status" =>422
            ],422);
        }

        $src = null;
        if(isset($request->images)){
            $image = $request->images;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"articles",time().$ext);
        }
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        Article::create([
            "user_id"=>$user->id,
            "title"=>$request->title,
            "body"=>$request->body,
            "category_id"=>$request->category_id,
            "status"=>$request->status,
            "images"=>$src,
            "abstract"=>$request->abstract,
            "tags"=>$request->tags,
            "slug"=>preg_replace('/\s+/', '_', trim(strtolower($request->title)))
        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Article $article){

        if($this->checkArticleValidation($request)){
            return  response([
                "data"=>$this->checkArticleValidation($request),
                "status" =>422
            ],422);
        }

        $src = null;
        if(isset($request->images)){
            $image = $request->images;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"articles",time().$ext);
        }else{
            $src = json_decode($request->orginImage, true);
        }
        $article->update([
            "title"=>$request->title,
            "body"=>$request->body,
            "category_id"=>$request->category_id,
            "status"=>$request->status,
            "images"=>$src,
            "abstract"=>$request->abstract,
            "tags"=>$request->tags,
            "slug"=>preg_replace('/\s+/', '_', trim(strtolower($request->title)))
        ]);

        return new ArticleResource($article);
    }
    public  function  destroy(Article $article ){
        $article->delete();
        return  response([
            "data"=>"article deleted! ",
            "status" =>200
        ]);
    }
    public  function checkArticleValidation(Request $request){

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
