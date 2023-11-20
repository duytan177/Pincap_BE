<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TagController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [\App\Http\Controllers\AuthController::class,'login'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\AuthController::class,'logout'])->name('logout');
    Route::post('/register', [\App\Http\Controllers\AuthController::class,'register'])->name('register');
});
Route::group(['middleware' => 'api'], function ($router) {
    Route::resource("user",Usercontroller::class);
    Route::post("user/report/{userId}/{mediaId}",[Usercontroller::class,'reportMedia']);

    Route::resource("media",MediaController::class);
    Route::post("media/download/1",[MediaController::class,'downloadMedias']);

    Route::resource("album",AlbumController::class);
    Route::put("/album/{album}/addUsers",[AlbumController::class,'addUsersToJoinAlbum']);

    Route::resource("tag",TagController::class);

    //test thôi
    Route::post("/media-test/{media}",[MediaController::class,'update']);
});
