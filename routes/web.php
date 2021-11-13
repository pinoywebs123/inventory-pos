<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login_check',[AuthController::class,'login_check'])->name('login_check');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register_check',[AuthController::class,'register_check'])->name('register_check');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::group(['middleware'=> 'auth'], function(){

    Route::get('/users',[UserController::class,'users'])->name('users');
    Route::post('/users-get',[UserController::class,'users_get'])->name('users_get');
    Route::post('/users-update',[UserController::class,'users_update'])->name('users_update');
    Route::get('/summary',[UserController::class,'summary'])->name('summary');
    Route::get('/users-delete/{id}',[UserController::class,'users_delete'])->name('users_delete');
    Route::get('/inventory',[UserController::class,'inventory'])->name('inventory');
    Route::post('/inventory-check',[UserController::class,'inventory_check'])->name('inventory_check');
    Route::post('/inventory-update',[UserController::class,'inventory_update'])->name('inventory_update');
    Route::post('/inventory-get',[UserController::class,'inventory_get'])->name('inventory_get');
    Route::post('/order_check',[UserController::class,'order_check'])->name('order_check');
    Route::post('/inventory-stock-update',[UserController::class,'inventory_stock_update'])->name('inventory_stock_update');
    Route::get('/inventory-suspend/{id}',[UserController::class,'inventory_suspend'])->name('inventory_suspend');
    Route::get('/product',[UserController::class,'product'])->name('product');
    Route::get('/ordering',[UserController::class,'ordering'])->name('ordering');
    Route::get('/sales',[UserController::class,'sales'])->name('sales');

});