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

Route::get('/allstudents','StudentController@index');
Route::post('/create','StudentController@create_student');
Route::post('/delete','StudentController@delete');
Route::post('/update','StudentController@update');