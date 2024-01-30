<?php
namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\NotificationCollection;
use App\Http\Resources\v1\Admin\Resources\NotificationResource;
use App\Models\Notification;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(Request $request)
    {


        $notifications = new Notification();

        if (isset($request->user_id))
            $notifications = $notifications->where("user_id", "=", $request->user_id);



        $notifications = $notifications->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy) === "asc" ? 'ASC' : 'DESC')->paginate(15);
        return new NotificationCollection($notifications);
    }

    public function create()
    {
        return response([
            "data" => "امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" => 200
        ], 200);
    }

    public function edit(Notification $notification)
    {
        return new NotificationResource($notification);
    }


    public function update(Request $request, Notification $notification)
    {

        if ($this->checkNotificationValidation($request)) {
            return response([
                "data" => $this->checkNotificationValidation($request),
                "status" => 422
            ], 422);
        }

        $notification->update(["seen" => $request->seen,]);

        return new NotificationResource($notification);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response([
            "data" => "notification deleted! ",
            "status" => 200
        ]);
    }

    public function checkNotificationValidation(Request $request)
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

