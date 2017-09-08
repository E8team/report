<?php

// Route::get('/import_dormitory', 'IndexController@showImportDormitoryForm');

// Route::post('/import_dormitory', 'IndexController@importDormitory')->name('import_dormitory');

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
Route::get('/admin/{path?}', 'IndexController@admin')->where('path', '[\/\w\.-]*');
Route::get('/{path?}', 'IndexController@index')->where('path', '[\/\w\.-]*');

