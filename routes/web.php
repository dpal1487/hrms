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
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;

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
            Route::delete('{id}', 'destroy')->name('employee.delete');
        });
        Route::post('employees/delete', 'selectDelete')->name('employees.delete');
    });



    Route::controller(MyAccountController::class)->group(function () {
        Route::group(['prefix' => 'account'], function () {
            Route::get('/', 'overview')->name('account.overview');
            Route::get('setting', 'setting')->name('account.setting');

            Route::get('/security', 'security')->name('account.security');
            Route::get('address', 'address')->name('account.address');
            Route::get('address/edit', 'addressEdit')->name('account.address.edit');
            Route::get('overview/edit', 'overviewEdit')->name('account.overview.edit');
            Route::get('attendance', 'attendance')->name('account.attendance');
        });
    });

    Route::controller(ImageController::class)->group(function () {
        Route::get('images', 'show')->name('images');
        Route::post('/employee/image-upload', 'empImage')->name('employee.image-upload');
        Route::post('/industry/image-upload', 'indImage')->name('industry.image-upload');
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
    Route::controller(SettingController::class)->group(function () {
        Route::prefix('account')->group(function () {
            Route::post('/', 'store')->name('account.user.store');
            Route::post('/avatar-upload', 'avatarImage');
            Route::post('/email/update', 'emailUpdate')->name('account.email.update');
            Route::post('/change-password', 'changePassword')->name('account.change-password');
            Route::post('/deactivate', 'deactivate')->name('account.deactivate');
        });
    });
    Route::controller(SecurityController::class)->group(function () {
        Route::group(['prefix' => 'employee'], function () {
            Route::get('{id}/security', 'security')->name('employee.security');
            Route::post('{id}/email/update', 'emailUpdate')->name('employee.email.update');
            Route::post('{id}/change-password', 'changePassword')->name('employee.change-password');
            Route::post('{id}/deactivate', 'deactivate')->name('employee.deactivate');
        });
    });
    Route::controller(ClientController::class)->group(
        function () {
            Route::get('clients', 'index')->name('client.index');
            Route::get('client/create', 'create')->name('client.create');
            Route::post('client/store', 'store')->name('client.store');
            Route::get('client/{id}', 'show')->name('client.show');
            Route::post('client/{id}/update', 'update')->name('client.update');
            Route::delete('client/{id}/destroy', 'destroy')->name('client.destroy');
            Route::get('client/{id}/projects', 'projects')->name('client.projects');
            // Client Address
            Route::get('client/{id}/address', 'address')->name('client.address');
            Route::post('client/{id}/address', 'updateAddress')->name('client.updateAddress');
            Route::post('client/{id}/address/create', 'addAddress')->name('client.addAddress');
            Route::delete('client/{id}/address', 'delAddress')->name('client.delAddress');

            // Client Contact
            Route::get('client/{id}/contact', 'contact')->name('client.contact');
            Route::post('client/{id}/contact', 'updateContact')->name('client.updateContact');
            Route::post('client/{id}/contact/create', 'addContact')->name('client.addContact');
            Route::delete('client/{id}/contact', 'delContact')->name('client.delContact');
        }
    );
    Route::controller(CompanyController::class)->group(function () {
        Route::group(['prefix' => 'company'], function () {
            Route::get('add', 'create')->name('company.add');
            Route::post('store', 'store')->name('company.store');
            Route::get('emails', 'emails')->name('company.emails');
            Route::get('invoice', 'invoice')->name('company.invoice');
            Route::get('projects', 'projects')->name('company.projects');
            Route::get('suppliers', 'suppliers')->name('company.suppliers');
            Route::delete('delete', 'destroy')->name('company.delete');

            //Company OverView
            Route::get('/', 'show')->name('company.index');
            Route::get('/overview/edit', 'overviewEdit')->name('company.overview.edit');
            Route::post('/update', 'update')->name('company.update');

            // Company Address
            Route::get('/address', 'addresses')->name('company.address');
            Route::post('/address', 'updateAddress')->name('company.updateAddress');
            Route::post('/address/create', 'addAddress')->name('company.addAddress');
            Route::delete('{id}/address', 'delAddress')->name('company.delAddress');

            // Company Account
            Route::get('accounts', 'accounts')->name('company.accounts');
            Route::post('/account', 'updateAccount')->name('company.updateAccount');
            Route::post('/account/create', 'addAccount')->name('company.addAccount');
            Route::delete('{id}/account', 'delAccount')->name('company.delAccount');

            // Company Email
            Route::get('emails', 'emails')->name('company.emails');
            Route::post('/email', 'updateEmail')->name('company.updateEmail');
            Route::post('/email/create', 'addEmail')->name('company.addEmail');
            Route::delete('{id}/email', 'delEmail')->name('company.delEmail');
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

    Route::resource('industry', IndustryController::class);
    Route::post('industry/status', [IndustryController::class, 'statusUpdate'])->name('industry.status');
    Route::post('industries/delete', [IndustryController::class, 'selectDelete'])->name('industries.delete');

    Route::resource('decision-maker', DecisionMakerController::class);
    Route::post('decision-makers/delete', [DecisionMakerController::class, 'selectDelete'])->name('decision-makers.delete');

    Route::resource('question', QuestionController::class);
    Route::post('questions/delete', [QuestionController::class, 'selectDelete'])->name('questions.delete');

    Route::resource('answer', AnswerController::class);
    Route::post('answers/delete', [AnswerController::class, 'selectDelete'])->name('answers.delete');

    Route::resource('plan', PlanController::class);
    Route::post('plans/status', [PlanController::class, 'statusUpdate'])->name('plans.status');

    Route::resource('conversion-rate', ConversionRateController::class);
    Route::post('conversion-rate/status', [ConversionRateController::class, 'statusUpdate'])->name('conversion-rate.status');
    Route::post('conversion-rates/delete', [ConversionRateController::class, 'selectDelete'])->name('conversion-rates.delete');

    Route::resource('department', DepartmentController::class);
    Route::post('department/status', [DepartmentController::class, 'statusUpdate'])->name('department.status');
    Route::post('departments/delete', [DepartmentController::class, 'selectDelete'])->name('departments.delete');


    Route::resource('supplier', SupplierController::class);
    Route::post('suppliers/delete', [SupplierController::class, 'selectDelete'])->name('suppliers.delete');


    Route::controller(SupplierController::class)->group(function () {
        Route::get('supplier/{id}/overview/edit', 'supplierEdit')->name('supplier.overview.edit');
        Route::get('supplier/{id}/address', 'address')->name('supplier.address');
        Route::get('supplier/{id}/address/edit', 'addressEdit')->name('supplier.address.edit');
        Route::get('supplier/{id}/account', 'account')->name('supplier.account');
        Route::get('supplier/{id}/account/edit', 'accountEdit')->name('supplier.account.edit');
    });

    Route::controller(RoleAndPermissionController::class)->group(function () {
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/user', 'index')->name('roles.user');
            Route::get('/user/view', 'roleView')->name('roles.user.view');
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'userList')->name('user.list');
        });
    });

    Route::resource('permission', PermissionController::class);
    Route::resource('roles', RoleController::class);
});
