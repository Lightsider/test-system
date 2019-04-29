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
//users
Route::get('/users', 'Api@usersList');
Route::get('/user/{id}', 'Api@getUser');
Route::post('/addUser', 'Api@addUser')->name('addUser');
Route::post('/updateUser/{id}', 'Api@updateUser')->name('updateUser');
Route::delete('/deleteUser/{id}', 'Api@deleteUser')->name('deleteUser');

//tests
Route::get('/tests', 'Api@testsList')->name('testsList');
Route::get('/test/{id}', 'Api@getTest');
Route::post('/addTest', 'Api@addTest')->name('addTest');
Route::post('/updateTest/{id}', 'Api@updateTest')->name('updateTest');
Route::delete('/deleteTest/{id}', 'Api@deleteTest')->name('deleteTest');