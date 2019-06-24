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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
//  Band Routes
Route::resource('band/band-name', 'Band\BandNamesController');

// Budget Routes
Route::resource('budgets/budget', 'College\BudgetsController');
Route::resource('budgets/budget-description', 'College\BudgetDescriptionsController');
Route::resource('budgets/internal-revenue', 'College\InternalRevenuesController');
Route::resource('budgets/private-investment', 'College\InvestmentsController');

//  College Routes
Route::resource('college/college-name', 'College\CollegeNamesController');

//  Department Routes
Route::resource('department/department-name', 'Department\DepartmentNamesController');
Route::resource('department/special-program-teacher', 'Department\SpecialProgramTeacherController');
Route::resource('department/publication', 'Staff\PublicationsController');
Route::resource('department/upgrading-staff', 'Department\UpgradingStaffController');
Route::resource('department/staff-leave', 'Department\StaffLeaveController');
Route::resource('department/expatriate-staff', 'Department\ExaptriateStaffsController');
Route::resource('department/postgraduate-diploma-training', 'Department\PostGraduateDiplomaTrainingController');
Route::resource('department/teachers', 'Department\TeachersController');
Route::resource('department/expatriate-staff', 'Department\ExpatriateStaffsController');
Route::resource('department/diaspora-courses', 'Department\DiasporaCoursesController');

//  Enrollment Routes
Route::post('enrollment/normal/{id}/approve', 'Department\EnrollmentsController@approve');
Route::get('enrollment/normal-chart', 'Department\EnrollmentsController@viewChart');
Route::get('enrollment/student-enrollment-chart', 'Department\EnrollmentsController@chart');

Route::resource('enrollment/normal', 'Department\EnrollmentsController');
Route::resource('enrollment/special-region-students', 'Department\SpecialRegionsEnrollmentsController');
Route::resource('enrollment/specializing-students', 'Department\SpecializingStudentsEnrollmentsController');
Route::resource('enrollment/rural-area-students', 'Department\RuralStudentEnrollmentsController');
Route::resource('enrollment/other-region-students', 'Department\OtherRegionStudentsController');
Route::resource('enrollment/economically-disadvantaged', 'Department\DisadvantagedStudentEnrollmentsController');
Route::resource('enrollment/age-enrollment', 'Department\AgeEnrollmentsController');
Route::resource('enrollment/joint-program', 'Department\JointProgramEnrollmentsController');

//  Institution Routes
Route::resource('institution/institution-name', 'Institution\InstitutionNamesController');
Route::resource('institution/instance', 'Institution\InstancesController');
Route::post('/institution/instance/update-current', 'Institution\InstancesController@updateCurrentInstance')->name('updateCurrentInstance');
Route::resource('institution/general', 'Institution\InstitutionsController');
Route::resource('institution/buildings', 'College\BuildingsController');
Route::resource('institution/non-admin', 'Institution\AdminAndNonAcademicStaffsController');
Route::resource('institution/management-data', 'Institution\ManagementDatasController');
Route::resource('institution/foreign-staff', 'Institution\ForeignStaffsController');
Route::resource('institution/researches', 'Department\ResearchsController');

//  Staff Routes
Route::resource('staff/academic', 'Staff\AcademicStaffsController');
Route::resource('staff/technical', 'Staff\TechnicalStaffsController');
Route::resource('staff/administrative', 'Staff\AdministrativeStaffsController');
Route::resource('staff/ict', 'Staff\IctStaffsController');
Route::resource('staff/supportive', 'Staff\SupportiveStaffsController');
Route::resource('staff/management', 'Staff\ManagementStaffsController');
Route::resource('staff/attrition', 'Staff\StaffAttritionsController');
Route::resource('staff/ict-staff-types', 'Staff\IctStaffTypesController');

//  Student Routes
Route::resource('student/special-need', 'Student\SpecialNeedStudentsController');
Route::resource('student/foreign', 'Student\ForeignStudentsController');
Route::resource('student/student-attrition', 'Department\StudentAttritionController');
Route::resource('student/other-attrition', 'Department\OtherAttritionController');
Route::resource('student/degree-relevant-employment', 'Department\DegreeEmploymentsController');
Route::resource('student/exit-examination', 'Department\ExitExaminationsController');
Route::resource('student/cost-sharing', 'Department\CostSharingController');
Route::resource('student/university-industry-linkage', 'College\UniversityIndustryLinkageController');


//  The rest
Route::get('/report/generate-full-report', 'Report\GenerateReportsController@generateFullReport');
Route::get('/report/generate-institution-report', 'Report\GenerateReportsController@generateInstitutionReport');
Route::resource('report', 'Report\ReportsController');
Route::resource('region-name', 'Institution\RegionNamesController');
Route::get('admin/student-enrollment-chart', 'HomeController@adminEnrollmentChart');


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
Route::get('home/student-enrollment-chart', 'HomeController@enrollmentChart');
Route::get('home/age-enrollment-chart', 'HomeController@ageEnrollmentChart');