<?php

// LoginController
use App\Http\Controllers\Api\Auth\LoginController;
/* Forget Controller*/
use App\Http\Controllers\Api\Auth\ForgetController;
/*Register Controller*/
use App\Http\Controllers\Api\Auth\RegisterController;
/*Account Controller*/
use App\Http\Controllers\Api\Account\EmailController;
use App\Http\Controllers\Api\Account\FavouriteController;
use App\Http\Controllers\Api\Account\MyAdsController;
use App\Http\Controllers\Api\Account\NotificationController;
use App\Http\Controllers\Api\Account\ReviewController;
use App\Http\Controllers\Api\Account\AccountController;
use App\Http\Controllers\Api\Account\AddressController;
use App\Http\Controllers\Api\Account\AdReviewController;
use App\Http\Controllers\Api\Account\CouponsController;
use App\Http\Controllers\Api\Account\CustomerController;
/*Category Controller*/
use App\Http\Controllers\Api\CategoryController;
/*Conversation Controller*/
use App\Http\Controllers\Api\ConversationController;
/*Image Controller*/
use App\Http\Controllers\Api\ImageController;
/*Item Controller*/
use App\Http\Controllers\Api\ItemController;
/*Location Controller*/
use App\Http\Controllers\Api\LocationController;
/*Message Controller*/
use App\Http\Controllers\Api\MessageController;
/*Plan Controller*/
use App\Http\Controllers\Api\PlanController;
/*Post Controller*/
use App\Http\Controllers\Api\PostController;
/*Profile Controller*/
use App\Http\Controllers\Api\ProfileController;
/*Search Controller*/
use App\Http\Controllers\Api\SearchController;
/*Setting Controller*/
use App\Http\Controllers\Api\SettingController;
/*Subscription Controller*/
use App\Http\Controllers\Api\SubscriptionController;
/*User Controller*/
use App\Http\Controllers\Api\UserController;
/*Welcome Controller*/
use App\Http\Controllers\Api\WelcomeController;

