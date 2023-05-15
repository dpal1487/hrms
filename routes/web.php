<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\DecisionMakerController;
use App\Http\Controllers\ConversionRateController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MyAccountController;

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
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', 'index')->name('employee.index');
            Route::get('/add', 'create')->name('employee.add');
            Route::post('/store', 'store')->name('employee.store');
            Route::get('{id}/edit', 'edit')->name('employee.edit');
            Route::post('{id}/update', 'update')->name('employee.update');
            Route::get('{id}', 'overview')->name('employee.view');
            Route::get('{id}/address', 'address')->name('employee.address');
            Route::get('{id}/address/edit', 'addressEdit')->name('employee.address.edit');
            Route::get('{id}/overview/edit', 'overviewEdit')->name('employee.overview.edit');
            Route::get('{id}/settings', 'setting')->name('employee.settings');
            Route::get('{id}/attendance', 'attendance')->name('employee.attendance');
            Route::delete('{id}/delete', 'destroy')->name('employee.delete');
        });
    });
    Route::controller(MyAccountController::class)->group(function () {
        Route::group(['prefix' => 'account'], function () {
            Route::get('/', 'overview')->name('account.overview');
            Route::get('/security', 'security')->name('account.security');
            Route::get('address', 'address')->name('account.address');
            Route::get('address/edit', 'addressEdit')->name('account.address.edit');
            Route::get('overview/edit', 'overviewEdit')->name('account.overview.edit');
            Route::get('settings', 'setting')->name('account.settings');
            Route::get('attendance', 'attendance')->name('account.attendance');
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
        Route::get('invoice/{id}/company-address', 'companyAddress')->name('invoice.company-address');
        Route::get('invoice/{id}/client-address', 'clientAddress')->name('invoice.client-address');
    });
    Route::controller(SecurityController::class)->group(function () {
        Route::group(['prefix' => 'employee'], function () {
            Route::get('{id}/security', 'security')->name('employee.security');
            Route::post('{id}/email/update', 'emailUpdate')->name('employee.email.update');
            Route::post('{id}/change-password', 'changePassword')->name('employee.change-password');
            Route::post('{id}/deactivate', 'deactivate')->name('employee.deactivate');
        });
        Route::group(['prefix' => 'account'], function () {
            Route::post('/email/update', 'emailUpdate')->name('account.email.update');
            Route::post('/change-password', 'changePassword')->name('account.change-password');
            Route::post('/deactivate', 'deactivate')->name('account.deactivate');
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
            Route::get('invoice', 'invoice')->name('company.invoice');
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
        Route::group(['prefix' => 'invoice'], function () {
            Route::get('/', 'index')->name('invoice.index');
            Route::get('/add', 'create')->name('invoice.add');
            Route::post('/store', 'store')->name('invoice.store');
            Route::get('{id}/edit', 'edit')->name('invoice.edit');
            Route::post('{id}/update', 'update')->name('invoice.update');
            Route::delete('{id}/delete', 'destroy')->name('invoice.delete');
        });
    });
    Route::controller(ConversionRateController::class)->group(function () {
        // 
        Route::get('invoice/{id}/conversion-value', 'conversionValue')->name('invoice.conversion-value');
    });

    Route::resource('industries', IndustryController::class);
    Route::resource('decision-makers', DecisionMakerController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('answer', AnswerController::class);
    Route::resource('plan', PlanController::class);
    Route::resource('conversion-rate', ConversionRateController::class);

    Route::resource('supplier', SupplierController::class);

    Route::controller(SupplierController::class)->group(function () {
        Route::get('supplier/{id}/overview/edit', 'supplierEdit')->name('supplier.overview.edit');
        Route::get('supplier/{id}/address', 'address')->name('supplier.address');
        Route::get('supplier/{id}/address/edit', 'addressEdit')->name('supplier.address.edit');
        Route::get('supplier/{id}/account', 'account')->name('supplier.account');
        Route::get('supplier/{id}/account/edit', 'accountEdit')->name('supplier.account.edit');
    });
});
