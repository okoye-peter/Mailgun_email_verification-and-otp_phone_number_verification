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

Route::post('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'UserController@usernameUpdate')->name('username.update');
Route::post('/phone', 'OtpController@sendOtp')->name('send.otp');
Route::post('/phone/verify', 'OtpController@verify')->name('verify.otp');