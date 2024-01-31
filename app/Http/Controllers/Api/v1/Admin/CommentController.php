<?php




namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Admin\Collections\CommentCollection;
use App\Http\Resources\v1\Admin\Resources\CommentResource;
use App\Models\Comment;

use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request)
    {


        $comments = new Comment();

        if (isset($request->user_id))
            $comments = $comments->where("user_id", "=", $request->user_id);

        if (isset($request->course_id))
            $comments = $comments->where("course_id", "=", $request->course_id);

        if (isset($request->article_id))
            $comments = $comments->where("article_id", "=", $request->article_id);

        $comments = $comments->orderBy('id', isset($request->orderBy) && strtolower($request->orderBy) === "asc" ? 'ASC' : 'DESC')->paginate(15);
        return new CommentCollection($comments);
    }

    public function create()
    {
        return response([
            "data" => "امکان دسترسی بعد از اعتبارسنجی وجود دارد",
            "status" => 200
        ], 200);
    }

    public function edit(Comment $comment)
    {
        return new CommentResource($comment);
    }



    public function store(Resequest $request, Comment $comment)
    {

        if ($this->checkCommentValidation($request)) {
            return response([
                "data" => $this->checkCommentValidation($request),
                "status" => 422
            ], 422);
        }
        $user = User::whereApi_token(trim($request->bearerToken()))->first();
        Comment::create([
            "user_id"=>$user->id,
            "parent_id" => $comment->id,
            "article_id" => $comment->article_id,
            "course_id" => $comment->course_id,
            "episode_id" => $request->episode_id,
            "comment" => $request->comment,
            "status" => $request->status,



        ]);

        return new CommentResource($comment);
    }
    public function update(Request $request, Comment $comment)
    {


        $comment->update(["status" => $request->status,]);

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response([
            "data" => "comment deleted! ",
            "status" => 200
        ]);
    }

    public function checkCommentValidation(Request $request)
    {

        $message = "";
        if (!isset($request->comment))
            $message = "نظر نمی تواند خالی باشد";



        return $message;
    }


}
