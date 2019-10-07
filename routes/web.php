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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/files/{id?}', 'FileController@index');

Route::post('/files/add', 'FileController@store');
Route::post('/files/edit/{id}', 'FileController@edit');
Route::post('/files/delete/{id}', 'FileController@destroy');


Route::post('/all','FileController@getAll');

Route::get('/public','FileController@getPublic');

Route::get('/gets/{folder}/{song}',[ 'as' => 'audio','uses' => 'FileController@getSong']);

Route::post('/getUser',function(){
	return Auth::id();
});


Auth::routes();

