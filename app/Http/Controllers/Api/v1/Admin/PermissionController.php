<?php

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Resources\v1\Admin\Collections\PermissionCollection;
use App\Http\Resources\v1\Admin\Resources\PermissionResource;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends AdminController
{

    public function index(Request $request){


        $permissions = new Permission();


        $permissions = $permissions->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new PermissionCollection($permissions);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Permission $permission){
        return new PermissionResource($permission);
    }
    public function store(Request $request){

        if($this->checkPermissionValidation($request)){
            return  response([
                "data"=>$this->checkPermissionValidation($request),
                "status" =>422
            ],422);
        }

        Permission::create([
            "title"=>$request->title,
            "en_title"=>$request->en_title,
            "section"=>$request->section,
            "body"=>$request->body,
        ]);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Permission $permission){

        if($this->checkPermissionValidation($request)){
            return  response([
                "data"=>$this->checkPermissionValidation($request),
                "status" =>422
            ],422);
        }

        $permission->update([
            "title"=>$request->title,
            "en_title"=>$request->en_title,
            "section"=>$request->section,
            "body"=>$request->body,
        ]);

        return new PermissionResource($permission);
    }
    public  function  delete(Permission $permission ){
        $permission->delete();
        return  response([
            "data"=>"دسترسی  با موفقیت حذف شد ",
            "status" =>200
        ]);
    }
    public  function checkPermissionValidation(Request $request){

        $message = "";
        if(!isset($request->title)  )
            $message = "عنوان نمی تواند خالی باشد";
        else if(strlen($request->title)<3  )
            $message = "عنوان باید حداقل شامل 3 حرف باشد";
        else if(strlen($request->title)>200  )
            $message = "عنوان حداکثر شامل 200 حرف می باشد";
        else if(!isset($request->en_title)  )
            $message = "عنوان شاخص نمی تواند خالی باشد";


        return $message;
    }


}
