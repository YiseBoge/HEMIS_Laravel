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
Route::resource('institution/budget-description', 'Institution\BudgetDescriptionsController');
Route::resource('institution/internal-revenue', 'Institution\InternalRevenuesController');
Route::resource('institution/private-investment', 'Institution\InvestmentsController');

Route::resource('staff/academic', 'Staff\AcademicStaffsController');
Route::resource('staff/technical', 'Staff\TechnicalStaffsController');
Route::resource('staff/administrative', 'Staff\AdministrativeStaffsController');
Route::resource('staff/ict', 'Staff\IctStaffsController');
Route::resource('staff/supportive', 'Staff\SupportiveStaffsController');

Route::resource('student/disabled', 'Student\DisabledStudentsController');
Route::resource('student/foreigner', 'Student\ForeignerStudentsController');

Route::resource('institution/institution-name','Institution\InstitutionNamesController');
Route::resource('band/band-name','Band\BandNamesController');
Route::resource('department/department-name','Department\DepartmentNamesController');
Route::resource('staff/ict-staff-types', 'Staff\IctStaffTypesController');
//Route::resource('institution/budget-description', 'Institution\BudgetDescriptionsController');


Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('/staff_attrition', function () {
    return view('staff.staff_attrition');
});

Route::get('/student_attrition', function () {
    return view('students.student_attrition');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
