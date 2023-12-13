<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MediaReportController;
use App\Http\Controllers\ReportReasonController;
use App\Http\Controllers\FeelingController;
use App\Http\Controllers\ReactionMediaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReactionCommentController;
use App\Http\Controllers\ReactionReplyController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [\App\Http\Controllers\AuthController::class,'login'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\AuthController::class,'logout'])->name('logout');
    Route::post('/register', [\App\Http\Controllers\AuthController::class,'register'])->name('register');
});
Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'user'],function ($router){
        Route::post("report/{userId}/{mediaId}",[Usercontroller::class,'reportMedia']);
        Route::get("/search",[Usercontroller::class,'findUser']);
    });
    Route::resource("user",Usercontroller::class);


    Route::group(['prefix' => 'media'],function ($router){
        Route::post("/download/1",[MediaController::class,'downloadMedias']);
        Route::get("/search",[MediaController::class,'findMediaByTag']);
    });
    Route::resource("media",MediaController::class);


    Route::group(['prefix' => 'album'],function ($router){
        Route::post("/{album}/addUsers",[AlbumController::class,'addUsersToJoinAlbum']);
        Route::post("/archive",[AlbumController::class,'archive']);
    });
    Route::resource("album",AlbumController::class);

    Route::resource("tag",TagController::class);

    Route::resource("reportMedia",MediaReportController::class);

    Route::resource("reasonReport",ReportReasonController::class);

    Route::resource("feelings",FeelingController::class);

    Route::resource("reactionMedia",ReactionMediaController::class);

    Route::resource("comments",CommentController::class);

    Route::resource("replies",ReplyController::class);

    Route::resource("reactionComments",ReactionCommentController::class);

    Route::resource("reactionReplies",ReactionReplyController::class);
    //test thôi
    Route::post("/media-test/{media}",[MediaController::class,'update']);
});

