<?php

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

// Add routes for authentication
Auth::routes();

// Welcome Page with a List of registerable Camps
Route::get('/', 'WelcomeController@index')->name('index');

// Legal Links
Route::view('/teilnahmebedingungen', 'legal.terms')->name('terms');
Route::view('/datenschutz', 'legal.privacy')->name('privacy');
Route::view('/impressum', 'legal.imprint')->name('imprint');

// Profile for authenticated users
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile', 'ProfileController@update');

// List of registerable Camps
Route::get('/camps', 'CampController@index')->name('camps');

// List of registered Camps
Route::get('/mycamps', 'CampController@mycamps')->name('mycamps');

// Registration-Process for Camp
Route::get('/camps/{camp}', 'CampController@show')->name('camp');
Route::post('/camps/{camp}', 'CampController@register');
Route::patch('/camps/{camp}', 'CampController@update');

// Admin Links
Route::group(['middleware' => 'can:isAdmin'], function() {
    Route::get('/adminpanel/dashboard', 'CampAdminController@index');
    Route::resource('admin', 'CampAdminController');
    Route::get('/admin/campuser/confirm/{camp}/{user}', 'CampUserController@updateTransaction');
    Route::get('/admin/campuser/confirm_laptop/{camp}/{user}', 'CampUserController@updateLaptopTransaction');
    Route::get('/admin/campuser/cancel/{camp}/{user}', 'CampUserController@cancelParticipation');
    Route::get('/admin/camp/{id}/export', 'CampAdminController@export');
});