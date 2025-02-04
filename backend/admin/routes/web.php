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
//dashboard
Route::get('/', 'Admin@index')->middleware('status')->name('index');
Route::get('/endAllTesting', 'Admin@endAllTesting')->middleware('status')->name('endAllTesting');

//users
Route::get('/users', 'Admin@usersList')->middleware('status')->name('usersList');
Route::get('/users/{login}', 'Admin@userProfile')->middleware('status')->name('userProfile');

//tests
Route::get('/tests', 'Admin@testsList')->middleware('status')->name('testsList');
Route::get('/test/{id}', 'Admin@testDetail')->middleware('status')->name('testDetail');

//quests
Route::get('/quests', 'Admin@questsList')->middleware('status')->name('questsList');
Route::get('/quest/{id}', 'Admin@questDetail')->middleware('status')->name('questDetail');

//results
Route::get('/results', 'Admin@results')->middleware('status')->name('results');

//settings
Route::get('/settings', 'Admin@settings')->middleware('status')->name('settings');
Route::post('/settings', 'Admin@saveSettings')->middleware('status')->name('saveSettings');

//support
Route::get('/support', 'Admin@support')->middleware('status')->name('support');

//login page
Route::get('login', 'Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


