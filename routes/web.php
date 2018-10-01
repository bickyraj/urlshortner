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

// Route::get('/', 'HomeController@index');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

Auth::routes();

Route::get('/login', function () {
	return view('layouts.app');
});

Route::get('fire', function () {
    // this fires the event
    event(new App\Events\TestNotification());
    return "event fired";
});
Route::get('test', function () {
    // this checks for the event
    return view('test');
});

Route::get('/{code}', ['as' => 'get', 'uses' => 'Admin\LinkController@getActualUrl']);
Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');




