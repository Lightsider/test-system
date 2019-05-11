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

//questions
Route::get('/quests', 'Api@questsList')->name('questsList');
Route::get('/quests/{testId}', 'Api@questsForTestList')->name('questsForTestList');
Route::get('/quest/{id}', 'Api@questDetail')->name('questDetail');
Route::post('/addQuestToTest', 'Api@addQuestToTest')->name('addQuestToTest');
Route::delete('/deleteQuestInTest/{id_test}/{id_quest}', 'Api@deleteQuestInTest')->name('deleteQuestInTest');
Route::post('/addQuest', 'Api@addQuest')->name('addQuest');
Route::post('/updateQuest/{id_quest}', 'Api@updateQuest')->name('updateQuest');
Route::delete('/deleteQuest/{id_quest}', 'Api@deleteQuest')->name('deleteQuest');

//categories
Route::get('/categories', 'Api@categoriesList')->name('categoriesList');
Route::get('/category/{id}', 'Api@categoryDetail')->name('categoryDetail');
Route::post('/addCategory', 'Api@addCategory')->name('addCategory');
Route::post('/updateCategory/{id}', 'Api@updateCategory')->name('updateCategory');
Route::delete('/deleteCategory/{id}', 'Api@deleteCategory')->name('deleteCategory');

//files
Route::delete('/deleteFile/{id}', 'Api@deleteFile')->name('deleteFile');
