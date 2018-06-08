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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/song_lyrics','SongLyricsController');
Route::get('song_lyrics_data','SongLyricsController@TableData')->name('song_lyrics_data');
Route::resource('/song_lyrics', 'SongLyricsController');