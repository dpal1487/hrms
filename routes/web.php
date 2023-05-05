<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Company\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Company\CompanyEmailController;
use App\Http\Controllers\DecisionMakerController;
use App\Http\Controllers\ConversionRateController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Employee\EmployeeSecurityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

| Routes 

            ImageController = 52
            EmployeeController = 60
            EmployeeSecurityController = 77
            AddressController = 84
            IndustryController = 101
            QuestionController = 113
            AnswerController  = 131
            DecisionMakerController = 142
            CompanyController = 153 
            AccountController =  171
            CompanyEmailController = 178 
            InvoiceController = 186
            ConversionRateController = 197 

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


    Route::controller(EmployeeController::class)->group(function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('/', 'index')->name('employees.index');
            Route::get('/add', 'create')->name('employees.add');
            Route::post('/store', 'store')->name('employees.store');
            Route::get('{id}/edit', 'edit')->name('employees.edit');
            Route::get('{id}', 'overview')->name('employees.view');
            Route::get('{id}/overview', 'overview')->name('employees.overview');
            Route::post('{id}/update', 'update')->name('employees.update');
            Route::get('{id}/overview/edit', 'overviewEdit')->name('employees.overview.edit');
            Route::get('{id}/settings', 'setting')->name('employees.settings');
            Route::get('{id}/attendance', 'attendance')->name('employees.attendance');
            Route::delete('{id}/delete', 'destroy')->name('employees.delete');
        });
    });
    Route::controller(ImageController::class)->group(function () {
        Route::get('images', 'show')->name('images');
        Route::post('/employee/image-upload', 'empImage')->name('employee.image-upload');
        Route::post('/industries/image-upload', 'indImage')->name('industries.image-upload');
    });
    Route::controller(EmployeeSecurityController::class)->group(function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('{id}/security', 'security')->name('employees.security');
            Route::post('{id}/email/update', 'emailUpdate')->name('employees.email.update');
            Route::post('{id}/change-password', 'changePassword')->name('employees.change-password');
            Route::post('{id}/deactivate', 'deactivate')->name('employees.deactivate');
        });
    });
    Route::controller(AddressController::class)->group(function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('{id}/address', 'empAddress')->name('employees.address');
            Route::get('{id}/address/edit', 'empAddressEdit')->name('employees.address.edit');
            // Route::post('{id}/address/update', 'empAddressUpdate')->name('employees.address.update');
            Route::put('/address/{type}/{id}', 'empAddressUpdate')->name('address.update');

            Route::delete('{id}/address/delete', 'destroy')->name('employees.address.delete');
        });
        Route::group(['prefix' => 'company'], function () {
            Route::get('{id}/address', 'getcompanyAddress')->name('company.address');
            Route::post('/address/store', 'savecompanyAddress')->name('company.address.store');
            Route::delete('{id}/address/delete', 'destroy')->name('company.address.delete');
        });
        Route::get('invoices/{id}/company-address', 'companyAddress')->name('invoices.company-address');
        Route::get('invoices/{id}/client-address', 'clientAddress')->name('invoices.client-address');
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

    Route::controller(CompanyController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('/', 'index')->name('company.index');
            Route::get('/add', 'create')->name('company.add');
            Route::post('/store', 'store')->name('company.store');
            Route::get('{id}/edit', 'edit')->name('company.edit');
            Route::post('{id}/update', 'update')->name('company.update');
            Route::get('{id}', 'show')->name('company.view');
            Route::get('{id}/overview', 'show')->name('company.overview');

            Route::get('{id}/invoices', 'invoicesShow')->name('company.invoices');
            Route::get('{id}/projects', 'projectsShow')->name('company.projects');
            Route::get('{id}/suppliers', 'suppliersShow')->name('company.suppliers');

            Route::delete('{id}/delete', 'destroy')->name('company.delete');
        });
    });

    Route::controller(AccountController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('{id}/accounts', 'index')->name('company.accounts');
            Route::put('/account/{type}/{id}', 'update')->name('account.update');
            Route::post('/account/{type}/store', 'store')->name('account.store');
            Route::delete('{id}/account/delete', 'destroy')->name('account.delete');
        });
    });
    Route::controller(CompanyEmailController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('{id}/emails', 'index')->name('company.emails');
            Route::post('/email/store', 'store')->name('company.email.store');
            Route::delete('{id}/email/delete', 'destroy')->name('company.email.delete');
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

    Route::controller(ConversionRateController::class)->group(function () {
        Route::group(['prefix' => 'conversion-rate'], function () {
            Route::get('/', 'index')->name('conversion-rate.index');
            Route::get('/add', 'create')->name('conversion-rate.add');
            Route::post('/store', 'store')->name('conversion-rate.store');
            Route::get('{id}/edit', 'edit')->name('conversion-rate.edit');
            Route::post('{id}/update', 'update')->name('conversion-rate.update');
            Route::delete('{id}/delete', 'destroy')->name('conversion-rate.delete');
        });
        Route::get('invoices/{id}/conversion-value', 'conversionValue')->name('invoices.conversion-value');
    });
});
