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

// Route::get('/', function () {
//     $title = 'INV - PO';
//     return view('layout.main', ['title' => $title]);
// });

// Route::resource('tool', 'ToolsController');

// Route::resource('student', 'StudentsController');

Route::get('/student', 'StudentsController@index');
Route::get('/student/{id}/edit', 'StudentsController@edit');
Route::post('/student/create', 'StudentsController@store');
Route::post('/student/update', 'StudentsController@update');

Route::get('/student/destroy/{id}', 'StudentsController@destroy');
