<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/users', 'Api@usersList');
Route::get('/user/{id}', 'Api@getUser');
Route::post('/addUser', 'Api@addUser')->name('addUser');
Route::post('/updateUser/{id}', 'Api@updateUser')->name('updateUser');
Route::delete('/deleteUser/{id}', 'Api@deleteUser')->name('deleteUser');