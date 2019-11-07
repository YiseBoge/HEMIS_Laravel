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

Route::get('/', 'IndexController@index');
Route::get('/api/student-enrollment-chart', 'IndexController@enrollmentChart');
Route::get('/api/staff-chart', 'IndexController@staffChart');
Route::get('/api/age-enrollment-chart', 'IndexController@ageEnrollmentChart');
//  Band Routes...
Route::resource('band/band-name', 'Band\BandNamesController');

// Budget Routes...
Route::post('budgets/budget/{id}/approve', 'College\BudgetsController@approve');
Route::resource('budgets/budget', 'College\BudgetsController');
Route::resource('budgets/budget-description', 'College\BudgetDescriptionsController');
Route::post('budgets/internal-revenue/{id}/approve', 'College\InternalRevenuesController@approve');
Route::resource('budgets/internal-revenue', 'College\InternalRevenuesController');
Route::post('budgets/private-investment/{id}/approve', 'College\InvestmentsController@approve');
Route::resource('budgets/private-investment', 'College\InvestmentsController');

//  College Routes...
Route::resource('college/college-name', 'College\CollegeNamesController');
Route::resource('college/approval', 'College\CollegeApprovalController');

//  Department Routes...
Route::resource('department/department-name', 'Department\DepartmentNamesController');
Route::post('department/special-program-teacher/{id}/approve', 'Department\SpecialProgramTeacherController@approve');
Route::resource('department/special-program-teacher', 'Department\SpecialProgramTeacherController');
Route::post('department/publication/{id}/approve', 'Staff\PublicationsController@approve');
Route::resource('department/publication', 'Staff\PublicationsController');
Route::post('department/upgrading-staff/{id}/approve', 'Department\UpgradingStaffController@approve');
Route::resource('department/upgrading-staff', 'Department\UpgradingStaffController');
Route::post('department/postgraduate-diploma-training/{id}/approve', 'Department\PostGraduateDiplomaTrainingController@approve');
Route::resource('department/postgraduate-diploma-training', 'Department\PostGraduateDiplomaTrainingController');
Route::post('department/teachers/{id}/approve', 'Department\TeachersController@approve');
Route::resource('department/teachers', 'Department\TeachersController');
Route::post('department/diaspora-courses/{id}/approve', 'Department\DiasporaCoursesController@approve');
Route::resource('department/diaspora-courses', 'Department\DiasporaCoursesController');

//  Enrollment Routes...
Route::post('enrollment/normal/{id}/approve', 'Department\EnrollmentsController@approve');
Route::resource('enrollment/normal', 'Department\EnrollmentsController');
Route::get('enrollment/normal-chart', 'Department\EnrollmentsController@viewChart');
Route::get('enrollment/student-enrollment-chart', 'Department\EnrollmentsController@chart');

Route::post('enrollment/special-region-students/{id}/approve', 'Department\SpecialRegionsEnrollmentsController@approve');
Route::resource('enrollment/special-region-students', 'Department\SpecialRegionsEnrollmentsController');
Route::post('enrollment/specializing-students/{id}/approve', 'Department\SpecializingStudentsEnrollmentsController@approve');
Route::resource('enrollment/specializing-students', 'Department\SpecializingStudentsEnrollmentsController');
Route::post('enrollment/rural-area-students/{id}/approve', 'Department\RuralStudentEnrollmentsController@approve');
Route::resource('enrollment/rural-area-students', 'Department\RuralStudentEnrollmentsController');
Route::post('enrollment/other-region-students/{id}/approve', 'Department\OtherRegionStudentsController@approve');
Route::resource('enrollment/other-region-students', 'Department\OtherRegionStudentsController');
Route::post('enrollment/economically-disadvantaged/{id}/approve', 'Department\DisadvantagedStudentEnrollmentsController@approve');
Route::resource('enrollment/economically-disadvantaged', 'Department\DisadvantagedStudentEnrollmentsController');
Route::post('enrollment/age-enrollment/{id}/approve', 'Department\AgeEnrollmentsController@approve');
Route::resource('enrollment/age-enrollment', 'Department\AgeEnrollmentsController');
Route::post('enrollment/joint-program/{id}/approve', 'Department\JointProgramEnrollmentsController@approve');
Route::resource('enrollment/joint-program', 'Department\JointProgramEnrollmentsController');

