<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'showHomePage']);

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'checkLogin']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('register', [RegisterController::class, 'showRegisterForm']);
Route::post('register', [RegisterController::class, 'createUser']);
Route::get('check_username_register', [RegisterController::class, 'checkUsername']);
Route::get('check_email_register', [RegisterController::class, 'checkEmail']);
Route::get('check_username_profile', [ProfileController::class, 'checkUsername']);
Route::get('check_email_profile', [ProfileController::class, 'checkEmail']);

Route::get('home', [HomeController::class, 'showHomePage']);
Route::get('api/products', [HomeController::class, 'getProducts']);
Route::get('api/macro', [HomeController::class, 'getMacro']);

Route::get('profile', [ProfileController::class, 'showProfile']); 
Route::post('profile', [ProfileController::class, 'updateProfile']); 

Route::get('cart', [CartController::class, 'showCart']);
Route::get('api/cart/load', [CartController::class, 'loadCart']);
Route::post('api/cart/add', [CartController::class, 'addCart']);
Route::post('api/cart/remove', [CartController::class, 'removeCart']);
Route::post('api/cart/delete', [CartController::class, 'deleteCart']);
Route::get('api/cart/order', [CartController::class, 'orderCart']);
Route::post('api/cart/pay', [CartController::class, 'payCart']);