use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\Auth\SocialController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {
        /*Login Controllers*/
        Route::post('login', [LoginController::class, 'authenticate']);
        /*Register Controllers*/
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('register/verify-otp', [RegisterController::class, 'verify']);
        Route::post('register/resend-otp', [RegisterController::class, 'register']);
        /*Forget Controller*/
        Route::post('forget', [ForgetController::class, 'forget']);
        Route::post('forget/verify', [ForgetController::class, 'verify']);
        Route::post('forget/resend', [ForgetController::class, 'resend']);

        Route::get('', [SocialController::class, 'index']);
        Route::get('sociallogin/{provider}', [SocialController::class, 'SocialSignup']);
        Route::get('sociallogin/{provider}/callback', [SocialController::class, 'loginWithSocial']);
    });

    Route::group(['prefix' => 'welcome'], function () {
        Route::get('/', [WelcomeController::class, 'index']);
        Route::get('/banners', [WelcomeController::class, 'banners']);
        Route::get('/featured', [WelcomeController::class, 'featureItems']);
        Route::get('/new-items', [WelcomeController::class, 'newItems']);
    });

    Route::get('premium-collections', [WelcomeController::class, 'getPremiums']);
    Route::get('fetch', [AppController::class, 'index']);

    Route::get('/categories', [CategoryController::class, 'index']);


    Route::middleware('auth:sanctum')->group(function () {
        Broadcast::routes(['middleware' => ['auth:sanctum']]);
        Route::post('logout', [LoginController::class, 'logout']);
        Route::get('user/me', [LoginController::class, 'user']);
        /*Account Controller*/
        Route::group(['prefix' => 'account'], function () {
            /*Image*/
            Route::post('image', [ImageController::class, 'userImage']);
            /*User*/
            Route::get('user', [AccountController::class, 'index']);
            Route::post('user', [AccountController::class, 'update']);
            /*Email*/
            Route::post('email/send-otp', [EmailController::class, 'sendOtp']);
            Route::post('email/verify-otp', [EmailController::class, 'verifyOtp']);
            /*Address*/
            Route::get('address', [AddressController::class, 'index']);
            Route::post('address', [AddressController::class, 'store']);
            /*Review*/
            Route::get('reviews', [ReviewController::class, 'myReviews']);
            Route::delete('review/{id}', [ReviewController::class, 'remove']);
            /*Favourite*/
            Route::get('favourites', [FavouriteController::class, 'index']);
            Route::post('favourite/{id}', [FavouriteController::class, 'store']);
            Route::delete('favourite/{id}', [FavouriteController::class, 'destroy']);
            /*Notifications*/
            Route::get('notifications', [NotificationController::class, 'index']);
            Route::get('notify', [NotificationController::class, 'notify']);
            Route::get('mark_as_read', [NotificationController::class, 'markAsRead']);
            Route::get('mark_as_unread', [NotificationController::class, 'markAsUnread']);
            Route::post('notification/add', [NotificationController::class, 'store']);
            Route::post('notification/remove', [NotificationController::class, 'destroy']);
            /*Coupons*/
            Route::get('coupons', [CouponsController::class, 'index']);
        });
        /*My Ads*/
        Route::group(['prefix' => 'my-ads'], function () {
            Route::get('', [MyAdsController::class, 'index']);
            Route::delete('delete/{id}', [MyAdsController::class, 'delete']);
            Route::put('status/{id}', [MyAdsController::class, 'activateOrDeactivate']);
            Route::get('customers/{id}', [CustomerController::class, 'index']);
            Route::post('customers/send-otp', [CustomerController::class, 'sendOtp']);
            Route::get('reviews/{id}', [AdReviewController::class, 'index']);
            Route::get('review/report/{id}', [AdReviewController::class, 'report']);
        });
        /*Post Ads*/
        Route::group(['prefix' => 'post'], function () {
            Route::get('', [PostController::class, 'index']);
            Route::post('', [PostController::class, 'store']);
            Route::put('', [PostController::class, 'update']);
            Route::post('success', [PostController::class, 'success']);
            Route::get('edit', [PostController::class, 'edit']);
            Route::post('image', [ImageController::class, 'post']);
        });
        /*Messaging*/
        Route::post('conversations', [ConversationController::class, 'index']);
        Route::post('messages', [MessageController::class, 'index']);
        Route::get('message/compose', [MessageController::class, 'compose']);
        Route::post('message/send', [MessageController::class, 'store']);
        /*Setting*/
        Route::put('setting/update-password', [SettingController::class, 'updatePassword']);
    });
    /*Item*/
    Route::group(['prefix' => 'item'], function () {
        Route::get('', [ItemController::class, 'index']);
        Route::get('related', [ItemController::class, 'related']);
        Route::get('report/{id}', [ItemController::class, 'getReportsItems']);
        Route::post('report/{id}', [ItemController::class, 'report']);
        Route::get('reviews/{id}', [ReviewController::class, 'index']);
        Route::group(['middleware' => ['auth:api']], function () {
            Route::delete('delete/{id}', [ReviewController::class, 'destroy']);
            Route::get('write-review/{id}', [ReviewController::class, 'edit']);
            Route::post('write-review/{id}', [ReviewController::class, 'createOrUpdate']);
            Route::post('review/report/{id}', [ReviewController::class, 'report']);
            Route::delete('review/remove/{id}', [ReviewController::class, 'remove']);
        });
    });

    Route::get('profile/{id}', [ProfileController::class, 'index']);
    Route::get('profile/reviews/{id}', [ProfileController::class, 'getReviews']);
    Route::post('profile/follow', [ProfileController::class, 'follow']);
    Route::post('profile/unfollow', [ProfileController::class, 'follow']);

    Route::get('location/states', [LocationController::class, 'states']);

    Route::get('location/cities', [LocationController::class, 'cities']);
    Route::get('packages', [PlanController::class, 'index']);
    Route::group(['prefix' => 'package'], function () {
        Route::post('order/{plan}', [PlanController::class, 'placeOrder']);
        Route::get('paysuccess', [PlanController::class, 'razorPaySuccess']);
        Route::get('bougth-packages', [SubscriptionController::class, 'active']);
        Route::get('bougth-packages/expired', [SubscriptionController::class, 'expired']);
    });

    Route::get('codes.json', [LocationController::class, 'codes']);

    Route::get('search', [SearchController::class, 'index']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('{id}', [UserController::class, 'index']);
        Route::get('items/{id}', [UserController::class, 'items']);
    });
});
