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
Auth::routes();

// Route::get('/', function () { return view('welcome'); });
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::patch('/profile', 'ProfileController@update');
Route::get('/teilnahmebedingungen', function() { return view('legal.terms');} );
Route::get('/datenschutz', function() { return view('legal.privacy');} );
Route::get('/impressum', function() { return view('impressum');} );

Route::get('/', 'WelcomeController@index');
Route::get('mycamps/create/{camp}', 'CampUserController@create');
Route::resource('mycamps', 'CampUserController');
Route::resource('camps', 'CampController');


Route::group(['middleware' => 'can:isAdmin'], function() {
    Route::get('/adminpanel/dashboard', 'CampAdminController@index');
    Route::resource('admin', 'CampAdminController');
    Route::get('/admin/campuser/confirm/{camp}/{user}', 'CampUserController@updateTransaction');
    Route::get('/admin/campuser/confirm_laptop/{camp}/{user}', 'CampUserController@updateLaptopTransaction');
    Route::get('/admin/campuser/cancel/{camp}/{user}', 'CampUserController@cancelParticipation');
    Route::get('/admin/camp/{id}/export', 'CampAdminController@export');
});