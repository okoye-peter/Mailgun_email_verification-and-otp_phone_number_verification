<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/username', 'UserController@usernameUpdate')->name('username.update');
Route::post('/phone', 'OtpController@sendOtp')->name('send.otp');
Route::post('/phone/verify', 'OtpController@verify')->name('verify.otp');