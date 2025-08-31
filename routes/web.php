<?php

use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/services', [App\Http\Controllers\HomeController::class, 'services'])->name('services');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

//products
Route::get('products/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('product.single');
Route::post('products/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('add.cart');
Route::get('products/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart')->middleware('auth:web');
Route::get('products/cart-delete/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');


Route::post('products/prepare-checkout', [App\Http\Controllers\Products\ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');
Route::get('products/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->middleware('check.for.price')->name('checkout');

Route::post('products/checkout', [App\Http\Controllers\Products\ProductsController::class, 'storeCheckout'])->name('proccess.checkout')->middleware('check.for.price');

Route::post('products/booking' ,[App\Http\Controllers\Products\ProductsController::class ,'BookTables'])->name('booking.tables');


Route::get('products/menu', [App\Http\Controllers\Products\ProductsController::class, 'menu'])->name('products.menu');

http://localhost:8081/
Route::get('users/orders', [App\Http\Controllers\Users\UsersController::class, 'displayOrders'])->name('users.orders')->middleware('auth:web');
Route::get('users/bookings', [App\Http\Controllers\Users\UsersController::class, 'displayBookings'])->name('users.bookings')->middleware('auth:web');

// write reviews
Route::get('users/write-reviews', [App\Http\Controllers\Users\UsersController::class, 'writeReviews'])->name('write.reviews')->middleware('auth:web');
Route::post('users/write-reviews', [App\Http\Controllers\Users\UsersController::class, 'proccessWriteReviews'])->name('proccess.write.reviews')->middleware('auth:web');

Route::get( 'admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login')->middleware('check.for.auth');
Route::post( 'admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');

Route::get( 'admin/index', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard')->middleware('auth:admin');
Route::get( 'admin/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'DisplayAllAdmins'])->name('all.admins')->middleware('auth:admin');
Route::get( 'admin/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('create.admins')->middleware('auth:admin');
Route::post( 'admin/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('store.admins')->middleware('auth:admin');

Route::get( 'admin/all-orders', [App\Http\Controllers\Admins\AdminsController::class, 'DisplayAllOrders'])->name('all.orders')->middleware('auth:admin');
Route::get( 'edit/orders/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'editOrder'])->name('edit.order')->middleware('auth:admin');
Route::post( 'edit/orders/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'updateOrder'])->name('update.order')->middleware('auth:admin');

Route::get( 'delete/orders/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteOrder'])->name('delete.order')->middleware('auth:admin');


Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login');
})->name('logout');
//Route::get('users/write-reviews', [App\Http\Controllers\Users\UsersController::class, 'writeReviews'])->name('write.reviews')->middleware('auth:web');
