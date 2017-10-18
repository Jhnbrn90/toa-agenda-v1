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

Route::view('/test', 'test');

// index routes
Route::get('/', 'TaskController@index')->name('home');
Route::get('/home', 'TaskController@index')->name('home');

// filter routes
Route::get('/filter', 'TaskController@filter')->name('taskFilter');
Route::get('/filter/{date}', 'TaskController@filter')->name('taskFilterDate');

// custom logout route
Route::get('/logout' , 'Auth\LoginController@logout');

// main index routes
Route::get('/datum/{date}', 'TaskController@index')->name('taskDate');
Route::post('/date/search', 'TaskController@searchDate');

// create new task routes.
Route::get('/aanvraag/nieuw/{date}/{timeslot}', 'TaskController@create');
Route::post('/aanvraag/nieuw', 'TaskController@store');

// edit task routes.
Route::get('/aanvraag/{task}/bewerken', 'TaskController@edit');
Route::patch('/aanvraag/{task}', 'TaskController@update');
Route::delete('/aanvraag/{task}', 'TaskController@destroy');

// absence notification
Route::get('/afwezig/{date}/{timeslot}', 'AbsenceController@create');
Route::post('/afwezig', 'AbsenceController@store');

// admin routes
Route::prefix('admin')->group(function () {
    // dashboard
    Route::get('/', 'AdminController@index')->name('admin_index');

    // settings page
    Route::get('settings', 'TimetableController@show')->name('admin_settings');
    Route::post('timetable/new', 'TimetableController@store');
    Route::patch('timetable/edit/{timeslot}', 'TimetableController@update');
    Route::delete('timetable/edit/{timeslot}', 'TimetableController@destroy');

    // absence routes
    Route::get('absence', 'AbsenceController@index')->name('admin_absence_index');
    Route::get('absence/create', 'AbsenceController@create_admin')->name('admin_absence_create');
    Route::post('absence', 'AbsenceController@store_admin');
    Route::get('absence/edit/{absence}', 'AbsenceController@edit');
    Route::patch('absence/{absence}', 'AbsenceController@update');
    Route::delete('absence/{absence}/delete', 'AbsenceController@destroy');

    // task routes
    Route::get('task/{task}', 'AdminController@show');
    Route::get('tasks/all', 'AdminController@showAllTasks')->name('admin_tasks_all');
    Route::patch('task/{task}', 'AdminController@updateTask');

    // user routes
    Route::get('users/create', 'AdminController@createUser')->name('admin_create_user');
    Route::get('users/manage', 'AdminController@showUsers')->name('admin_show_users');
});

