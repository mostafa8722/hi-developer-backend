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
        if(isset($request->image)){
            $image = $request->image;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"users",time().$ext);
        }

        User::create([

            "name"=>$request->name,
            "username"=>$request->username,
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
                "status" =>422
            ],422);
        }
        $src = null;
        if(isset($request->image)){
            $image = $request->image;
            $ext= $image->getClientOriginalExtension();
            $ext = ".".strtolower($ext);
            $src = $this->uploadImages($image,"users",time().$ext);
        }else{
            $src = $user->image??$src;
        }
        $user->update([
            "name"=>$request->name,
            "username"=>$request->username,
            "email"=>$request->email,
            "status"=>$request->status,
            "avatar"=>$src,
            "body"=>$request->body,
            "password"=>Hash::make(trim($request->password)),
        ]);

        return new UserResource($user);
    }
    public  function  delete(User $user ){
        $user->delete();
        return  response([
            "data"=>"user deleted! ",
            "status" =>200
        ]);
    }
    public  function checkUserValidation(Request $request){

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
