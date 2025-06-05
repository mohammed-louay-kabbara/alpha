<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;
use  App\Http\Controllers\ReelsController;




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
    Route::resource('Reels', ReelsController::class);