<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\feController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\OrderController;



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
Route::controller(feController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/detail/{id}', 'detail')->name('detail');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/login', 'showlogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/showRegister', 'showRegister')->name('showRegister');
    Route::middleware(['auth:customer'])->group(function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/editprofile', 'editprofile')->name('editprofile');
        Route::get('/about', 'about')->name('about');
        Route::get('/orderHistory', 'orderHistory')->name('orderHistory');
        Route::post('/orderhistory/{id}/complete', [feController::class, 'completeOrder'])->name('order.complete');
        Route::post('/updateProfile', 'updateProfile')->name('updateProfile');
        Route::get('/cart', 'cart')->name('cart');
        Route::post('/cart/add', 'addcart')->name('addcart');
        Route::delete('/cart/remove/{id}', 'removecart')->name('removecart');
        Route::get('/checkout', 'checkout')->name('checkout');
        Route::post('/checkout', 'checkout');
        Route::delete('/delete_cart', 'delete_cart')->name('delete_cart');
        Route::post('/payment/process', 'paymentProcess')->name('payment.process');
        Route::post('/payment/callback', 'callback')->name('payment.callback');
        Route::get('/payment/callback', 'callback')->name('payment.callback');
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/kategori', [feController::class, 'categories'])->name('categories');
        Route::get('/category/{id}', [feController::class, 'category'])->name('category');
    });
});

Route::post('/send-whatsapp', [WhatsAppController::class, 'sendWhatsAppMessage'])->name('send-whatsapp');

Route::post('/register', [RegisterController::class, 'register'])->name('register');


Route::post('/orderhistory/complete/{id}', [OrderController::class, 'complete'])->name('order.complete');
Route::delete('/orderhistory/reject/{id}', [OrderController::class, 'reject'])->name('order.reject');
Route::get('/invoice/{orderId}', [InvoiceController::class, 'show'])->name('invoice.show');



Auth::routes([
    'login'    => false,
    'logout'   => false,
    'register' => false,
    'reset'    => false,
    'confirm'  => false,
    'verify'   => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
