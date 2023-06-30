<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::get('sliders', [IndexController::class, 'sliders']);
    Route::get('testimonials', [TestimonialController::class, 'index']);
    Route::get('services', [ServiceController::class, 'index']);
    Route::get('service/{slug}', [ServiceController::class, 'show']);
    Route::post('contact-us', [IndexController::class, 'contactUs']);
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blog/{slug}', [BlogController::class, 'show']);
    Route::prefix("redirect")->group(function () {
        Route::get("complete", [RedirectController::class, 'status']);
        Route::get("quotafull", [RedirectController::class, 'status']);
        Route::get("terminate", [RedirectController::class, 'status']);
        /*Own Redirect*/
        Route::get("own/complete", [RedirectController::class, 'redirect']);
        Route::get("own/quotafull", [RedirectController::class, 'redirect']);
        Route::get("own/terminate", [RedirectController::class, 'redirect']);
    });
});
