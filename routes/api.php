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

Route::group(['prefix' => 'v1'], function() {

    Route::apiResource('emails', 'EmailController');
    Route::apiResource('users', 'UserController');

    Route::get('/search', 'EmailController@search')->name('email.search');
    Route::get('/recipients/{recipient}', 'EmailController@recipientEmails');
});
