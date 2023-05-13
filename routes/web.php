<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\DecisionMakerController;
use App\Http\Controllers\ConversionRateController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Employee\OverViewController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SupplierController;

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

            EmployeeController = 67
            OverViewController = 84
            ImageController = 88
            AddressController = 93
            SecurityController = 102
            CompanyController = 110 
            AccountController =  126
            EmailController = 133 
            IndustryController = 140
            QuestionController = 150
            AnswerController  = 160
            DecisionMakerController = 170
            InvoiceController = 180
            ConversionRateController = 202 
            Plan = 

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
            Route::post('{id}/update', 'update')->name('employees.update');
            Route::get('{id}', 'overview')->name('employees.view');
            Route::get('{id}/address', 'address')->name('employees.address');
            Route::get('{id}/address/edit', 'addressEdit')->name('employees.address.edit');
            Route::get('{id}/overview/edit', 'overviewEdit')->name('employees.overview.edit');
            Route::get('{id}/settings', 'setting')->name('employees.settings');
            Route::get('{id}/attendance', 'attendance')->name('employees.attendance');
            Route::delete('{id}/delete', 'destroy')->name('employees.delete');
        });
    });
    Route::controller(OverViewController::class)->group(function () {
        Route::group(['prefix' => 'overview'], function () {
        });
    });
    Route::controller(ImageController::class)->group(function () {
        Route::get('images', 'show')->name('images');
        Route::post('/employee/image-upload', 'empImage')->name('employee.image-upload');
        Route::post('/industries/image-upload', 'indImage')->name('industries.image-upload');
    });
    Route::controller(AddressController::class)->group(function () {
        Route::group(['prefix' => 'address'], function () {
            Route::post('{type}', 'store')->name('address.store');
            Route::post('{type}/{id}', 'update')->name('address.update');
            Route::delete('{type}/{id}', 'destroy')->name('address.delete');
        });
        Route::get('invoices/{id}/company-address', 'companyAddress')->name('invoices.company-address');
        Route::get('invoices/{id}/client-address', 'clientAddress')->name('invoices.client-address');
    });
    Route::controller(SecurityController::class)->group(function () {
        Route::group(['prefix' => 'employees'], function () {
            Route::get('{id}/security', 'security')->name('employees.security');
            Route::post('{id}/email/update', 'emailUpdate')->name('employees.email.update');
            Route::post('{id}/change-password', 'changePassword')->name('employees.change-password');
            Route::post('{id}/deactivate', 'deactivate')->name('employees.deactivate');
        });
    });
    Route::controller(CompanyController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('/', 'show')->name('company.index');
            Route::get('add', 'create')->name('company.add');
            Route::post('store', 'store')->name('company.store');
            Route::get('{id}/edit', 'edit')->name('company.edit');
            Route::post('{id}/update', 'update')->name('company.update');
            Route::get('address', 'addresses')->name('company.address');
            Route::get('accounts', 'accounts')->name('company.accounts');
            Route::get('emails', 'emails')->name('company.emails');
            Route::get('invoices', 'invoices')->name('company.invoices');
            Route::get('projects', 'projects')->name('company.projects');
            Route::get('suppliers', 'suppliers')->name('company.suppliers');
            Route::delete('delete', 'destroy')->name('company.delete');
        });
    });
    Route::controller(AccountController::class)->group(function () {
        Route::group(['prefix' => 'account'], function () {
            Route::post('{type}/{id}', 'update')->name('account.update');
            Route::post('{type}', 'store')->name('account.store');
            Route::delete('{type}/{id}', 'destroy')->name('account.delete');
        });
    });
    Route::controller(EmailController::class)->group(function () {
        Route::group(['prefix' => 'email'], function () {
            Route::post('{type}/{id}', 'update')->name('email.update');
            Route::post('{type}', 'store')->name('email.store');
            Route::delete('{type}/{id}', 'destroy')->name('email.delete');
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
        // 
        Route::get('invoices/{id}/conversion-value', 'conversionValue')->name('invoices.conversion-value');
    });

    Route::resource('industries', IndustryController::class);
    Route::resource('decision-makers', DecisionMakerController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('answer', AnswerController::class);
    Route::resource('plan', PlanController::class);
    Route::resource('conversion-rate', ConversionRateController::class);
    Route::resource('supplier', SupplierController::class);

    Route::controller(SupplierController::class)->group(function () {
        Route::get('supplier/{id}/address', 'address')->name('supplier.address');
        Route::get('supplier/{id}/account', 'account')->name('supplier.account');
    });
});
