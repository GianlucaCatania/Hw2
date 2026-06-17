<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'checkLogin']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('register', [RegisterController::class, 'showRegisterForm']);
Route::post('register', [RegisterController::class, 'createUser']);
Route::get('check_username', [RegisterController::class, 'checkUsername']);
Route::get('check_email', [RegisterController::class, 'checkEmail']);

Route::get('home', [HomeController::class, 'showHomePage']);