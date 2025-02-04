<?php
use App\Settings;
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
//tests
Route::get('/', 'PublicSide@index')->name('index');
Route::get('/test/{id}', 'PublicSide@testPreview')->name('testPreview');
Route::get('/startTest/{id}', 'PublicSide@startTest')->name('startTest');
Route::get('/testing', 'PublicSide@testing')->name('testing');
Route::get('/nextQuest', 'PublicSide@nextQuest')->name('nextQuest');
Route::get('/testingResult', 'PublicSide@testingResult')->name('testingResult');

//profile
Route::get('/profile', 'PublicSide@profile')->name('profile');
Route::post('/profile', 'PublicSide@saveProfile')->name('saveProfile');

//contacts
Route::get('/contacts', 'PublicSide@contacts')->name('contacts');

//login and register pages
Route::get('auth', 'Auth\LoginController@index')->name('auth');
Route::post('login', 'Auth\LoginController@login')->name('login');
if(Settings::getByKey("enable_register")->value==="yes")
    Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
