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

Route::post('camp_registration', 'CampyWebController@camp_registration');
Route::post('gewinnspiel', 'CampyWebController@gewinnspiel');
Route::post('magazin', 'CampyWebController@magazin');
Route::post('kontakt', 'CampyWebController@kontakt');
Route::post('interest', 'CampyWebController@interest');
