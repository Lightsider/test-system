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
//tests list
Route::get('/', 'PublicSide@index')->name('index');

//contacts
Route::get('/contacts', 'PublicSide@contacts')->name('contacts');

//login and register pages
Route::get('auth', 'Auth\LoginController@index')->name('auth');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
