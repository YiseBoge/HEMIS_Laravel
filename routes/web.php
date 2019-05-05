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

Route::resource('institution/budget', 'Institution\BudgetsController');


Route::resource('staff/academic', 'Staff\Specialization\AcademicStaffsController');

Route::resource('staff/technical', 'Staff\Specialization\TechnicalStaffsController');

Route::resource('staff/administrative', 'Staff\Specialization\AdministrativeStaffsController');

Route::resource('staff/ict', 'Staff\Specialization\IctStaffsController');

Route::resource('staff/supportive', 'Staff\Specialization\SupportiveStaffsController');

Route::resource('student/disabled', 'Student\Specialization\DisabledStudentsController');

Route::resource('student/foreigner', 'Student\Specialization\ForeignerStudentsController');


Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('/staff_attrition', function () {
    return view('staff.staff_attrition');
});

Route::resource('staff/ict_staff_types', 'Staff\IctStaffTypesController');

Route::get('/student_attrition', function () {
    return view('students.student_attrition');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
