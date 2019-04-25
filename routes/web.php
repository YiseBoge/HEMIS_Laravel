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
    return view('index');
});

Route::get('/staff', function () {
    return view('staff.view');
});

Route::get('/staff/add', function () {
    return view('staff.add');
});


Route::get('/students', function () {
    return view('students.view');
});

Route::get('/students/add', function () {
    return view('students.add');
});

Route::get('/admin', function () {
    return view('admin.index');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
