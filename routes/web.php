<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardcontroller;




Route::middleware('jwt.session')->group(function () {
    Route::resource('dashboard_admin', dashboardcontroller::class);
     Route::resource('category_admin', CategoryController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

   Route::post('/login_admin', [AuthController::class, 'login_admin'])->name('login_admin');

Route::get('/login', function () {
    return view('sign-in');
})->name('login');

