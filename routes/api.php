<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {

    Route::apiResource('emails', 'EmailController');
    Route::apiResource('users', 'UserController');

    Route::get('/search', 'EmailController@search')->name('email.search');
    Route::get('/recipients/{recipient}', 'EmailController@recipientEmails');
});

Route::post('register', 'Auth\RegisterController@registration');

Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout');
