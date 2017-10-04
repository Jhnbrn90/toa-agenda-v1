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

// index routes
Route::get('/', 'TaskController@index')->name('home');
Route::get('/home', 'TaskController@index')->name('home');

// custom logout route
Route::get('/logout' , 'Auth\LoginController@logout');

// main index routes
Route::get('/datum/{date}', 'TaskController@index');

// create new task routes.
Route::get('/aanvraag/nieuw/{date}/{timeslot}', 'TaskController@create');
Route::post('/aanvraag/nieuw', 'TaskController@store');

// edit task routes.

