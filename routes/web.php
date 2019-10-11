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
})->name("dashboard");


//Route::get('/files/{id?}', 'FileController@index');

Route::post('/files/add', 'FileController@store');
//Route::post('/files/edit/{id}', 'FileController@edit');
//Route::post('/files/delete/{id}', 'FileController@destroy');


Route::post('/all','FileController@getAll');

Route::get('/public','FileController@getPublic');

Route::get('/gets/{folder}/{song}',[ 'as' => 'audio','uses' => 'FileController@getSong']);

Route::post('/getUser',function(){
	return Auth::id();
});

Route::post('/authenticate','\App\Http\Controllers\Auth\LoginController@login');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/getPlay','PlaylistController@getPlaylistsMini');

Route::post('getPlaylists','PlaylistController@getPlaylists');

Route::post('/createList','PlaylistController@store');

Route::post('/addToList','PlaylistController@edit');


Auth::routes();

