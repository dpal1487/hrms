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
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountController;

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

    // Route::post('/upload', [ImageController::class, 'uploadImage'])->name('upload');

    Route::controller(ImageController::class)->group(function () {
        Route::get('images', 'show')->name('images');
        Route::post('/employee/image-upload', 'empImage')->name('employee.image-upload');
        Route::post('/industries/image-upload', 'indImage')->name('industries.image-upload');
    });

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
        Route::post('{id}/address/update', [AddressController::class, 'empaddress'])->name('employees.address.update');
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
            Route::get('{id}', 'show')->name('company.view');
            Route::get('{id}/overview', 'show')->name('company.overview');

            // Route::get('{id}/account', 'accountShow')->name('company.account');
            Route::get('{id}/emails', 'emialsShow')->name('company.emails');
            Route::get('{id}/invoices', 'invoicesShow')->name('company.invoices');
            Route::get('{id}/projects', 'projectsShow')->name('company.projects');
            Route::get('{id}/suppliers', 'suppliersShow')->name('company.suppliers');

            Route::delete('{id}/delete', 'destroy')->name('company.delete');
        });
    });

    Route::controller(AddressController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('{id}/address', 'addressShow')->name('company.address');
            Route::post('/address/store', 'store')->name('company.address.store');
            Route::delete('{id}/address/delete', 'destroy')->name('company.address.delete');
        });
        Route::get('invoices/{id}/company-address', 'companyAddress')->name('invoices.company-address');
        Route::get('invoices/{id}/client-address', 'clientAddress')->name('invoices.client-address');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('{id}/account', 'index')->name('company.account');
            Route::post('/account/store', 'store')->name('company.account.store');
            Route::delete('{id}/account/delete', 'destroy')->name('company.account.delete');
        });
    });

    Route::controller(InvoiceController::class)->group(function () {
        Route::group(['prefix' => 'invoices'], function () {
            Route::get('/', 'index')->name('invoices.index');
            Route::get('/add', 'create')->name('invoices.add');
            Route::post('/store', 'store')->name('invoices.store');
            Route::get('{id}/edit', 'edit')->name('invoices.edit');
            Route::post('{id}/update', 'update')->name('invoices.update');
            Route::delete('{id}/delete', 'destroy')->name('invoices.delete');
        });
    });
});
