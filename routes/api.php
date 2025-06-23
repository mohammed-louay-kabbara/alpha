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
use  App\Http\Controllers\FollowerController;




Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

    Route::post('login', [AuthController::class, 'login']);
    // Route::post('/login_admin', [AuthController::class, 'login_admin'])->name('login_admin');
    Route::put('editpassword', [AuthController::class, 'editpassword']);
    
    Route::put('forgotpassword', [AuthController::class, 'forgot_password']);

    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'sendVerificationCode']);
    Route::post('reset-password', [AuthController::class, 'verifyResetCode']);
    Route::post('count_profile', [AuthController::class, 'count_profile']);
    Route::post('info_user', [AuthController::class, 'info_user']);
    Route::resource('reels', ReelsController::class);
    Route::get('show_products/{id}',[ProductController::class,'show']);
    Route::get('show_reels/{id}',[ReelsController::class,'show']);
    Route::resource('reelLikes', ReelLikesController::class);
    Route::resource('reelComments', ReelCommentsController::class);
    Route::resource('favorite', FavoriteController::class);
    Route::resource('story', StoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('productLike', ProductLikeController::class);
    Route::post('searchProducts', [ProductController::class,'searchProducts']);
    Route::post('searchUsers', [AuthController::class,'searchUsers']);
    Route::resource('ProductComments', ProductCommentsController::class);

    Route::resource('follower', FollowerController::class);

    Route::get('homereels',[ReelsController::class,'homereels']);
