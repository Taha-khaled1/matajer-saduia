<?php


use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SizeController;
use App\Http\Controllers\Dashboard\SubCatogeryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return view('dashboard.home.index');
});
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubCatogeryController::class);
Route::resource('colors', ColorController::class);
Route::resource('sizes', SizeController::class);
Route::post('/categories/update-status', [CategoryController::class, 'updateStatusCatogery'])->name('categories.update-status');
Route::post('/subcategories/update-status', [SubCatogeryController::class, 'updateStatusCatogery'])->name('subcategories.update-status');

Route::controller(SettingController::class)->group(function ()
{
    Route::get('/setting', 'index')->name('setting');
    Route::post('/setting.store', 'store')->name('setting.store');
    Route::post('/setting.update', 'update')->name('setting.update');
    Route::post('/setting.destroy', 'destroy')->name('setting.destroy');
});