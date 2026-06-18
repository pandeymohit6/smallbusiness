<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BuyerController;
use App\Http\Controllers\Frontend\BuyerDashboardController;
use App\Http\Controllers\Frontend\SellerController;
use App\Http\Controllers\Frontend\SellerDashboardController;
use App\Http\Controllers\Frontend\BrokerController;
use App\Http\Controllers\Frontend\FranchiseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/

Route::get('/sell-your-business', [SellerController::class, 'index'])->name('sell.business');
Route::get('/seller-registration-select-login', [SellerController::class, 'registrationSelectLogin'])->name('seller.registration.select.login');
Route::get('/createadvert', [SellerController::class, 'createadvert'])->name('seller.createadvert');
Route::get('/seller-registration-details', [SellerController::class, 'registrationDetails'])->name('seller.registration.details');
Route::post('/business-seller/register', [SellerController::class, 'store'])->name('seller.registration.store');
Route::get('/seller-registration-confirmation', [SellerController::class, 'confirmation'])->name('seller.registration.confirmation');
Route::get('/seller/find-a-broker', [SellerController::class, 'getbroker'])->name('seller.broker');
Route::post('/find-broker', [SellerController::class, 'storebrokerRequest'])->name('broker.storebrokerRequest');
Route::get('/comingsoon', [HomeController::class, 'comingsoon'])->name('comingsoon');
Route::get('/email-alerts-info', [HomeController::class, 'emailAlertsInfo'])->name('emailalerts');
Route::get('/info/sellerbeware', [HomeController::class, 'sellerBeware'])->name('seller.beware');
Route::get('/info/buyerbeware', [HomeController::class, 'buyerBeware'])->name('buyer.beware');
Route::post('/seller/business/create', [SellerController::class, 'createBusiness'])->name('seller.business.create');
Route::post('/seller/business/{business}/step', [SellerController::class, 'saveStep'])->name('seller.business.step');
Route::post('/seller/upload-files', [SellerController::class, 'uploadFiles'])->name('seller.upload.document');
Route::post('/seller/delete-file', [SellerController::class, 'deleteFile'])->name('seller.delete.file');
/*

|--------------------------------------------------------------------------
| Buyer Routes
|--------------------------------------------------------------------------
*/

Route::get('/buyer-registration', [BuyerController::class, 'index'])->name('buyer.registration');
Route::get('/details', [BuyerController::class, 'details'])->name('buyer.registration.details');
Route::get('/select-login-type', [BuyerController::class, 'registrationSelectLogin'])->name('buyer.registration.select.login');
Route::get('/form', [BuyerController::class, 'form'])->name('buyer.registration.form');
Route::get('/confirmation/{buyerRegistration}', [BuyerController::class, 'confirmation'])->name('buyer.registration.confirmation');
Route::get('/buyer-registration-options', [BuyerController::class, 'getOptions'])->name('buyer.registration.options');
Route::post('/business-buyer/register', [BuyerController::class, 'store'])->name('buyer.registration.store');
Route::get('/search/buy-a-business', [BuyerController::class, 'buyABusiness'])->name('buy.business');
Route::get('/m-and-a-vault', [BuyerController::class, 'maVault'])->name('buyer.ma-vault');

/*
|--------------------------------------------------------------------------
| Broker Routes
|--------------------------------------------------------------------------
*/
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/advertise', [BrokerController::class, 'index'])->name('broker.advertise');
Route::get('/broker-registration-select-login-type', [BrokerController::class, 'registrationSelectLogin'])->name('broker.registration.type');
Route::get('/registration-details', [BrokerController::class, 'registrationDetails'])->name('broker.registration.details');

/*
|--------------------------------------------------------------------------
| Franchise Routes
|--------------------------------------------------------------------------
*/

Route::get('/search/resales-for-sale', [FranchiseController::class, 'index'])->name('franchise.index');
Route::get('/franchise', [FranchiseController::class, 'franchiseList'])->name('franchise.franchiseList');
Route::get('/franchises/franchisor/advertise', [FranchiseController::class, 'advertise'])->name('franchise.advertise');
Route::get('/valueright', [FranchiseController::class, 'valueright'])->name('valueright');
/*
|--------------------------------------------------------------------------
| Buyer Dashboard
|--------------------------------------------------------------------------
*/

Route::prefix('buyer')
    ->name('buyer.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/dashboard', [BuyerDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/sent-inquiries', [BuyerDashboardController::class, 'sentInquiries'])->name('sent-inquiries');
        Route::get('/saved-searches', [BuyerDashboardController::class, 'savedSearches'])->name('saved-searches');
        Route::get('/shortlist', [BuyerDashboardController::class, 'shortlist'])->name('shortlist');
        Route::get('/profile', [BuyerDashboardController::class, 'profile'])->name('profile');
        Route::get('/settings', [BuyerDashboardController::class, 'settings'])->name('settings');
    });

/*
|--------------------------------------------------------------------------
| Seller Dashboard
|--------------------------------------------------------------------------
*/

Route::prefix('seller')
    ->name('seller.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/resources', [SellerDashboardController::class, 'resources'])->name('resources');
        Route::get('/value-business', [SellerDashboardController::class, 'valueBusiness'])->name('value-business');
        Route::get('/profile', [SellerDashboardController::class, 'profile'])->name('profile');
        Route::get('/settings', [SellerDashboardController::class, 'settings'])->name('settings');
        Route::get('/business/{uuid}/edit', [SellerDashboardController::class, 'edit'])->name('business.edit');
        Route::get('/business/{uuid}', [SellerDashboardController::class, 'show'])->name('business.show');
    });

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Catch All Route (ALWAYS LAST)
|--------------------------------------------------------------------------
*/

Route::get('/{slug}', [HomeController::class, 'getPages'])->name('pages');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/country-redirect', [SellerController::class, 'countryRedirect'])->name('country.redirect');
Route::get('/login1', [SellerController::class, 'countryRedirect']);
