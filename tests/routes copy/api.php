<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\CartItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('verification-notification', [EmailVerificationController::class, 'sendEmailverfyc'])->name('verification-notification');
Route::post('verify-email', [EmailVerificationController::class, 'verifyEmail'])->name('verify-email');


Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);



Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('sanctum');
    Route::post('/register', 'register');
});
  Route::get('getOtpForUser', [UserController::class, 'getOtpForUser']);
Route::group(['middleware' => 'sanctum'], function () {
    Route::get('userInformation', [UserController::class, 'getUserInfo']);
    Route::post('updateUserInfo', [UserController::class, 'updateUserInfo']);
    Route::post('changePassword', [UserController::class, 'changePassword']);
  
    
});
Route::group(['middleware' => 'ChangeLanguage'], function () {
    Route::get('/categories', [CategoryController::class, 'getCatogery'])->name('categories')->middleware('ChangeLanguage');
    Route::get('categories/{categoryId}/subcategories', [SubCategoryController::class, 'getSubcategories'])->middleware('ChangeLanguage');
    Route::get('/products', [ProductController::class, 'getProducts'])->name('products.getProducts');
    Route::get('/subcategories/{subCatogeryId}/products', [ProductController::class, 'getProductsBysubCatogery'])->name('products.getProductsBysubCatogery');
    Route::get('/product/{productId}', [ProductController::class, 'getProductById'])->name('product.getProductById');
    Route::post('/search-product', [ProductController::class, 'searchProduct'])->name('search-product');
});


Route::group(['middleware' => 'sanctum'], function () {
Route::post('/cart/add', [CartItemController::class, 'addToCart'])->name('cart.addToCart');
    Route::delete('/cart/remove', [CartItemController::class, 'removeFromCart'])->name('cart.removeFromCart');
    Route::get('/cart/items', [CartItemController::class, 'getCartItems'])->name('cart.getCartItems');
    
});


Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');