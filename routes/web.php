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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth' ], function () {
    Route::resource('season', 'SeasonController');
    Route::resource('race', 'RaceController');
    Route::post('race/copy-season', 'RaceController@copySeason')->name('race.copy-season');
    Route::resource('race.session', 'RaceSessionController');
    Route::post('race/session/apply-template', 'RaceSessionController@applyTemplate')->name('race.session.apply-template');
    Route::resource('circuit', 'CircuitController');
    Route::resource('country', 'CountryController');
    Route::resource('location', 'LocationController');
    Route::resource('template', 'TemplateController');
    Route::resource('template.session', 'TemplateSessionController');
});

Route::get('/', 'CalendarController@index')->name('index');
Route::get('/{access_token}', 'CalendarController@calendar')->name('calendar');

Route::get('/{access_token}/{race}/location', 'CalendarController@editLocation')->name('calendar.location.edit');
Route::put('/{access_token}/{race}/location', 'CalendarController@updateLocation')->name('calendar.location.update');
