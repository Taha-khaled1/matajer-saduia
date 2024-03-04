<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommandController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PopularController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SettingPageController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\UserAddressController;
use Illuminate\Support\Facades\Route;


Route::get('schedule-run', [CommandController::class, 'scheduleCommand'])->name("schedule.run");
Route::group(['middleware' => 'ChangeLanguage'], function () {

    Route::post('/contact', [ContactUsController::class, 'store']);
    Route::get('/orders/create', [OrderController::class, 'saveOrder']);

    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });


    Route::controller(PopularController::class)->group(function () {
        Route::get('/popular', 'index');
        Route::get('/popular/view/{keyword}', 'keywordViews');
    });


    Route::post('verification-notification', [EmailVerificationController::class, 'sendEmailverfyc'])->name('verification-notification');
    Route::post('verify-email', [EmailVerificationController::class, 'verifyEmail'])->name('verify-email');
    Route::post('verify-code', [EmailVerificationController::class, 'verifyCode'])->name('verify-code');


    Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword']);
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->middleware('sanctum');



    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('sanctum');
        Route::post('/register', 'register');
        Route::get('/users/ads', 'getAds');
        Route::post('/social/register', 'socialRegister');
    });
    Route::get('getOtpForUser', [UserController::class, 'getOtpForUser']);


    Route::group(['middleware' => 'sanctum'], function () {
        Route::controller(NotificationController::class)->group(function () {

            // Route to get all notifications of the authenticated user.
            Route::get('/notifications', 'getUserNotifications');
            Route::get('/notifications/unread', 'getUnReadNotifications');
            // Route to mark a specific notification as read.
            Route::post('/notifications/{notification}/read', 'markAsRead');

            // Route to mark all notifications of the authenticated user as read.
            Route::post('/notifications/mark-all-read', 'markAllAsRead');
        });
        Route::post('payment-gateway', [PaymentController::class, 'paymentGateway']);
        Route::controller(OrderController::class)->group(function () {
            Route::get('/orders', 'userOrder');
            Route::get('/orders/detalis/{id}', 'orderDetalis');
            Route::get('/users/for/affalite', 'getUsersforAffalite');
            Route::post('/orders/cancel', 'cancelOrder');
            Route::post('/orders/reorder', 'Reorder');
        });
        Route::controller(UserController::class)->group(function () {
            Route::get('userInformation', 'getUserInfo');
            Route::post('updateUserInfo', 'updateUserInfo');
            Route::post('changePassword', 'changePassword');
        });


        Route::controller(UserAddressController::class)->group(function () {
            Route::get('/user-addresses', 'index');
            Route::get('/user-addresses/show', 'show');
            Route::post('/user-addresses/store', 'store');
            Route::put('/user-addresses/update', 'update');
            Route::delete('/user-addresses/destroy/{id}', 'destroy');
        });
    });

    Route::get('/categories', [CategoryController::class, 'getCatogery'])->name('categories');
    Route::get('categories/{categoryId}/subcategories', [SubCategoryController::class, 'getSubcategories']);


    Route::controller(ProductController::class)->group(function () {
        Route::get('/products',  'getProducts')->name('products.getProducts');
        Route::get('/products/allitems',  'getAllProducts')->name('products.allitems');
        Route::get('/products/hotitem',  'getAllProductsHotItem')->name('products.hotitem');
        Route::get('/subcategories/{subCatogeryId}/products', 'getProductsBysubCatogery')->name('products.getProductsBysubCatogery');
        Route::get('/product/{productId}', 'getProductById')->name('product.getProductById');
        Route::post('/search-product',  'searchProduct')->name('search-product');
        Route::get('/sorted-products', 'getSortedProducts');
        Route::get('/gift-products', 'getProductsGift');
        Route::post('updateviews/{id}', 'updateViews')->name('updateviews');
        Route::get('products/with-offers', 'getProductsByOffer');
    });

    Route::controller(SettingPageController::class)->group(function () {
        // terms Page
        Route::get('terms', 'termsPage');

        // About Page
        Route::get('about', 'aboutPage');

        // Privacy Page
        Route::get('privacy', 'privacyPage');

        // Return Policy Page
        Route::get('return-policy', 'returnPolicyPage');

        // Store Policy Page
        Route::get('store-policy', 'storePolicyPage');

        // Seller Policy Page
        Route::get('seller-policy', 'sellerPolicyPage');

        // Primary Color
        Route::get('primary-color', 'primeryColor');
        Route::post('sendOtp', 'sendOtp')->name('sendOtp');
    });



    Route::group(['middleware' => 'sanctum'], function () {
        Route::controller(CartItemController::class)->group(function () {
            Route::post('/cart/add', 'addToCart')->name('cart.addToCart');
            Route::delete('/cart/delete', 'deleteCartItemsByMerchant')->name('cart.delete');
            Route::post('/cart/reduce', 'reduceQuantity')->name('cart.reduce');
            Route::post('/cart/increase', 'increaseQuantity')->name('cart.Increase');
            Route::post('/cart/applycoupon', 'applyCoupon')->name('cart.applyCoupon');
            Route::delete('/cart/remove', 'removeFromCart')->name('cart.removeFromCart');
            Route::get('/cart/items', 'getCartItems')->name('cart.getCartItems');
            Route::delete('/cart/clear', 'clear');
            Route::get('/cart/checkout', 'checkOut');
        });
    });
    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('setting.index');
        Route::get('/settings/shop/{id}', 'shopDetalis')->name('setting.shop');
    });


    Route::get('/countries', CountryController::class)->name('countries');
    Route::get('/banners', BannerController::class)->name('banners');
});
