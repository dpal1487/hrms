    <?php

    use Inertia\Inertia;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Foundation\Application;
    use App\Http\Controllers\Web\AttributeController;
    use App\Http\Controllers\Web\AttributeValueController;
    use App\Http\Controllers\Web\Auth\LoginController;
    use App\Http\Controllers\Web\RuleController;
    use App\Http\Controllers\Web\BannerController;
    use App\Http\Controllers\Web\CategoryController;
    use App\Http\Controllers\Web\HomeController;
    use App\Http\Controllers\Web\ImageController;
    use App\Http\Controllers\Web\ItemController;
    use App\Http\Controllers\Web\UserController;
    use App\Http\Controllers\Web\ProfileController;
    use App\Http\Controllers\Web\ReviewController;
    use App\Http\Controllers\Web\PlanController;
    use App\Http\Controllers\Web\BrandController;
    use App\Http\Controllers\Web\BrandModelController;
    use App\Http\Controllers\Web\CouponController;
    use App\Http\Controllers\Web\FaqController;
    use App\Http\Controllers\Web\FaqsCategoryController;
    use App\Http\Controllers\Web\CustomerReviewController;
    use App\Http\Controllers\Web\PageController;
    use App\Http\Controllers\Web\EnquiryController;
    use App\Http\Controllers\Web\ReportTypeController;
    use App\Http\Controllers\Web\NotificationTypeController;
    use App\Http\Controllers\Web\ItemStatusController;
    use App\Http\Controllers\Web\MenuController;
    use App\Http\Controllers\Web\MenuItemController;
    use App\Http\Controllers\Web\TimeController;
    use App\Http\Controllers\Web\TimePeriodController;
    use App\Http\Controllers\Web\SubscriptionsController;;

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

    Route::post('login', [LoginController::class, 'login'])->name('user.login');

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        /* ========= Image Controller ========== */
        Route::controller(ImageController::class)->group(function () {
            Route::post('category/thumbnail', 'categoryThumbnail')->name('category.thumbnail');
            Route::post('category/banner', 'categoryBanner')->name('category.banner');
            Route::post('/upload/banner', 'bannerImage')->name('upload.banner');
            Route::post('/upload/brand', 'brandImage')->name('upload.brand');
            Route::post('/upload/faqs_category', 'uploadFAQsImage')->name('upload.faqs_category');
            Route::post('/upload/faq', 'uploadFaq');
        });
        /* ========= User Controller ========== */

        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users.index');
            Route::group(['prefix' => 'user'], function () {
                Route::get('/{id}', 'show')->name('user.show');
                Route::get('/{id}/address', 'address')->name('user.address');
                Route::post('/{id}/address/update', 'addressUpdate')->name('user.address.update');
                Route::get('/{id}/items', 'items')->name('user.items');
                Route::get('/{id}/createress', 'createress')->name('user.createress');
                Route::get('/{id}/packages', 'packages')->name('user.packages');
                Route::get('/{id}/reports', 'reports')->name('user.reports');
                Route::get('/{id}/reviews', 'reviews')->name('user.reviews');
            });
        });
        /* ========= Item Controller ========== */

        Route::controller(ItemController::class)->group(function () {
            Route::get('/items', 'index')->name('items.index');
            Route::group(['prefix' => 'item'], function () {
                Route::get('/', 'index')->name('item');
                Route::get('{id}', 'show')->name('item.show');
                Route::get('customers/{id}', 'customers')->name('item.customers');
                Route::get('reviews/{id}', 'reviews')->name('item.reviews');
                Route::post('status', 'statusUdate')->name('item.status');
                Route::get('customer/documents/{id}', [ItemController::class, 'documentDownload'])->name('customer.document');
            });
        });
        /* ========= Category Controller ========== */

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('categories.index');
            Route::group(['prefix' => 'category'], function () {
                Route::get('/create', 'create')->name('category.create');
                Route::post('/store', 'store')->name('category.store');
                Route::get('{id}', 'show')->name('category.show');
                Route::get('{id}/edit', 'edit')->name('category.edit');
                Route::post('{id}/update', 'update')->name('category.update');
                Route::post('status', 'statusUdate')->name('category.status');
                Route::delete('{id}/destroy', 'destroy')->name('category.destroy');
            });
        });
        /* ========= Banner Controller ========== */

        Route::controller(BannerController::class)->group(function () {
            Route::get('/banners', 'index')->name('banners.index');
            Route::group(['prefix' => 'banner'], function () {
                Route::get('/create', 'create')->name('banner.create');
                Route::post('/store', 'store')->name('banner.store');
                Route::get('{id}', 'show')->name('banner.show');
                Route::get('{id}/edit', 'edit')->name('banner.edit');
                Route::post('{id}/update', 'update')->name('banner.update');
                Route::post('status', 'statusUdate')->name('banner.status');
                Route::delete('{id}/destroy', 'destroy')->name('banner.destroy');
            });
        });
        /* ========= Attribute Controller ========== */

        Route::controller(AttributeController::class)->group(function () {
            Route::get('/attributes', 'index')->name('attributes.index');
            Route::group(['prefix' => 'attribute'], function () {
                Route::post('status', 'statusUdate')->name('attribute.status');
                Route::get('/create', 'create')->name('attribute.create');
                Route::post('/store', 'store')->name('attribute.store');
                Route::get('{id}', 'show')->name('attribute.show');
                Route::get('{id}/edit', 'edit')->name('attribute.edit');
                Route::post('{id}/update', 'update')->name('attribute.update');
                Route::delete('{id}/destroy', 'destroy')->name('attribute.destroy');
            });
        });

        /* ========= Attribute Value Controller ========== */

        Route::controller(AttributeValueController::class)->group(function () {
            Route::group(['prefix' => 'attribute-value'], function () {
                Route::get('/', 'index')->name('attribute-value.index');
                Route::post('status', 'statusUdate')->name('attribute-value.status');
                Route::get('/create', 'create')->name('attribute-value.create');
                Route::post('/store', 'store')->name('attribute-value.store');
                Route::get('{id}/edit', 'edit')->name('attribute-value.edit');
                Route::post('{id}/update', 'update')->name('attribute-value.update');
                Route::delete('{id}/destroy', 'destroy')->name('attribute-value.destroy');
            });
        });

        /* ========= Plan Controller ========== */

        Route::controller(PlanController::class)->group(function () {
            Route::get('/plans', 'index')->name('plans.index');
            Route::group(['prefix' => 'plan'], function () {
                Route::post('status', 'statusUdate')->name('plan.status');
                Route::get('/create', 'create')->name('plan.create');
                Route::post('/store', 'store')->name('plan.store');
                Route::get('{id}', 'show')->name('plan.show');
                Route::get('{id}/edit', 'edit')->name('plan.edit');
                Route::post('{id}/update', 'update')->name('plan.update');
                Route::delete('{id}/destroy', 'destroy')->name('plan.destroy');

                Route::get('{id}/users', 'users')->name('plan.users');
            });
        });

        /* ========= Brand Controller ========== */

        Route::controller(BrandController::class)->group(function () {
            Route::get('brands', 'index')->name('brands.index');
            Route::group(['prefix' => 'brand'], function () {
                Route::post('status', 'statusUdate')->name('brand.status');
                Route::get('/create', 'create')->name('brand.create');
                Route::post('/store', 'store')->name('brand.store');
                Route::get('{id}', 'show')->name('brand.show');
                Route::get('{id}/edit', 'edit')->name('brand.edit');
                Route::post('{id}/update', 'update')->name('brand.update');
                Route::delete('{id}/destroy', 'destroy')->name('brand.destroy');
            });
        });

        /* ========= Brand Model Controller ========== */

        Route::controller(BrandModelController::class)->group(function () {
            Route::group(['prefix' => 'brand-model'], function () {
                Route::post('status', 'statusUdate')->name('brand-model.status');
                Route::post('/store', 'store')->name('brand-model.store');
                Route::post('{id}/update', 'update')->name('brand-model.update');
                Route::delete('{id}/destroy', 'destroy')->name('brand-model.destroy');
            });
        });

        /* ========= Coupon Controller ========== */

        Route::controller(CouponController::class)->group(function () {
            Route::get('coupons', 'index')->name('coupons.index');
            Route::group(['prefix' => 'coupon'], function () {
                Route::get('/create', 'create')->name('coupon.create');
                Route::post('/store', 'store')->name('coupon.store');
                Route::get('{id}', 'show')->name('coupon.show');
                Route::get('{id}/edit', 'edit')->name('coupon.edit');
                Route::post('{id}/update', 'update')->name('coupon.update');
                Route::delete('{id}/destroy', 'destroy')->name('coupon.destroy');
            });
        });

        /* ========= Faq Category Controller ========== */

        Route::controller(FaqsCategoryController::class)->group(function () {
            Route::get('faqs-categories', 'index')->name('faqs-categories.index');
            Route::group(['prefix' => 'faqs-category'], function () {
                Route::post('status', 'statusUdate')->name('faqs-category.status');
                Route::get('/create', 'create')->name('faqs-category.create');
                Route::post('/store', 'store')->name('faqs-category.store');
                Route::get('{id}', 'show')->name('faqs-category.show');
                Route::get('{id}/edit', 'edit')->name('faqs-category.edit');
                Route::post('{id}/update', 'update')->name('faqs-category.update');
                Route::delete('{id}/destroy', 'destroy')->name('faqs-category.destroy');
            });
        });

        /* ========= FAQ Controller ========== */

        Route::controller(FaqController::class)->group(function () {
            Route::group(['prefix' => 'faqs'], function () {
                Route::get('/', 'index')->name('faqs.index');
                Route::get('create', 'create')->name('faqs.create');
                Route::post('store', 'store')->name('faqs.store');
                Route::get('{id}/edit', 'edit')->name('faqs.edit');
                Route::post('{id}/update', 'update')->name('faqs.update');
                Route::delete('{id}/destroy', 'destroy')->name('faqs.destroy');
            });
        });

        /* ========= Customer Review Controller ========== */

        Route::controller(CustomerReviewController::class)->group(function () {
            Route::get('customer-reviews', 'index')->name('customer-reviews.index');
            Route::group(['prefix' => 'customer-review'], function () {
                Route::post('status', 'statusUdate')->name('customer-review.status');
                Route::get('/create', 'create')->name('customer-review.create');
                Route::post('/store', 'store')->name('customer-review.store');
                Route::get('{id}/view', 'show')->name('customer-review.view');
                Route::get('{id}/edit', 'edit')->name('customer-review.edit');
                Route::post('{id}/update', 'update')->name('customer-review.update');
                Route::delete('{id}/destroy', 'destroy')->name('customer-review.destroy');
            });
        });

        /* ========= Page Controller ========== */

        Route::controller(PageController::class)->group(function () {
            Route::get('pages', 'index')->name('pages.index');
            Route::group(['prefix' => 'page'], function () {
                Route::post('status', 'statusUdate')->name('page.status');
                Route::get('/create', 'create')->name('page.create');
                Route::post('/store', 'store')->name('page.store');
                Route::get('{id}', 'show')->name('page.view');
                Route::get('{id}/edit', 'edit')->name('page.edit');
                Route::post('{id}/update', 'update')->name('page.update');
                Route::delete('{id}/destroy', 'destroy')->name('page.destroy');
            });
        });

        /* ========= Enquiry Controller ========== */

        Route::controller(EnquiryController::class)->group(function () {
            Route::get('enquires', 'index')->name('enquires.index');
            Route::group(['prefix' => 'enquire'], function () {
                Route::post('/status', 'statusUdate')->name('enquire.status');
            });
        });

        /* ========= Report Type Controller ========== */

        Route::controller(ReportTypeController::class)->group(function () {
            Route::get('report-types', 'index')->name('report-types.index');
            Route::group(['prefix' => 'report-type'], function () {
                Route::get('/create', 'create')->name('report-type.create');
                Route::post('/store', 'store')->name('report-type.store');
                Route::get('{id}/view', 'show')->name('report-type.view');
                Route::get('{id}/edit', 'edit')->name('report-type.edit');
                Route::post('{id}/update', 'update')->name('report-type.update');
                Route::delete('{id}/destroy', 'destroy')->name('report-type.destroy');
            });
        });

        /* ========= Notification Type Controller ========== */

        Route::controller(NotificationTypeController::class)->group(function () {
            Route::get('notification-types', 'index')->name('notification-types.index');
            Route::group(['prefix' => 'notification-type'], function () {
                Route::post('status', 'statusUdate')->name('notification-type.status');
                Route::get('/create', 'create')->name('notification-type.create');
                Route::post('/store', 'store')->name('notification-type.store');
                Route::get('{id}/view', 'show')->name('notification-type.view');
                Route::get('{id}/edit', 'edit')->name('notification-type.edit');
                Route::post('{id}/update', 'update')->name('notification-type.update');
                Route::delete('{id}/destroy', 'destroy')->name('notification-type.destroy');
            });
        });

        /* ========= Item Status Controller ========== */

        Route::controller(ItemStatusController::class)->group(function () {
            Route::group(['prefix' => 'item-status'], function () {
                Route::get('/', 'index')->name('item-status.index');
                Route::get('/create', 'create')->name('item-status.create');
                Route::post('/store', 'store')->name('item-status.store');
                Route::get('{id}/view', 'show')->name('item-status.view');
                Route::get('{id}/edit', 'edit')->name('item-status.edit');
                Route::post('{id}/update', 'update')->name('item-status.update');
                Route::delete('{id}/destroy', 'destroy')->name('item-status.destroy');
            });
        });

        /* ========= Time Controller ========== */

        Route::controller(TimeController::class)->group(function () {
            Route::get('times', 'index')->name('times.index');
            Route::group(['prefix' => 'time'], function () {
                Route::post('status', 'statusUdate')->name('time.status');
                Route::get('/create', 'create')->name('time.create');
                Route::post('/store', 'store')->name('time.store');
                Route::get('{id}/view', 'show')->name('time.view');
                Route::get('{id}/edit', 'edit')->name('time.edit');
                Route::post('{id}/update', 'update')->name('time.update');
                Route::delete('{id}/destroy', 'destroy')->name('time.destroy');
            });
        });

        /* ========= Time Period Controller ========== */

        Route::controller(TimePeriodController::class)->group(function () {
            Route::get('time-periods', 'index')->name('time-periods.index');
            Route::group(['prefix' => 'time-period'], function () {
                Route::get('{id}/create', 'create')->name('time-period.create');
                Route::post('/store', 'store')->name('time-period.store');
                Route::get('{id}', 'show')->name('time-period.show');
                Route::get('{id}/edit', 'edit')->name('time-period.edit');
                Route::any('{id}/update', 'update')->name('time-period.update');
                Route::delete('{id}/destroy', 'destroy')->name('time-period.destroy');
            });
        });

        /* ========= Subscriptions Controller ========== */


        Route::controller(SubscriptionsController::class)->group(function () {
            Route::get('subscriptions', 'index')->name('subscriptions.index');
            Route::group(['prefix' => 'subscription'], function () {
                Route::post('/status', 'status')->name('subscription.status');
            });
        });

        /* ========= Menu Controller ========== */

        Route::controller(MenuController::class)->group(function () {
            Route::get('/menus', 'index')->name('menu.index');
            Route::group(['prefix' => 'menu'], function () {
                Route::get('/create', 'create')->name('menu.create');
                Route::post('/store', 'store')->name('menu.store');
                Route::get('{id}/edit', 'edit')->name('menu.edit');
                Route::post('{id}/update', 'update')->name('menu.update');
                Route::delete('delete/{id}', 'destroy')->name('menu.destroy');
            });
        });

        /* ========= Menu Item Controller ========== */

        Route::controller(MenuItemController::class)->group(function () {
            Route::get('/menu-items', 'index')->name('menuItem.index');
            Route::group(['prefix' => 'menu-item'], function () {
                Route::get('/create', 'create')->name('menuItem.create');
                Route::post('/store', 'store')->name('menuItem.store');
                Route::get('{id}/edit', 'edit')->name('menuItem.edit');
                Route::post('{id}/update', 'update')->name('menuItem.update');
                Route::delete('delete/{id}', 'destroy')->name('menuItem.destroy');
            });
        });

        /* ========= Rule Controller ========== */

        Route::controller(RuleController::class)->group(function () {
            Route::group(['prefix' => 'rule'], function () {
                Route::get('/', 'index')->name('rule.index');
                Route::post('status', 'statusUdate')->name('rule.status');
                Route::get('/create', 'create')->name('rule.create');
                Route::post('/store', 'store')->name('rule.store');
                Route::get('{id}/edit', 'edit')->name('rule.edit');
                Route::post('{id}/update', 'update')->name('rule.update');
                Route::delete('{id}/destroy', 'destroy')->name('rule.destroy');
            });
        });

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
