<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;
use  App\Http\Controllers\ReelsController;
use  App\Http\Controllers\ReelLikesController;
use  App\Http\Controllers\ReelCommentsController;
use  App\Http\Controllers\FavoriteController;
use  App\Http\Controllers\StoryController;
use  App\Http\Controllers\CategoryController;
use  App\Http\Controllers\ProductController;
use  App\Http\Controllers\ProductLikeController;
use  App\Http\Controllers\ProductCommentsController;




Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
    Route::post('login', [AuthController::class, 'login']);
    Route::put('editpassword', [AuthController::class, 'editpassword']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'sendVerificationCode']);
    Route::post('reset-password', [AuthController::class, 'verifyResetCode']);
    Route::resource('reels', ReelsController::class);
    Route::resource('reelLikes', ReelLikesController::class);
    Route::resource('reelComments', ReelCommentsController::class);
    Route::resource('favorite', FavoriteController::class);
    Route::resource('story', StoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('productLike', ProductLikeController::class);
    Route::resource('ProductComments', ProductCommentsController::class);