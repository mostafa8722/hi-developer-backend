<?php

namespace App\Http\Resources\v1\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "user"=>$this->user,
            "course"=>$this->course,
            "payment"=>$this->payment,
            "price"=>$this->price,
            "discount"=>$this->discount,
            "body"=>$this->body,
            "date"=>$this->created_at,
            "transaction_code"=>$this->transaction_code,

        ];
    }
    public function with(Request $request)
    {
        return ["status"=>200];
    }
}
