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

Route::get('/academic-staff', function () {
    return view('staff.academic');
});

Route::get('/technical-staff', function () {
    return view('staff.technical');
});

Route::get('/administrative-staff', function () {
    return view('staff.administrative');
});

Route::get('/ict-staff', function () {
    return view('staff.ict');
});

Route::get('/supportive-staff', function () {
    return view('staff.supportive');
});

Route::get('/academic-staff/add', function () {
    return view('staff.add-academic');
});

Route::get('/technical-staff/add', function () {
    return view('staff.add-technical');
});

Route::get('/administrative-staff/add', function () {
    return view('staff.add-administrative');
});

Route::get('/ict-staff/add', function () {
    return view('staff.add-ict');
});

Route::get('/supportive-staff/add', function () {
    return view('staff.add-supportive');
});



Route::get('/disabled-students', function () {
    return view('students.disabled');
});

Route::get('/foriegner-students', function () {
    return view('students.foriegner');
});

Route::get('/disabled-students/add', function () {
    return view('students.add-disabled');
});

Route::get('/foriegner-students/add', function () {
    return view('students.add-foriegner');
});

Route::get('/admin', function () {
    return view('admin.index');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
