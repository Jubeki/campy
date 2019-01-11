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
Route::get('/', 'WelcomeController@index');

// Legal Links
Route::view('/teilnahmebedingungen', 'legal.terms');
Route::view('/datenschutz', 'legal.privacy');
Route::view('/impressum', 'legal.imprint');

// Profile for authenticated users
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile', 'ProfileController@update');

// Camp Links
Route::get('mycamps/create/{camp}', 'CampUserController@create');
Route::resource('mycamps', 'CampUserController');
Route::resource('camps', 'CampController');

// Admin Links
Route::group(['middleware' => 'can:isAdmin'], function() {
    Route::get('/adminpanel/dashboard', 'CampAdminController@index');
    Route::resource('admin', 'CampAdminController');
    Route::get('/admin/campuser/confirm/{camp}/{user}', 'CampUserController@updateTransaction');
    Route::get('/admin/campuser/confirm_laptop/{camp}/{user}', 'CampUserController@updateLaptopTransaction');
    Route::get('/admin/campuser/cancel/{camp}/{user}', 'CampUserController@cancelParticipation');
    Route::get('/admin/camp/{id}/export', 'CampAdminController@export');
});