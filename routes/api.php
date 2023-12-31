<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\Admin\ArticleController as AdminArticle;
use App\Http\Controllers\Api\v1\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Api\v1\Admin\CommentController as AdminComment;
use App\Http\Controllers\Api\v1\Admin\ContactController as AdminContact;
use App\Http\Controllers\Api\v1\Admin\LanguageController as AdminLanguage;
use App\Http\Controllers\Api\v1\Admin\BannerController as AdminBanner;
use App\Http\Controllers\Api\v1\Admin\ColorController as AdminColor;
use App\Http\Controllers\Api\v1\Admin\NotificationController as AdminNotification;
use App\Http\Controllers\Api\v1\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Api\v1\Admin\PageController as AdminPage;
use App\Http\Controllers\Api\v1\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Api\v1\Admin\ProductFeatureController as AdminProductFeature;
use App\Http\Controllers\Api\v1\Admin\PermissionController as AdminPermission;
use App\Http\Controllers\Api\v1\Admin\RoleController as AdminRole;
use App\Http\Controllers\Api\v1\Admin\SellController as AdminSell;
use App\Http\Controllers\Api\v1\Admin\SizeController as AdminSize;
use App\Http\Controllers\Api\v1\Admin\TagController as AdminTag;
use App\Http\Controllers\Api\v1\Admin\TransactionController as AdminTransaction;
use App\Http\Controllers\Api\v1\Admin\UserAddressController as AdminUserAddress;
use App\Http\Controllers\Api\v1\Admin\UserController as AdminUser;

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

    Route::prefix("banners")->controller(AdminBanner::class)->group(function (){
        $table = "banners";
        $row = "banner";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });


    Route::prefix("categories")->controller(AdminCategory::class)->group(function (){
        $table = "categories";
        $row = "category";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });
    Route::prefix("colors")->controller(AdminColor::class)->group(function (){
        $table = "colors";
        $row = "color";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("comments")->controller(AdminComment::class)->group(function (){
        $table = "comments";
        $row = "comment";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("contacts")->controller(AdminContact::class)->group(function (){
        $table = "contacts";
        $row = "contact";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("languages")->controller(AdminLanguage::class)->group(function (){
        $table = "languages";
        $row = "language";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("notifications")->controller(AdminNotification::class)->group(function (){
        $table = "notifications";
        $row = "notification";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("orders")->controller(AdminOrder::class)->group(function (){
        $table = "orders";
        $row = "order";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });


    Route::prefix("pages")->controller(AdminPage::class)->group(function (){
        $table = "pages";
        $row = "page";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("permissions")->controller(AdminPermission::class)->group(function (){
        $table = "permissions";
        $row = "permission";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("products")->controller(AdminProduct::class)->group(function (){
        $table = "products";
        $row = "product";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("productFeatures")->controller(AdminProductFeature::class)->group(function (){
        $table = "productFeatures";
        $row = "productFeature";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("roles")->controller(AdminRole::class)->group(function (){
        $table = "roles";
        $row = "role";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("sells")->controller(AdminSell::class)->group(function (){
        $table = "sells";
        $row = "sell";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("sizes")->controller(AdminSize::class)->group(function (){
        $table = "sizes";
        $row = "size";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });



    Route::prefix("tags")->controller(AdminTag::class)->group(function (){
        $table = "tags";
        $row = "tag";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("transactions")->controller(AdminTransaction::class)->group(function (){
        $table = "transactions";
        $row = "transaction";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
        Route::delete('/{'.$row.'}', 'destroy')->name("$table.delete");
    });

    Route::prefix("userAddresses")->controller(AdminUserAddress::class)->group(function (){
        $table = "userAddresses";
        $row = "userAddress";
        Route::get('/', 'index')->name("$table.index");
        Route::get('/create', 'create')->name("$table.create");
        Route::post('', 'store')->name("$table.store");
        Route::get('/edit/{'.$row.'}', 'edit')->name("$table.edit");
        Route::put('/{'.$row.'}', 'update')->name("$table.update");
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
