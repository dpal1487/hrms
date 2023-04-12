<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('login/{provider}', [SocialLoginController::class, 'redirectToGoogle']);
Route::get('login/{provider}/callback', [SocialLoginController::class, 'handleCallback']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index']);

    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('/', 'index')->name('employees.index');
            Route::get('/add', 'create')->name('employees.add');
            Route::post('/store', 'store')->name('employees.store');
            Route::get('{id}/edit', 'edit')->name('employees.edit');
            Route::post('{id}/update', 'update')->name('employees.update');
            Route::delete('{id}/delete', 'destroy')->name('employees.delete');
        });
    });
});
