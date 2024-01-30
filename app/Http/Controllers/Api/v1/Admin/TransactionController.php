<?php




namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\TransactionCollection;
use App\Http\Resources\v1\Admin\Resources\TransactionResource;
use App\Models\Transaction;

use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {


        $transactions = new Transaction();

        if (isset($request->user_id))
            $transactions = $transactions->where("user_id", "=", $request->user_id);

        if (isset($request->course_id))
            $transactions = $transactions->where("course_id", "=", $request->course_id);


        $transactions = $transactions->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy) === "asc" ? 'ASC' : 'DESC')->paginate(15);
        return new TransactionCollection($transactions);
    }

    public function create()
    {
        return response([
            "data" => "امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" => 200
        ], 200);
    }

    public function edit(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }



    public function update(Request $request, Transaction $transaction)
    {

        if ($this->checkTransactionValidation($request)) {
            return response([
                "data" => $this->checkTransactionValidation($request),
                "status" => 422
            ], 422);
        }

        $transaction->update(["status" => $request->status,]);

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response([
            "data" => "transaction deleted! ",
            "status" => 200
        ]);
    }

    public function checkTransactionValidation(Request $request)
    {

        $message = "";
        if (!isset($request->title))
            $message = "عنوان نمی تواند خالی باشد";
        else if (strlen($request->title) < 3)
            $message = "عنوان باید حداقل شامل 3 حرف باشد";
        else if (strlen($request->title) > 200)
            $message = "عنوان حداکثر شامل 200 حرف می باشد";


        return $message;
    }


}
