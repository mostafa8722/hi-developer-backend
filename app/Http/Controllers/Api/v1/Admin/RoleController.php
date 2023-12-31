<?php

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Resources\v1\Admin\Collections\RoleCollection;
use App\Http\Resources\v1\Admin\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends AdminController
{

    public function index(Request $request){


        $roles = new Role();


        $roles = $roles->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy)==="asc" ?'ASC':'DESC')->paginate(15);
        return new RoleCollection($roles);
    }

    public function create(){
        return  response([
            "data"=>"امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" =>200
        ],200);
    }
    public function edit(Role $role){
        return new RoleResource($role);
    }
    public function store(Request $request){

        if($this->checkRoleValidation($request)){
            return  response([
                "data"=>$this->checkRoleValidation($request),
                "status" =>422
            ],422);
        }

        $role =  Role::create([

            "title"=>$request->title,
            "en_title"=>$request->en_title,
            "body"=>$request->body,
        ]);
        $role->permissions()->sync($request->permissions);

        return  response([
            "data"=>"اطلاعات با موفقیت ذخیره شدند ",
            "status" =>200
        ]);
    }
    public function update(Request $request,Role $role){

        if($this->checkRoleValidation($request)){
            return  response([
                "data"=>$this->checkRoleValidation($request),
                "status" =>422
            ],422);
        }

        $role->update([
            "title"=>$request->title,
            "en_title"=>$request->en_title,
            "body"=>$request->body,
        ]);
        $role->permissions()->sync($request->permissions);

        return new RoleResource($role);
    }
    public  function  delete(Role $role ){
        $role->delete();
        return  response([
            "data"=>"دسترسی  با موفقیت حذف شد ",
            "status" =>200
        ]);
    }
    public  function checkRoleValidation(Request $request){

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
