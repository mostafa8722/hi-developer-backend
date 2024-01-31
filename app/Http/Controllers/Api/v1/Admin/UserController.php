<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\UserCollection;
use App\Http\Resources\v1\Admin\Resources\UserResource;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{

    public function index(Request $request){



        $users = new User();
        if(isset($request->name))
            $users = $users->where("name","LIKE","%".$request->name."%");

        if(isset($request->email))
            $users = $users->where("email","LIKE","%".$request->email."%");

        if(isset($request->mobile))
            $users = $users->where("mobile","LIKE","%".$request->mobile."%");


        if(isset($request->username))
            $users = $users->where("username","LIKE","%".$request->username."%");


        $users = $users->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new UserCollection($users);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(User $user){
        return new UserResource($user);
    }
    public function store(Request $request){

        if($this->checkUserValidation($request)){
            return  response([
                "data"=>$this->checkUserValidation($request),
                "status" =>422
            ],422);
        }
        $src = null;
        $user = User::whereEmail($request->email)->first();
        if($user)
            return  response([
                "data"=>"email has aleady existed",
                "status" =>422
            ],422);

        if(isset($request->avatar)){
            $image = $request->avatar;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadFile($image,"users",time().$ext);
        }

        User::create([

            "name"=>$request->name,
            "family"=>$request->family,
            "username"=>$request->username,
            "mobile"=>$request->mobile,
            "email"=>$request->email,
            "status"=>$request->status,
            "avatar"=>$src,
            "body"=>$request->body,
            "password"=>Hash::make(trim($request->password)),
        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,User $user){

        if($this->checkUserValidation($request)){
            return  response([
                "data"=>$this->checkUserValidation($request),
                "status" =>$request->avatar
            ],422);
        }

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
            "username"=>$request->username,
            "family"=>$request->family,
             "name"=>$request->name,
             "body"=>$request->body,
            "status"=>$request->status,
            "mobile"=>$request->mobile,
            "avatar"=>$src,


        ]);

        return new UserResource($user);
    }
    public  function  destroy(User $user ){
        $user->delete();
        return  response([
            "data"=>"user deleted! ",
            "status" =>200
        ]);
    }
    public  function dashboard(){
        return  response([
            "data"=>" ",
            "status" =>200
        ]);
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
