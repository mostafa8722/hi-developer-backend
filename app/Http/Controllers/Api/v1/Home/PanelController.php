<?php

namespace App\Http\Controllers\Api\v1\Home;

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Resources\v1\Admin\Collections\TransactionCollection;
use App\Http\Resources\v1\Admin\Resources\UserResource;
use App\Http\Resources\v1\Home\Collections\ArticleCollection;
use App\Http\Resources\v1\Home\Collections\CommentCollection;
use App\Http\Resources\v1\Home\Collections\CommentUserCollection;
use App\Http\Resources\v1\Home\Collections\CourseCollection;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PanelController extends AdminController
{
    public  function  index(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();

        $dashboard = [
            "courses"=>Transaction::where("user_id","=",$user->id)->get()->count(),
            "comments" =>Comment::where("user_id","=",$user->id)->get()->count(),
            "likes" =>Like::where("user_id","=",$user->id)->get()->count(),
            "wallet" =>$user->wallet." $",
        ];
        return  response([
            "data"=>$dashboard,
            "status" =>200
        ],200);
    }
    public function edit(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();

        return new UserResource($user);
    }

    public function update(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();

        $src = null;
        if(isset($request->avatar)){
            $image = $request->avatar;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadFile($image,"users",time().$ext);
        }else{
            $src = $user->avatar??$src;
        }
        $user->update([
            "name"=>$request->name,
            "family"=>$request->family,
            "mobile"=>$request->mobile,
            "body"=>$request->body,
        ]);

        return  response([
            "data"=>" user information  updated successfully   ",
            "status" =>200
        ],200);
    }



    public function updateImage(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();


        $src = null;
        if(isset($request->avatar)){

            $image = $request->avatar;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadFile($image,"users",time().$ext);
        }else{
            $src = $user->avatar??$src;
        }

        $user->update(["avatar"=>$src,]);

        return  response([
            "data"=>" image  changed successfully   ",
            "status" =>200
        ],200);
    }

    public  function updatePassword(Request $request){
//        return  response([
//            "data"=>"password must be contain articles and at least 6 length ",
//            "status" =>422
//        ],422);
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        if(!$this->validPassword($request->password)){
            return  response([
                "data"=>"password must be contain articles and at least 6 length ",
                "status" =>422
            ],422);
        }

        if (!Hash::check(trim($request->oldPassword), $user->password)) {
            return  response([
                "data"=>"old password is not correct! ",
                "status" =>404
            ],404);
        }
        if (trim($request->oldPassword)==trim($request->password)) {
            return  response([
                "data"=>"old password and new password can not be equal! ",
                "status" =>404
            ],404);
        }
        $user->update(["password"=>Hash::make(trim($request->password)),]);

        return  response([
            "data"=>" password changed successfully   ",
            "status" =>200
        ],200);



    }

    public  function  transactions(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $transactions = Transaction::whereUser_id($user->id)->latest()->paginate(15);
        return new TransactionCollection($transactions);
    }

    public  function  courses(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();


        $courses = Course::join('transactions', 'transactions.course_id', '=', 'courses.id')->
        where("transactions.user_id","=",$user->id)->paginate(15);

        return  response([
            "data"=>new CourseCollection($courses),
            "status" =>200
        ],200);
    }

    public  function  comments(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $comments = Comment::whereUser_id($user->id)->latest()->paginate(15);




        return new CommentUserCollection($comments);
    }

    public  function  likes(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();


        $tab = isset($request->tab)?$request->tab:"articles";
        if($tab=="articles"){
            $articles= Article::join('likes', 'likes.article_id', '=', 'articles.id')->
            where("likes.user_id","=",$user->id)->
            where("likes.article_id","!=",0)->
            paginate(15);

            return  response([
                "data"=>new ArticleCollection($articles),
                "status" =>200
            ],200);
        }else if($tab=="courses"){
            $courses = Course::join('likes', 'likes.course_id', '=', 'courses.id')->
            where("likes.user_id","=",$user->id)->where("likes.course_id","!=",0)->paginate(15);

            return  response([
                "data"=>new CourseCollection($courses),
                "status" =>200
            ],200);
        }



    }

    public  function  notifications(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        $notifications = Notification::whereUser_id($user->id)->latest()->paginate(15);
        return  response([
            "data"=>$notifications->map(function ($item){
                return [
                    "id"=>$item->id,
                    "body"=>$item->body,
                    "status"=>$item->status,
                    "seen"=>$item->seen,
                    "time"=>$item->created_at->todatestring(),
                ];
            }),
            "status" =>200
        ],200);
    }

    public  function  saveLike(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();


        $item = isset($request->article_id) ? "article_id" :(isset($request->course_id) ? "course_id":"episode_id");
        $id = isset($request->article_id) ? $request->article_id :(isset($request->course_id) ? $request->course_id :$request->episode_id);


        $like = Like::whereUser_id($user->id)->where($item,"=",$id)->first();
        $like?$like->delete():Like::create(["user_id"=>$user->id,$item=>$id]);
        $count = Like::where($item,"=",$id)->get()->count();
        $isLiked = Like::whereUser_id($user->id)->where($item,"=",$id)->first();
        return  response([
            "data"=>$count,
            "isLiked"=>$isLiked?true:false,
            "status" =>200
        ],200);
    }

    public  function  saveComment(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();


        $item = isset($request->article_id) ? "article_id" :(isset($request->course_id) ? "course_id":"episode_id");
        $id = isset($request->article_id) ? $request->article_id :(isset($request->course_id) ? $request->course_id :$request->episode_id);



        $comment = Comment::create([
            "comment"=>$request->comment,
            "parent_id"=>isset($request->parent_id)?$request->parent_id:0,
            "user_id"=>$user->id,
            $item=>$id
        ]);

        return  response([
            "data"=>"Your comment sent successfully and will be published after admin approve",
            "status" =>200
        ],200);
    }

    public  function checkUserValidation(Request $request){

        $message = "";
        if(!isset($request->name)  )
            $message = "نام نمی تواند خالی باشد";
        else if(strlen($request->name)<3  )
            $message = "نام باید حداقل شامل 3 حرف باشد";
        else if(strlen($request->name)>200  )
            $message = "نام حداکثر شامل 200 حرف می باشد";
        else if(!isset($request->email)  )
            $message = "ایمیل نمی تواند خالی باشد";
        else  if(!$this->validEmail($request->email)  )
            $message = "ایمیل وارد شده صحیح نمی باشد";

        return $message;
    }

}
