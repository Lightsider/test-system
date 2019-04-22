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
//settings
Route::get('/settings', 'Admin@settings')->middleware('status')->name('settings');
Route::post('/settings', 'Admin@saveSettings')->middleware('status')->name('saveSettings');

//login page
Route::get('login', 'Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


