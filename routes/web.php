<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentReactionsController;
use App\Http\Controllers\PrivacySettingController;
use App\Http\Controllers\ReelsController;
use App\Http\Controllers\AdvertisementController;


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
    Route::get('reels',[ReelsController::class,'create'])->name('reels');
    Route::resource('advertisement',AdvertisementController::class)->names([
    'index' => 'advertisement.index',
    'create' => 'advertisement.create',
    'store' => 'advertisement.store',
    'show' => 'advertisement.show',
    'edit' => 'advertisement.edit',
    'update' => 'advertisement.update',
    'destroy' => 'advertisement.destroy',]);
    Route::delete('delete_reel/{id}', [ReelsController::class,'destroy'])->name('delete_reel');
    Route::resource('category_admin', CategoryController::class);
    Route::get('/users_admin', [AuthController::class, 'getusers'])->name('users_admin');
    Route::get('/products_admin', [ProductController::class, 'create'])->name('products_admin');
    Route::get('/filterproduct', [ProductController::class, 'filterproduct'])->name('filterproduct');
    Route::delete('delete_product/{id}',[ProductController::class, 'destroy'])->name('delete_product');
    Route::get('accepted_product/{id}', [ProductController::class, 'edit'])->name('accepted_product');
    Route::delete('user_delete/{id}',[AuthController::class, 'destroy'])->name('user_delete');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
 
    Route::get('/api/product/files/{id}', function ($id) {
    $product = App\Models\product::with('files')->findOrFail($id);
    return response()->json($product->files);
});
});

   Route::post('/login_admin', [AuthController::class, 'login_admin'])->name('login_admin');
    Route::get('/login', function () {
        return view('sign-in');
    })->name('login');

