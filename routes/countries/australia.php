<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

/**
 * Frontend public routes.
 */
Route::domain('{country}.' . env('APP_BASE_DOMAIN'))->name('australia.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/sell-your-business', [HomeController::class, 'sellYourBusiness'])->name('sell.business');
    Route::get('/{code}/sell-your-business', [HomeController::class, 'sellYourBusinessForm'])->name('sell.business.country');
    Route::get('/seller-registration-select-login', [HomeController::class, 'sellerRegistrationSelectLogin'])->name('seller.registration.select.login');
    Route::get('/{slug}', [HomeController::class, 'getPages'])->name('pages');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
});
