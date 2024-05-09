<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// All
Route::get('/', [Controller::class, 'viewHome'])->name('home');
Route::get('/home', [Controller::class, 'viewHome']);
Route::get('/aboutUs', [Controller::class, 'viewAboutUs']);

Route::get('/contact', [Controller::class, 'viewContact']);
Route::post('/post_message', [Controller::class, 'post_message']);

Route::get('/register', [Controller::class, 'viewRegister'])->name('register');
Route::post('/register', [Controller::class, 'runRegister']);
Route::get('/login', [Controller::class, 'viewLogin'])->name('login');
Route::post('/login', [Controller::class, 'runLogin']);
Route::get('/forgetPassword', [Controller::class, 'forgetPassword'])->name('forgetPassword');
Route::post('/forgetPassword', [Controller::class, 'runForgetPassword']);

Route::get('/resetPassword/{token}', [Controller::class, 'resetPassword'])->name('resetPassword');
Route::post('/resetPassword', [Controller::class, 'runResetPassword']);

Route::get('/editProfile', [Controller::class, 'viewEdit'])->name('viewEdit');
Route::put('/editProfile', [Controller::class, 'runEditProfile'])->name('runEditProfile');
Route::get('/changePassword', [Controller::class, 'viewChange'])->name('viewChange');
Route::post('/changePassword', [Controller::class, 'runChangePassword'])->name('runChangePassword');
Route::get('/logout', [Controller::class, 'runLogout'])->name('logout');

// Product
Route::get('/showProduct', [ProductController::class, 'viewProducts'])->name('viewProducts');
Route::get('/products/{product:id}', [ProductController::class, 'viewProductDetail'])->name('productDetail');
Route::get('/showProduct/{category}', [ProductController::class, 'filterProduct'])->name('filterProduct');
Route::get('/showProduct/{category}/{order}', [ProductController::class, 'orderProducts'])->name('orderProducts');

// Admin
Route::get('/viewItem', [AdminController::class, 'viewManageItem'])->middleware('authenticaterole:admin')->name('viewItem');
Route::get('/addItem', [AdminController::class, 'viewAddItem'])->name('addItem')->middleware('authenticaterole:admin');
Route::post('/addItem', [AdminController::class, 'runAddItem']);
Route::get('/updateItem/{product:id}', [AdminController::class, 'viewUpdateItem'])->name('updateItem')->middleware('authenticaterole:admin');
Route::put('/updateItem/{product:id}', [AdminController::class, 'runUpdateItem']);
Route::delete('/deleteItem/{product:id}', [AdminController::class, 'deleteItem']);

// User
Route::get('/cartList', [UserController::class, 'viewCart'])->name('cartList');
Route::post('/addcart', [UserController::class, 'runAddCart']);
Route::get('/updateCartqty/{product:id}', [UserController::class, 'viewUpdateCart']);
Route::put('/updateCartItem', [UserController::class, 'runUpdateCartqty']);
Route::post('/deleteCartItem', [UserController::class, 'runDeleteCartItem']);

Route::get('/transactionHistory', [UserController::class, 'viewTransaction'])->middleware('authenticaterole:customer')->name('transactionHistory');
Route::post('/checkout', [UserController::class, 'runCheckout']);
