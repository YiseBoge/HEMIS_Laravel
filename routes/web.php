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

Route::resource('institution/instance', 'Institution\InstancesController');
Route::post('/institution/instance/update-current', 'Institution\InstancesController@updateCurrentInstance')->name('updateCurrentInstance');

Route::resource('institution/buildings', 'Institution\BuildingsController');

//Route::resource('staff/academic', 'Staff\AcademicStaffsController');
Route::resource('staff/academic', 'Staff\AcademicStaffsController');
Route::resource('staff/technical', 'Staff\TechnicalStaffsController');
Route::resource('staff/administrative', 'Staff\AdministrativeStaffsController');
Route::resource('staff/ict', 'Staff\IctStaffsController');
Route::resource('staff/supportive', 'Staff\SupportiveStaffsController');

Route::resource('student/special-need', 'Student\SpecialNeedStudentsController');
Route::resource('student/foreign', 'Student\ForeignStudentsController');
Route::resource('student/student-attrition', 'Department\StudentAttritionController');
Route::resource('student/other-attrition', 'Department\OtherAttritionController');

Route::resource('institution/institution-name','Institution\InstitutionNamesController');
Route::resource('band/band-name','Band\BandNamesController');
Route::resource('department/department-name','Department\DepartmentNamesController');
Route::resource('staff/ict-staff-types', 'Staff\IctStaffTypesController');

Route::resource('institution/non-admin', 'Institution\AdminAndNonAcademicStaffsController');
Route::resource('institution/management-data', 'Institution\ManagementDatasController');
Route::resource('institution/age-enrollment', 'Institution\AgeEnrollmentsController');
Route::resource('institution/foreign-staff', 'Institution\ForeignStaffsController');
Route::resource('college/college-name','College\CollegeNamesController');
Route::resource('department/special-program-teacher','Department\SpecialProgramTeacherController');
Route::resource('institution/region-name','Institution\RegionNamesController');
//Route::resource('institution/budget-description', 'Institution\BudgetDescriptionsController');

Route::resource('enrollment/normal','Department\EnrollmentsController');
Route::get('enrollment/normal-chart','Department\EnrollmentsController@viewChart');
Route::get('enrollment/student-enrollment-chart','Department\EnrollmentsController@chart');
Route::resource('enrollment/special-region-students','Institution\SpecialRegionsEnrollmentsController');
Route::resource('enrollment/specializing-students','Department\SpecializingStudentsEnrollmentsController');

Route::resource('institution/researches','Band\ResearchsController');
Route::resource('institution/university-industry-linkage','Band\UniversityIndustryLinkageController');
Route::resource('staff/technical-staff','College\TechnicalStaffController');
Route::resource('department/upgrading-staff', 'Department\UpgradingStaffController');
Route::resource('department/staff-leave', 'Department\StaffLeaveController');
Route::resource('department/expatriate-staff', 'Department\ExaptriateStaffsController');
Route::resource('department/postgraduate-diploma-training', 'Department\PostGraduateDiplomaTrainingController');
Route::resource('department/teachers', 'Department\TeachersController');
Route::resource('department/expatriate-staff', 'Department\ExpatriateStaffsController');

Route::get('/admin', function () {
    return view('admin.index');
});
Route::get('admin/student-enrollment-chart','HomeController@adminEnrollmentChart');

Route::get('/staff_attrition', function () {
    return view('staff.staff_attrition');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@getRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


Route::resource('university-admin', 'User\UniversityAdminController');
Route::resource('department-admin', 'User\DepartmentAdminController');
Route::resource('college-admin', 'User\CollegeAdminController');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('home/student-enrollment-chart','HomeController@enrollmentChart');
Route::get('home/age-enrollment-chart','HomeController@ageEnrollmentChart');
Route::get('home/specialNeeds-enrollment-chart','HomeController@specialNeedEnrollmentChart');