<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';
Route::get('/testcard', function () {
    return view("sucss-page");
});
Route::get('/', function () {
    return redirect()->route('admin.login');
});
Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
    Route::post('orders/{id}/stripe/paymeny-intent', [StripePaymentController::class, 'createStripePaymentIntent'])
        ->name('stripe.paymentIntent.create');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('go-payment', [PayPalController::class, 'goPayment'])->name('payment.go');
// Route::get('/payments/verify/{payment}', [FrontController::class, 'verifyWithTap'])->name('payment-verify');
// Route::post('/payments/verify/{payment}', [FrontController::class, 'payment_verify'])->name('payment-verify');
// Route::get('/payments/verify/{payment}', [FrontController::class, 'verifyWithTap'])->name('payment-verify');
// ==================================================
Route::get('/payments/payWithTap', [PayPalController::class, 'payWithTap'])->name('payment-payWithTap');
Route::get('/payments/payWithTapPayment', [PayPalController::class, 'payWithTapPayment'])->name('payment-payWithTapPayment');
Route::get('/payment/verify', [PayPalController::class, 'verifyWithTap'])->name('verify-payment');
// ==================================================
// Route::get('/payments/verify/{payment}', [FrontController::class, 'verifyWithTap'])->name('payment-verify');
// Route::post('/payments/verify/{payment}', [FrontController::class, 'payment_verify'])->name('payment-verify');
// Route::get('/payments/verify/{payment}', [FrontController::class, 'verifyWithTap'])->name('payment-verify');





Route::get('payment', [PayPalController::class, 'payment'])->name('payment');
Route::get('cancel', [PayPalController::class, 'cancel'])->name('payment.cancel');
Route::get('payment/success', [PayPalController::class, 'success'])->name('payment.success');
Route::get('/refund/{token}', [PayPalController::class, 'initiateRefund']);
Route::post('/send/notification', [NotificationController::class, 'sendNotificationToUser'])->name('send.notification');

Route::post('/send/notificationToAll', [NotificationController::class, 'sendNotificationToAll'])->name('send.notificationToAll');
