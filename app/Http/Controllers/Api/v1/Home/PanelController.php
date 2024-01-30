<?php

namespace App\Http\Controllers\Api\v1\Home;

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Resources\v1\Admin\Collections\TransactionCollection;
use App\Http\Resources\v1\Admin\Resources\UserResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class PanelController extends AdminController
{
    public  function  index(Request $request){
        $user = User::whereApi_token($request->bearerToken())->first();
        return  new UserResource($user);
    }
    public function update(Request $request){
        $user = User::whereApi_token($request->bearerToken())->first();
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
            "email"=>$request->email,
            "mobile"=>$request->mobile,
            "avatar"=>$src,
            "body"=>$request->body,
        ]);

        return new UserResource($user);
    }
    public  function  transactions(Request $request){
        $user = User::whereApi_token($request->bearerToken())->first();
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
