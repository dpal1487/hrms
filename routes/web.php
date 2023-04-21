<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\DecisionMakerController;
use App\Http\Controllers\CompanyController;

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
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::post('/upload', [ImageController::class, 'uploadImage'])->name('upload');

    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('/', 'index')->name('employees.index');
            Route::get('/add', 'create')->name('employees.add');
            Route::post('/store', 'store')->name('employees.store');
            Route::get('{id}', 'show')->name('employees.view');
            Route::get('{id}/edit', 'edit')->name('employees.edit');
            Route::post('{id}/update', 'update')->name('employees.update');
            Route::get('{id}/overview', 'overview')->name('employees.overview');
            Route::get('{id}/overview/edit', 'overviewEdit')->name('employees.overview.edit');
            Route::get('{id}/settings', 'setting')->name('employees.settings');
            Route::get('{id}/security', 'security')->name('employees.security');
            Route::get('{id}/address', 'address')->name('employees.address');
            Route::get('{id}/address/edit', 'addressEdit')->name('employees.address.edit');
            Route::get('{id}/attendance', 'attendance')->name('employees.attendance');
            Route::post('{id}/email/update', 'emailUpdate')->name('employees.email.update');
            Route::post('{id}/change-password', 'changePassword')->name('employees.change-password');
            Route::delete('{id}/delete', 'destroy')->name('employees.delete');
            Route::post('{id}/deactivate', 'deactivate')->name('employees.deactivate');
        });
    });

    Route::group(['prefix' => 'employees'], function () {
        Route::post('{id}/address/update', [AddressController::class, 'update'])->name('employees.address.update');
    });

    Route::controller(IndustryController::class)->group(function () {
        Route::group(['prefix' => 'industries'], function () {
            Route::get('/', 'index')->name('industries.index');
            Route::get('/add', 'create')->name('industries.add');
            Route::post('/store', 'store')->name('industries.store');
            Route::get('{id}/edit', 'edit')->name('industries.edit');
            Route::post('{id}/update', 'update')->name('industries.update');
            Route::delete('{id}/delete', 'destroy')->name('industries.delete');
        });
    });
    Route::controller(QuestionController::class)->group(function () {
        Route::group(['prefix' => 'question'], function () {
            Route::get('/', 'index')->name('question.index');
            Route::get('/add', 'create')->name('question.add');
            Route::post('/store', 'store')->name('question.store');
            Route::get('{id}/edit', 'edit')->name('question.edit');
            Route::post('{id}/update', 'update')->name('question.update');
            Route::delete('{id}/delete', 'destroy')->name('question.delete');
        });
    });
    Route::controller(AnswerController::class)->group(function () {
        Route::group(['prefix' => 'answer'], function () {
            Route::get('/', 'index')->name('answer.index');
            Route::get('/add', 'create')->name('answer.add');
            Route::post('/store', 'store')->name('answer.store');
            Route::get('{id}/edit', 'edit')->name('answer.edit');
            Route::post('{id}/update', 'update')->name('answer.update');
            Route::delete('{id}/delete', 'destroy')->name('answer.delete');
        });
    });

    Route::controller(DecisionMakerController::class)->group(function () {
        Route::group(['prefix' => 'decision-makers'], function () {
            Route::get('/', 'index')->name('decision-makers.index');
            Route::get('/add', 'create')->name('decision-makers.add');
            Route::post('/store', 'store')->name('decision-makers.store');
            Route::get('{id}/edit', 'edit')->name('decision-makers.edit');
            Route::post('{id}/update', 'update')->name('decision-makers.update');
            Route::delete('{id}/delete', 'destroy')->name('decision-makers.delete');
        });
    });

    // Route::controller(ImageController::class)->group(function () {
    //   Route::group(['prefix' =>'admin']->group(function () {

    //   });
    // });
    Route::controller(CompanyController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('/', 'index')->name('company.index');
            Route::get('/add', 'create')->name('company.add');
            Route::post('/store', 'store')->name('company.store');
            Route::get('{id}/edit', 'edit')->name('company.edit');
            Route::post('{id}/update', 'update')->name('company.update');
            Route::delete('{id}/delete', 'destroy')->name('company.delete');
        });
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'events'], function () {
            Route::get('/', 'index')->name('events.index');
            Route::get('/add', 'create')->name('events.add');
            Route::post('/store', 'store')->name('events.store');
            Route::get('{id}/edit', 'edit')->name('events.edit');
            Route::post('{id}/update', 'update')->name('events.update');
            Route::delete('{id}/delete', 'destroy')->name('events.delete');
        });
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'holidays'], function () {
            Route::get('/', 'index')->name('holidays.index');
            Route::get('/add', 'create')->name('holidays.add');
            Route::post('/store', 'store')->name('holidays.store');
            Route::get('{id}/edit', 'edit')->name('holidays.edit');
            Route::post('{id}/update', 'update')->name('holidays.update');
            Route::delete('{id}/delete', 'destroy')->name('holidays.delete');
        });
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'meetings'], function () {
            Route::get('/', 'index')->name('meetings.index');
            Route::get('/add', 'create')->name('meetings.add');
            Route::post('/store', 'store')->name('meetings.store');
            Route::get('{id}/edit', 'edit')->name('meetings.edit');
            Route::post('{id}/update', 'update')->name('meetings.update');
            Route::delete('{id}/delete', 'destroy')->name('meetings.delete');
        });
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'plans'], function () {
            Route::get('/', 'index')->name('plans.index');
            Route::get('/add', 'create')->name('plans.add');
            Route::post('/store', 'store')->name('plans.store');
            Route::get('{id}/edit', 'edit')->name('plans.edit');
            Route::post('{id}/update', 'update')->name('plans.update');
            Route::delete('{id}/delete', 'destroy')->name('plans.delete');
        });
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'projects'], function () {
            Route::get('/', 'index')->name('projects.index');
            Route::get('/add', 'create')->name('projects.add');
            Route::post('/store', 'store')->name('projects.store');
            Route::get('{id}/edit', 'edit')->name('projects.edit');
            Route::post('{id}/update', 'update')->name('projects.update');
            Route::delete('{id}/delete', 'destroy')->name('projects.delete');
        });
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'promotions'], function () {
            Route::get('/', 'index')->name('promotions.index');
            Route::get('/add', 'create')->name('promotions.add');
            Route::post('/store', 'store')->name('promotions.store');
            Route::get('{id}/edit', 'edit')->name('promotions.edit');
            Route::post('{id}/update', 'update')->name('promotions.update');
            Route::delete('{id}/delete', 'destroy')->name('promotions.delete');
        });
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'index')->name('roles.index');
            Route::get('/add', 'create')->name('roles.add');
            Route::post('/store', 'store')->name('roles.store');
            Route::get('{id}/edit', 'edit')->name('roles.edit');
            Route::post('{id}/update', 'update')->name('roles.update');
            Route::delete('{id}/delete', 'destroy')->name('roles.delete');
        });
    });
});
