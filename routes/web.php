<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\CategoryController;




Route::middleware('jwt.session')->group(function () {
    Route::resource('dashboard_admin', dashboardcontroller::class)->names([
    'index' => 'dashboard_admin.index',
    'create' => 'dashboard_admin.create',
    'store' => 'dashboard_admin.store',
    'show' => 'dashboard_admin.show',
    'edit' => 'dashboard_admin.edit',
    'update' => 'dashboard_admin.update',
    'destroy' => 'dashboard_admin.destroy',]);
    
    Route::get('categories_admin',[CategoryController::class,'create'])->name('categories_admin');
    Route::resource('category_admin', CategoryController::class);
    Route::get('/users_admin', [AuthController::class, 'getusers'])->name('users_admin');
    ROute::delete('user_delete/{id}',[AuthController::class, 'destroy'])->name('user_delete');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
   Route::post('/login_admin', [AuthController::class, 'login_admin'])->name('login_admin');

Route::get('/login', function () {
    return view('sign-in');
})->name('login');

