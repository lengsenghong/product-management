<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;


Route::resource('products', ProductController::class)->middleware('auth');
Auth::routes();
Route::get('/', [ProductController::class, 'index'])->name('home');