//  Institution Routes...
Route::resource('institution/institution-name', 'Institution\InstitutionNamesController');
Route::resource('institution/institution-name', 'Institution\InstitutionNamesController');
Route::resource('institution/instance', 'Institution\InstancesController');
Route::post('/institution/instance/update-current', 'Institution\InstancesController@updateCurrentInstance')->name('updateCurrentInstance');
Route::resource('institution/general', 'Institution\InstitutionsController');
Route::post('institution/buildings/{id}/approve', 'College\BuildingsController@approve');
Route::resource('institution/buildings', 'College\BuildingsController');
Route::post('institution/researches/{id}/approve', 'Department\ResearchsController@approve');
Route::resource('institution/researches', 'Department\ResearchsController');
Route::resource('institution/management-data', 'Institution\ManagementDataController');

//  Staff Routes...
Route::post('staff/academic/{id}/approve', 'Staff\AcademicStaffsController@approve');
Route::resource('staff/academic', 'Staff\AcademicStaffsController');
Route::post('staff/technical/{id}/approve', 'Staff\TechnicalStaffsController@approve');
Route::resource('staff/technical', 'Staff\TechnicalStaffsController');
Route::post('staff/administrative/{id}/approve', 'Staff\AdministrativeStaffsController@approve');
Route::resource('staff/administrative', 'Staff\AdministrativeStaffsController');
Route::post('staff/ict/{id}/approve', 'Staff\IctStaffsController@approve');
Route::resource('staff/ict', 'Staff\IctStaffsController');
Route::post('staff/supportive/{id}/approve', 'Staff\SupportiveStaffsController@approve');
Route::resource('staff/supportive', 'Staff\SupportiveStaffsController');
Route::post('staff/management/{id}/approve', 'Staff\ManagementStaffsController@approve');
Route::resource('staff/management', 'Staff\ManagementStaffsController');
Route::post('staff/attrition/{id}/approve', 'Staff\StaffAttritionsController@approve');
Route::resource('staff/attrition', 'Staff\StaffAttritionsController');
Route::resource('staff/ict-staff-types', 'Staff\IctStaffTypesController');

//  Student Routes
Route::post('student/special-need/{id}/approve', 'Student\SpecialNeedStudentsController@approve');
Route::resource('student/special-need', 'Student\SpecialNeedStudentsController');
Route::post('student/foreign/{id}/approve', 'Student\ForeignStudentsController@approve');
Route::resource('student/foreign', 'Student\ForeignStudentsController');
Route::post('student/student-attrition/{id}/approve', 'Department\StudentAttritionController@approve');
Route::resource('student/student-attrition', 'Department\StudentAttritionController');
Route::post('student/other-attrition/{id}/approve', 'Department\OtherAttritionController@approve');
Route::resource('student/other-attrition', 'Department\OtherAttritionController');
Route::post('student/degree-relevant-employment/{id}/approve', 'Department\DegreeEmploymentsController@approve');
Route::resource('student/degree-relevant-employment', 'Department\DegreeEmploymentsController');
Route::post('student/exit-examination/{id}/approve', 'Department\ExitExaminationsController@approve');
Route::resource('student/exit-examination', 'Department\ExitExaminationsController');
Route::post('student/qualified-internship/{id}/approve', 'Department\QualifiedInternshipsController@approve');
Route::resource('student/qualified-internship', 'Department\QualifiedInternshipsController');
Route::post('student/cost-sharing/{id}/approve', 'Department\CostSharingController@approve');
Route::resource('student/cost-sharing', 'Department\CostSharingController');
Route::post('student/university-industry-linkage/{id}/approve', 'College\UniversityIndustryLinkageController@approve');
Route::resource('student/university-industry-linkage', 'College\UniversityIndustryLinkageController');


//  The rest
Route::get('/report/generate-full-report', 'Report\GenerateReportsController@generateFullReport');
Route::get('/report/generate-institution-report', 'Report\GenerateReportsController@generateInstitutionReport');
Route::resource('report', 'Report\ReportsController');
Route::resource('institution-report', 'Report\InstitutionReportsController');
Route::resource('region-name', 'Institution\RegionNamesController');
Route::resource('population', 'Institution\PopulationController');
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
Route::get('/change-password', 'HomeController@showChangePasswordForm');
Route::post('/changePassword', 'HomeController@changePassword')->name('changePassword');
Route::get('home/student-enrollment-chart', 'HomeController@enrollmentChart');
Route::get('home/age-enrollment-chart', 'HomeController@ageEnrollmentChart');

// Comment Routes
Route::get('/comments' , 'CommentsController@index');
Route::get('/comments/create' , 'CommentsController@create');
Route::post('/comments' , 'CommentsController@store');
Route::delete('/comments/{id}' , 'CommentsController@destroy');

// Support Contact Routes

Route::get('/support-contacts/public-view','SupportContactsController@publicView');
Route::resource('/support-contacts','SupportContactsController');