<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ReferralTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('referral', [ReferralController::class, 'index'])->name('referral');
    Route::post('referral', [ReferralController::class, 'store'])->name('referral.store');
    Route::post('referral-delete', [ReferralController::class, 'destroy'])->name('referral.destroy');
    Route::post('referral-edit', [ReferralController::class, 'edit'])->name('referral.edit');
    Route::post('referral-update', [ReferralController::class, 'update'])->name('referral.update');

    Route::get('referral_type', [ReferralTypeController::class, 'index'])->name('referral_type');
    Route::post('referral_type', [ReferralTypeController::class, 'store'])->name('referral_type.store');
    Route::post('referral_type-delete', [ReferralTypeController::class, 'destroy'])->name('referral_type.destroy');
    Route::post('referral_type-edit', [ReferralTypeController::class, 'edit'])->name('referral_type.edit');
    Route::post('referral_type-update', [ReferralTypeController::class, 'update'])->name('referral_type.update');
});
