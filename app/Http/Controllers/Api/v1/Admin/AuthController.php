<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\Admin\MainController;


use App\Http\Resources\v1\Admin\Resources\UserResource;
use App\Mail\VerifiedEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends MainController
{
    public  function register(Request $request){
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
            $src = $this->uploadFile($image,"users",time().$ext);
        }
        $user = User::whereEmail($request->email)->first();
        if($user)
            return  response([
                "data"=>"این ایمیل قبلا ثبت شده است ",
                "status" =>422
            ],422);


        $user= User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password,
            "api_token"=> Str::random(60),
        ]);
        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);

        Mail::to($user->email)->send(new VerifiedEmail($user));

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public  function login(Request $request){

        if($this->checkLoginValidation($request)){
            return  response([
                "data"=>$this->checkLoginValidation($request),
                "status" =>422
            ],422);
        }


        $user = User::whereEmail(trim($request->email))->first();

        if (!isset($user)) {
            return  response([
                "data"=>" ایمیل وارد شده وجود ندارد  ",
                "status" =>204
            ],204);
        }

        if (!Hash::check(trim($request->password), $user->password)) {
            return  response([
                "data"=>" رمز عبور اشتباه می باشد ",
                "status" =>404
            ],404);
        }

        $user->update([ "api_token"=> Str::random(60)]);

        return new UserResource($user);



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
        else if(!$this->validPassword($request->password)  )
            $message = "رمز عبور باید حداقل 6 رقمی و شامل حروف کوچک و بزرگ باشد";

        return $message;
    }

    public  function checkLoginValidation(Request $request){

        $message = "";
        if(!$this->validEmail($request->email)  )
            $message = "ایمیل وارد شده صحیح نمی باشد";
        else if(!$this->validPassword($request->password)  )
            $message = "رمز عبور باید حداقل 6 رقمی و شامل حروف کوچک و بزرگ باشد";

        return $message;
    }
}
