<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MyPageController;


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

// メール認証機能
Route::get('/email/verify', function(){
    return view('auth.verify_email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back();
})->middleware(['auth', 'throttle:6.1'])->name('verification.send');

Route::get('/', [ProductController::class, 'index'])->name('product');
Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('detail');

Route::middleware(['auth', 'verified'])->group(function()
{
    Route::get('/home', function(){
        return redirect('/setting_profile');
    });

    Route::get('/setting_profile', [AuthController::class, 'showSettingProfile']);
    Route::patch('/update', [AuthController::class, 'update'])->name('update');

    Route::post('/item/{item_id}/comment', [CommentController::class, 'store']);

    Route::post('/item/{item_id}/like', [LikeController::class, 'toggle']);

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase');

    // Stripe決済処理
    Route::post('/purchase/{item_id}/checkout', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('purchase.success');

    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editShippingAddress'])->name('shipping');
    Route::post('/purchase/change_address/{item_id}', [PurchaseController::class, 'confirm']);


    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
    Route::get('/mypage/profile', [MyPageController::class, 'showEditProfile'])->name('edit.mypage');
    Route::patch('/mypage/update', [MyPageController::class, 'update'])->name('update.mypage');

    Route::get('/sell', [ProductController::class, 'showSell'])->name('sell');
    Route::post('/sell/submit', [ProductController::class, 'store'])->name('sell.submit');
});
