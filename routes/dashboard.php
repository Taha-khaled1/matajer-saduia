<?php

use App\Http\Controllers\Dashboard\AdvertisementController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\BranchCompanyController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PaymentGatewayController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShippingCompaniesController;
use App\Http\Controllers\Dashboard\SizeController;
use App\Http\Controllers\Dashboard\SubCatogeryController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingWebController;
use App\Http\Controllers\Dashboard\VendorController;
use App\Http\Controllers\Dashboard\WithdrawalController;
use App\Http\Controllers\Dashboard\WithdrawalMangmentController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/products/affiliateProduct', [ProductController::class, 'affiliateProduct'])->name('products.affiliateProduct');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('home')->with('success', 'successfully');
        } else if (Auth::User()->hasRole('vendor')) {
            return redirect()->route('vendorMain')->with('success', 'successfully');
        } else {
            return 'user';
        }
    })->middleware('vendorshop');

    Route::post('/branch_companies/update-status', [BranchCompanyController::class, 'updateStatusCatogery'])->name('branch_companies.update-status');

    Route::get('/orders-statistics', [DashboardController::class, 'getStatistics']);

    Route::get('/home', [DashboardController::class, 'main'])->name('home');
    Route::get('/vendor', [VendorController::class, 'vendorMain'])->name('vendorMain')->middleware('vendorshop');
    Route::resource('categories', CategoryController::class);
    Route::resource('advertisements', AdvertisementController::class);

    Route::resource('subcategories', SubCatogeryController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('roles', RoleController::class);
    Route::post('/categories/update-status', [CategoryController::class, 'updateStatusCatogery'])->name('categories.update-status');
    Route::post('/subcategories/update-status', [SubCatogeryController::class, 'updateStatusCatogery'])->name('subcategories.update-status');
    Route::post('/advertisements/update-status', [AdvertisementController::class, 'updateStatusCatogery'])->name('advertisements.update-status');
    Route::resource('branch_companies', BranchCompanyController::class);
    Route::controller(ContactUsController::class)->group(function () {
        Route::get('/contactus', 'index')->name('contactus');

        Route::delete('/contactus/destroy', 'destroy')->name('contactus.destroy');
    });
    Route::controller(WithdrawalController::class)->group(function () {
        Route::get('/withdrawals', 'index')->name('withdrawals');
        Route::post('/withdrawals/store', 'store')->name('withdrawals.store');
        Route::post('/withdrawals/destroy', 'destroy')->name('withdrawals.destroy');
    });

    Route::controller(WithdrawalMangmentController::class)->group(function () {
        Route::get('/withdrawals/mangment', 'index')->name('withdrawals.mangment');
        Route::post('/withdrawals/mangment/changeType', 'changeType')->name('withdrawals.changeType');
        Route::post('/withdrawals/closeWithdrawal', 'closeWithdrawal')->name('withdrawals.closeWithdrawal');
    });

    Route::controller(ShippingCompaniesController::class)->group(function () {
        Route::get('/shipping_companies', 'index')->name('shipping_companies');
        Route::get('/shipping_companies/create', 'create')->name('shipping_companies.create');
        Route::post('/shipping_companies/store', 'store')->name('shipping_companies.store');
        Route::post('/shipping_companies/update', 'update')->name('shipping_companies.update');
        Route::post('/shipping_companies/destroy', 'destroy')->name('shipping_companies.destroy');
    });
    Route::controller(CouponController::class)->group(function () {
        Route::get('/coupons', 'index')->name('coupons');
        Route::get('/coupons/create', 'create')->name('coupons.create');
        Route::post('/coupons/store', 'store')->name('coupons.store');
        Route::post('/coupons/update', 'update')->name('coupons.update');
        Route::post('/coupons/destroy', 'destroy')->name('coupons.destroy');
    });
    Route::controller(SettingController::class)->group(function () {
        Route::get('/setting', 'index')->name('setting')->middleware('vendorshop');;
        Route::post('/setting.store', 'store')->name('setting.store');
        Route::post('/setting.update', 'update')->name('setting.update');
        Route::post('/setting.destroy', 'destroy')->name('setting.destroy');
    });
    Route::controller(BannerController::class)->group(function () {
        Route::get('/banners', 'index')->name('banners');
        // Route::get('/coupons/create', 'create')->name('coupons.create');
        Route::post('/banners/store', 'store')->name('banners.store');
        Route::put('/banners/update', 'update')->name('banners.update');
        Route::delete('/banners/destroy', 'destroy')->name('banners.destroy');
        Route::post('/banners/update-status', 'updateStatusBanner')->name('banners.update-status');
    });
    Route::controller(OrderController::class)->group(function () {

        Route::get('/orders', 'index')->name('orders');
        Route::get('/orders/spacial', 'spacialOrderIndex')->name('orders.spacial');
        Route::get('/orders/pendingOrders', 'pendingOrders')->name('orders.pendingOrders');
        Route::get('/orders/processingOrders', 'processingOrders')->name('orders.processingOrders');
        Route::get('/orders/deliveringOrders', 'deliveringOrders')->name('orders.deliveringOrders');
        Route::get('/orders/completedOrders', 'completedOrders')->name('orders.completedOrders');
        Route::get('/orders/invoice/{id}', 'printInvoice')->name('orders.invoice');
        Route::delete('/orders/destroy', 'destroy')->name('orders.destroy');
        Route::get('/orders/uploadMotalpa', 'uploadMotalpa')->name('orders.uploadMotalpa');

        Route::post('/orders/changePaymentStatus', 'changePaymentStatus')->name('orders.changePaymentStatus');
        Route::post('/orders/changeOrderStatus', 'changeOrderStatus')->name('orders.changeOrderStatus');
        Route::post('/orders/changeDeliveryTime', 'changeDeliveryTime')->name('orders.changeDeliveryTime');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products')->middleware('vendorshop');
        Route::get('/products/inactive', 'productsInactive')->name('products.inactive');
        Route::get('/products/create', 'create')->name('products.create')->middleware('vendorshop');
        Route::get('/getSubsections', 'getSubsections')->name('getSubsections');
        Route::post('/products/update-status', 'updateStatusProduct')->name('products.update-status');
        Route::post('/products/store', 'store')->name('products.store')->middleware('vendorshop');
        Route::post('/products/update', 'update')->name('products.update')->middleware('vendorshop');
        Route::delete('/products/destroy', 'destroy')->name('products.destroy');
        Route::get('/products/edit/{id}', 'edit')->name('products.edit')->middleware('vendorshop');
        Route::get('/products/editFork/{id}', 'editFork')->name('products.editFork')->middleware('vendorshop');
        Route::get('/products/special', 'productSpacial')->name('products.special')->middleware('vendorshop');
        Route::post('/products/destroy/attr', 'destroyAttr')->name('products.destroyAttr');
        Route::delete('/delete-image/{id}', 'deleteImage')->name("delete.image");
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user');
        Route::post('/user.store', 'store')->name('user.store');
        Route::post('/user.edit', 'edit')->name('user.edit');
        Route::post('/user.update', 'update')->name('user.update');
        Route::post('/user.destroy', 'destroy')->name('user.destroy');
        Route::post('/userCreate', 'create')->name('userCreate');
        Route::post('/user/disable/cash_on_delivery', 'disableCashOnDelivery')->name('user.cash_on_delivery');
        Route::get('/userUpdate/{id}', 'userUpdate')->name('userUpdate');
        Route::get('/user/vendeors', 'vendeors')->name('user.vendeors');
        Route::get('/user/SubscrebtionVendeors', 'SubscrebtionVendeors')->name('user.SubscrebtionVendeors');
        Route::get('/user/affiliate', 'affiliateMarketer')->name('user.affiliate');
        Route::post('/user/chargeWallet', 'chargeWallet')->name('user.chargeWallet');
        Route::post('/user/userAffaliteUpadeType', 'userAffaliteUpadeType')->name('user.userAffaliteUpadeType');
    });
    Route::controller(CountryController::class)->group(function () {
        // Route::get('/catogery', 'index')->name('catogery');
        Route::get('/countries', 'index')->name('countries');
        Route::post('/countries/store', 'store')->name('countries.store');
        Route::post('/countries/update', 'update')->name('countries.update');
        Route::post('/countries/destroy', 'destroy')->name('countries.destroy');
    });
    Route::controller(SettingWebController::class)->group(function () {
        Route::get('/setting_web', 'index')->name('setting_web');
        Route::get('/setting/gift', 'gift')->name('setting.gift');
        Route::get('/colorweb', 'colorweb')->name('colorweb');
        Route::post('/settings/update', 'update')->name('settings.update');
        Route::post('/settings/updateGift', 'updateGift')->name('settings.updateGift');
        Route::post('/settings/store', 'store')->name('settings.store');
        Route::post('updatewebsite', 'updatewebsite')->name('admin.updatewebsite');
    });


    Route::get('/notification/markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('notification.markAllAsRead');


    Route::controller(PaymentGatewayController::class)->group(function () {
        Route::get('/gateways', 'index')->name('gateways');
        Route::post('/gateways/update', 'update')->name('gateways.update');
    });
});
