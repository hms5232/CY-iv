<?php

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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 取得 CSRF token
Route::get('/csrf', [App\Http\Controllers\HomeController::class, 'csrf']);

// 使用者註冊
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'createUser']);

// 登入
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// 登出
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

// FB 登入
Route::get('fb-login', [App\Http\Controllers\Auth\LoginController::class, 'fbLogin']);

// FB 登入 callback
Route::get('fb-login-callback', [App\Http\Controllers\Auth\LoginController::class, 'fbLoginCallback']);

// 確認使用者是否登入
Route::get('status', [App\Http\Controllers\Auth\LoginController::class, 'authCheck']);
