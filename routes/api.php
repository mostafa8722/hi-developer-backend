<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\Admin\ArticleController as AdminArticle;
use App\Http\Controllers\Api\v1\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Api\v1\Admin\CommentController as AdminComment;

use App\Http\Controllers\Api\v1\Admin\CourseController as AdminCourse;
use App\Http\Controllers\Api\v1\Admin\EpisodeController as AdminEpisode;

use App\Http\Controllers\Api\v1\Admin\NotificationController as AdminNotification;

use App\Http\Controllers\Api\v1\Admin\PageController as AdminPage;
use App\Http\Controllers\Api\v1\Admin\PermissionController as AdminPermission;
use App\Http\Controllers\Api\v1\Admin\RoleController as AdminRole;

use App\Http\Controllers\Api\v1\Admin\TagController as AdminTag;
use App\Http\Controllers\Api\v1\Admin\TestimonialController as AdminTestimonial;
use App\Http\Controllers\Api\v1\Admin\TransactionController as AdminTransaction;

use App\Http\Controllers\Api\v1\Admin\UserController as AdminUser;
use App\Http\Controllers\Api\v1\Admin\AuthController as AuthController;
use App\Http\Controllers\Api\v1\Home\HomeController as HomeController;
use App\Http\Controllers\Api\v1\Home\PanelController as PanelUser;

/*
|----------------------RoleController----------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(["prefix"=>"v1/admin","middleware"=>"admin"],function(){
    Route::get('/dashboard',[AdminUser::class,"dashboard"] )->name("users.dashboard");


    Route::prefix("articles")->controller(AdminArticle::class)->group(function (){
        $table = "articles";
        $row = "article";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/delete/{'.$row.'}', 'destroy')->name("$table.delete");
    });



    Route::prefix("categories")->controller(AdminCategory::class)->group(function (){
        $table = "categories";
        $row = "category";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("comments")->controller(AdminComment::class)->group(function (){
        $table = "comments";
        $row = "comment";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");

        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/create/{'.$row.'}', 'store')->name("$table.store");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("courses")->controller(AdminCourse::class)->group(function (){
        $table = "courses";
        $row = "course";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("episodes")->controller(AdminEpisode::class)->group(function (){
        $table = "episodes";
        $row = "episode";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });


//
//    Route::prefix("contacts")->controller(AdminContact::class)->group(function (){
//        $table = "contacts";
//        $row = "contact";
//        Route::get('/', 'index')->name("$table.index");
//        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
//        Route::put('/{'.$row.'}', 'update')->name("$table.update");
//        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
//    });



    Route::prefix("notifications")->controller(AdminNotification::class)->group(function (){
        $table = "notifications";
        $row = "notification";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });




    Route::prefix("pages")->controller(AdminPage::class)->group(function (){
        $table = "pages";
        $row = "page";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });


    Route::prefix("permissions")->controller(AdminPermission::class)->group(function (){
        $table = "permissions";
        $row = "permission";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });


    Route::prefix("roles")->controller(AdminRole::class)->group(function (){
        $table = "roles";
        $row = "role";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });







    Route::prefix("tags")->controller(AdminTag::class)->group(function (){
        $table = "tags";
        $row = "tag";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("testimonials")->controller(AdminTestimonial::class)->group(function (){
        $table = "testimonials";
        $row = "testimonial";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });
    Route::prefix("transactions")->controller(AdminTransaction::class)->group(function (){
        $table = "transactions";
        $row = "transaction";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });



    Route::prefix("users")->controller(AdminUser::class)->group(function (){
        $table = "users";
        $row = "user";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/update/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/delete/{'.$row.'}', 'destroy')->name("$table.delete");
    });



});



    Route:: prefix("v1/user")->middleware("user")->controller(PanelUser::class)->group(function (){

        $table = "users";
        $row = "user";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/courses', 'courses')->name("$table.courses");
        Route::get('/likes', 'likes')->name("$table.likes");
        Route::post('/save/like', 'saveLike')->name("$table.saveLike");
        Route::post('/save/comment', 'saveComment')->name("$table.saveComment");
        Route::get('/comments', 'comments')->name("$table.comments");
        Route::get('/transactions', 'transactions')->name("$table.transactions");
        Route::get('/episodes', 'episodes')->name("$table.episodes");
        Route::get('/notifications', 'notifications')->name("$table.notifications");
        Route::get('/edit', 'edit')->name("$table.edit");
        Route::put('/update', 'update')->name("$table.update");
        Route::post('/updateImage', 'updateImage')->name("$table.updateImage");
        Route::put('/updatePassword', 'updatePassword')->name("$table.updatePassword");
      //  Route::delete('/delete/{'.$row.'}', 'destroy')->name("$table.delete");

});


Route::post('/v1/register', [AuthController::class,'register']);
Route::post('/v1/login', [AuthController::class,'login']);
Route::post('/v1/verify/code', [AuthController::class,'verifyCode']);
Route::post('/v1/reset/password', [AuthController::class,'resetPassword']);
Route::post('/v1/forget/password', [AuthController::class,'forgetPassword']);
Route::post('/v1/resend/code', [AuthController::class,'resendCode']);
Route::get('/v1/home', [HomeController::class,'index']);
Route::get('/v1/articles', [HomeController::class,'articles']);
Route::get('/v1/articles/{slug}', [HomeController::class,'article']);
Route::get('/v1/courses', [HomeController::class,'courses']);
Route::get('/v1/courses/{course}', [HomeController::class,'course']);
Route::get('/v1/episode/{slug}/{number}', [HomeController::class,'episode']);
Route::get('/v1/page/{page}', [HomeController::class,'customPage']);
