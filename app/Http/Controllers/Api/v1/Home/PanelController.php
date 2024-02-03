<?php

namespace App\Http\Controllers\Api\v1\Home;

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Resources\v1\Admin\Collections\TransactionCollection;
use App\Http\Resources\v1\Admin\Resources\UserResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PanelController extends AdminController
{
    public  function  index(Request $request){
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        return  new UserResource($user);
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
