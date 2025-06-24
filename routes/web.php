<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;


// Route::middleware(['auth'])->group(function () {
// Route::get('/dashboard', function () {
//     return view('dashboard');
// });
// });

Route::middleware('jwt.session')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'));
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

   Route::post('/login_admin', [AuthController::class, 'login_admin'])->name('login_admin');

Route::get('/login', function () {
    return view('sign-in');
})->name('login');

