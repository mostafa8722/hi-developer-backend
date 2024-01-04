<?php

namespace App\Http\Resources\v1\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            "data"=>$this->collection->map(function($item){

                return [
                    "id"=>$item->id,
                    "user"=>$item->user,
                    "course"=>$item->course,
                    "payment"=>$item->payment,
                    "price"=>$item->price,
                    "discount"=>$item->discount,
                    "body"=>$item->body,
                    "date"=>$item->created_at,
                    "transaction_code"=>$item->transaction_code,

                ];

            })


        ];
    }
    public  function with($request)
    {
        return ["status"=>200];
    }
}
