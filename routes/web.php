<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


Route::get('/test-mail', function () {
    Mail::raw('اختبار الإرسال عبر SMTP', function ($message) {
        $message->to('mohamedlouayk@gmail.com')
                ->subject('رسالة اختبار');
    });
    return 'تم الإرسال!';
});

Route::get('/', function () {
    return view('welcome');
});
