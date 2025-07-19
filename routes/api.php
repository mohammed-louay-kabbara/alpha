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
use  App\Http\Controllers\CommentReactionsController;
use  App\Http\Controllers\PrivacySettingController;
use  App\Http\Controllers\ReportController;
use  App\Http\Controllers\AdvertisementController;
use  App\Http\Controllers\SessionController;
use  App\Http\Controllers\NotificationController;
use  App\Services\FirebaseService;



Route::get('/test-notification', function (FirebaseService $firebase) {
    $deviceToken = 'توكن جهاز الهاتف من FCM';

    return $firebase->sendNotification(
        $deviceToken,
        'مرحبا بك!',
        'تم إرسال الإشعار بنجاح 🎉'
    );
});




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
    Route::post('editpassword', [AuthController::class, 'editpassword']);
    Route::post('forgotpassword', [AuthController::class, 'forgot_password']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'sendVerificationCode']);
    Route::post('reset-password', [AuthController::class, 'verifyResetCode']);
    Route::post('count_profile', [AuthController::class, 'count_profile']);
    Route::post('info_user', [AuthController::class, 'info_user']);
    Route::post('pictureupdate', [AuthController::class, 'pictureupdate']);

    Route::post('notify', [NotificationController::class, 'sendTest']);



    Route::get('my_profile', [AuthController::class, 'my_profile']);
    Route::get('advertisements', [AdvertisementController::class, 'ad']);
    Route::resource('commentReactions',CommentReactionsController::class);
    Route::get('my_products', [AuthController::class, 'my_products']);
    Route::get('my_reels', [AuthController::class, 'my_reels']);
    Route::resource('reels', ReelsController::class);
    Route::resource('Report', ReportController::class);
    Route::get('show_products/{id}',[ProductController::class,'show']);
    Route::post('product_sold',[ProductController::class,'sold']);
    Route::get('show_reels/{id}',[ReelsController::class,'show']);
    Route::resource('PrivacySetting', PrivacySettingController::class);
    Route::post('profilevisibility',[PrivacySettingController::class,'profilevisibility']);
    Route::post('commentpermission',[PrivacySettingController::class,'commentpermission']);
    Route::post('reactionvisibility',[PrivacySettingController::class,'reactionvisibility']);
    Route::resource('reelLikes', ReelLikesController::class);
    Route::resource('reelComments', ReelCommentsController::class);
    Route::resource('favorite', FavoriteController::class);
    Route::resource('story', StoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('productLike', ProductLikeController::class);
    Route::post('searchProducts', [ProductController::class,'searchProducts']);
    Route::post('searchUsers', [AuthController::class,'searchUsers']);
    Route::get('pagesproduct', [ProductController::class,'getUsersWithProducts']);
    Route::resource('ProductComments', ProductCommentsController::class);
    Route::resource('follower', FollowerController::class);
    Route::get('getFollower', [FollowerController::class,'getFollower']);
     Route::get('suggestedFollows', [FollowerController::class,'suggestedFollows']);
    Route::get('Users', [AuthController::class,'users']);
     Route::delete('deletefollower', [FollowerController::class,'deleteFollower']);
    Route::get('homereels',[ReelsController::class,'homereels']);
    Route::post('session/start', [SessionController::class, 'startSession']);
    Route::post('session/end', [SessionController::class, 'endSession']);
    Route::post('/store-device-token', [AuthController::class, 'storeDeviceToken']);
