<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Institution\InstitutionName;
use App\Models\Report\InstitutionReportCard;
use App\Models\Report\InstitutionYearValue;
use App\Models\Report\ReportCard;
use App\Models\Report\ReportYearValue;
use App\Services\GeneralReportService;
use App\Services\InstitutionReportService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GenerateReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate all institutions KPI Report.
     *
     * @return Response
     */
    public function generateFullReport()
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        $year = $user->currentInstance->year;

        $reportService = new GeneralReportService($year);

        $total = 0;
        $this->saveReportYearValue($year, '1.1.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '1.1.2', $total);


        $total = $reportService->fullEnrollment('All', 'Undergraduate');
        $this->saveReportYearValue($year, '1.2.1', $total);

        $total = $reportService->fullEnrollment('All', 'Post Graduate(Masters)');
        $this->saveReportYearValue($year, '1.2.2', $total);

        $total = $reportService->fullEnrollment('All', 'Post Doctoral');
        $this->saveReportYearValue($year, '1.2.3', $total);

        $total = $reportService->fullEnrollment('All', 'Health Specialty');
        $this->saveReportYearValue($year, '1.2.4', $total);


        $total = 100 * ($reportService->privateEnrollments('All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '1.3.1', $total);

        $total = 100 * ($reportService->privateEnrollments('All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '1.3.2', $total);

        $total = 100 * ($reportService->privateEnrollments('All', 'Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '1.3.3', $total);

        $total = 100 * ($reportService->privateEnrollments('All', 'Health Specialty') /
                $reportService->fullEnrollment('All', 'Health Specialty'));
        $this->saveReportYearValue($year, '1.3.4', $total);


        $total = 100 * ($reportService->stemEnrollment('All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '1.4.1', $total);

        $total = 100 * ($reportService->stemEnrollment('All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '1.4.2', $total);

        $total = 100 * ($reportService->stemEnrollment('All', 'Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '1.4.3', $total);


        $total = 100 * ($reportService->fullEnrollment('Female', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '1.5.1', $total);

        $total = 100 * ($reportService->fullEnrollment('Female', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '1.5.2', $total);

        $total = 100 * ($reportService->fullEnrollment('Female', 'Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '1.5.3', $total);

        $total = 100 * ($reportService->fullEnrollment('Female', 'Health Specialty') /
                $reportService->fullEnrollment('All', 'Health Specialty'));
        $this->saveReportYearValue($year, '1.5.4', $total);


        $total = 100 * ($reportService->stemEnrollment('All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '1.6.1', $total);

        $total = 100 * ($reportService->stemEnrollment('All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '1.6.2', $total);

        $total = 100 * ($reportService->stemEnrollment('All', 'Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '1.6.3', $total);


        $total = 100 * ($reportService->specialNeedEnrollment('Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '1.7.1', $total);

        $total = 100 * ($reportService->specialNeedEnrollment('Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '1.7.2', $total);

        $total = 100 * ($reportService->specialNeedEnrollment('Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '1.7.3', $total);

        $total = 100 * ($reportService->specialNeedEnrollment('Health Specialty') /
                $reportService->fullEnrollment('All', 'Health Specialty'));
        $this->saveReportYearValue($year, '1.7.4', $total);


        $total = 100 * ($reportService->emergingRegionsEnrollment('Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '1.8.1', $total);

        $total = 100 * ($reportService->emergingRegionsEnrollment('Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '1.8.2', $total);

        $total = 100 * ($reportService->emergingRegionsEnrollment('Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '1.8.3', $total);

        $total = 100 * ($reportService->emergingRegionsEnrollment('Health Specialty') /
                $reportService->fullEnrollment('All', 'Health Specialty'));
        $this->saveReportYearValue($year, '1.8.4', $total);


        $total = 100 * ($reportService->economicallyPoorEnrollment('Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '1.9.1', $total);

        $total = 100 * ($reportService->economicallyPoorEnrollment('Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '1.9.2', $total);

        $total = 100 * ($reportService->economicallyPoorEnrollment('Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '1.9.3', $total);

        $total = 100 * ($reportService->economicallyPoorEnrollment('Health Specialty') /
                $reportService->fullEnrollment('All', 'Health Specialty'));
        $this->saveReportYearValue($year, '1.9.4', $total);


        // break

        $total = 100 * ($reportService->dropout('All', 'All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.1.1', $total);

        $total = 100 * ($reportService->dropout('All', 'All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '2.1.2', $total);

        $total = 100 * ($reportService->dropout('All', 'All', 'Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '2.1.3', $total);

        $total = 100 * ($reportService->dropout('All', 'All', 'Health Specialty') /
                $reportService->fullEnrollment('All', 'Health Specialty'));
        $this->saveReportYearValue($year, '2.1.4', $total);


        $total = 100 * ($reportService->dropout('Female', 'All', 'Undergraduate') /
                $reportService->fullEnrollment('Female', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.2.1', $total);

        $total = 100 * ($reportService->dropout('Female', 'All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('Female', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '2.2.2', $total);

        $total = 100 * ($reportService->dropout('Female', 'All', 'Post Doctoral') /
                $reportService->fullEnrollment('Female', 'Post Doctoral'));
        $this->saveReportYearValue($year, '2.2.3', $total);

        $total = 100 * ($reportService->dropout('Female', 'All', 'Health Specialty') /
                $reportService->fullEnrollment('Female', 'Health Specialty'));
        $this->saveReportYearValue($year, '2.2.4', $total);


        $total = 100 * ($reportService->academicDismissal('All', 'All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.3.1', $total);

        $total = 100 * ($reportService->academicDismissal('All', 'All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '2.3.2', $total);

        $total = 100 * ($reportService->academicDismissal('All', 'All', 'Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '2.3.3', $total);

        $total = 100 * ($reportService->academicDismissal('All', 'All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.3.4', $total);


        $total = 100 * ($reportService->academicDismissal('Female', 'All', 'Undergraduate') /
                $reportService->fullEnrollment('Female', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.4.1', $total);

        $total = 100 * ($reportService->academicDismissal('Female', 'All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('Female', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '2.4.2', $total);

        $total = 100 * ($reportService->academicDismissal('Female', 'All', 'Post Doctoral') /
                $reportService->fullEnrollment('Female', 'Post Doctoral'));
        $this->saveReportYearValue($year, '2.4.3', $total);

        $total = 100 * ($reportService->academicDismissal('Female', 'All', 'Health Specialty') /
                $reportService->fullEnrollment('Female', 'Health Specialty'));
        $this->saveReportYearValue($year, '2.4.4', $total);


        $total = 100 * ($reportService->graduationRate('All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.5.1', $total);

        $total = 100 * ($reportService->graduationRate('All', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('All', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '2.5.2', $total);

        $total = 100 * ($reportService->graduationRate('All', 'Post Doctoral') /
                $reportService->fullEnrollment('All', 'Post Doctoral'));
        $this->saveReportYearValue($year, '2.5.3', $total);

        $total = 100 * ($reportService->graduationRate('All', 'Undergraduate') /
                $reportService->fullEnrollment('All', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.5.4', $total);


        $total = 100 * ($reportService->graduationRate('Female', 'Undergraduate') /
                $reportService->fullEnrollment('Female', 'Undergraduate'));
        $this->saveReportYearValue($year, '2.6.1', $total);

        $total = 100 * ($reportService->graduationRate('Female', 'Post Graduate(Masters)') /
                $reportService->fullEnrollment('Female', 'Post Graduate(Masters)'));
        $this->saveReportYearValue($year, '2.6.2', $total);

        $total = 100 * ($reportService->graduationRate('Female', 'Post Doctoral') /
                $reportService->fullEnrollment('Female', 'Post Doctoral'));
        $this->saveReportYearValue($year, '2.6.3', $total);

        $total = 100 * ($reportService->graduationRate('Female', 'Health Specialty') /
                $reportService->fullEnrollment('Female', 'Health Specialty'));
        $this->saveReportYearValue($year, '2.6.4', $total);


        $total = 0;
        $this->saveReportYearValue($year, '2.7.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.7.2', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.7.3', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.7.4', $total);


        $total = 0;
        $this->saveReportYearValue($year, '2.8.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.8.2', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.8.3', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.8.4', $total);


        $total = 0;
        $this->saveReportYearValue($year, '2.9.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.9.2', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.9.3', $total);

        $total = 0;
        $this->saveReportYearValue($year, '2.9.4', $total);


        // break

        $total = 100 * ($reportService->qualifiedAcademicStaff() /
                $reportService->academicStaffRate('All', false));
        $this->saveReportYearValue($year, '3.1.1', $total);

        $total = 100 * (($reportService->fullEnrollment('All', 'Undergraduate') +
                    $reportService->fullEnrollment('All', 'Undergraduate') +
                    $reportService->fullEnrollment('All', 'Undergraduate') +
                    $reportService->fullEnrollment('All', 'Undergraduate')) /
                $reportService->qualifiedAcademicStaff());
        $this->saveReportYearValue($year, '3.1.2', $total);

        $total = 0;
        $this->saveReportYearValue($year, '3.1.3', $total);

        $total = 0;
        $this->saveReportYearValue($year, '3.1.4', $total);


        $total = 0;
        $this->saveReportYearValue($year, '3.2.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '3.3.1', $total);


        $total = 0;
        $this->saveReportYearValue($year, '3.4.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '3.4.2', $total);

        $total = 0;
        $this->saveReportYearValue($year, '3.4.3', $total);


        // break

        $total = 0;
        $this->saveReportYearValue($year, '4.1.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '4.2.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '4.3.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '4.4.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '4.5.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '4.6.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '4.7.1', $total);


        // break

        $total = 0;
        $this->saveReportYearValue($year, '5.1.1', $total);


        $total = 0;
        $this->saveReportYearValue($year, '5.2.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '5.2.2', $total);


        // break

        $total = 0;
        $this->saveReportYearValue($year, '6.1.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.2.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.3.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.4.1', $total);


        $total = 0;
        $this->saveReportYearValue($year, '6.5.1', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.5.2', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.5.3', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.5.4', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.5.5', $total);

        $total = 0;
        $this->saveReportYearValue($year, '6.5.6', $total);

        return redirect('/report')->with('primary', 'Successfully Updated Current Year KPIs');
    }

    /**
     * Generate specific institution KPI Report.
     *
     * @return Response
     */
    public function generateInstitutionReport()
    {
        $user = Auth::user();
        $user->authorizeRoles('University Admin');
        $year = $user->currentInstance->year;
        $institution_name = $user->institutionName;

        $reportService = new InstitutionReportService($institution_name, $year);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.1.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.1.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.1.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.1.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.2.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.2.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.2.3', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.3.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.3.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.3.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.3.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.4.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.4.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.4.3', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.5.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.5.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.5.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.5.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.6.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.6.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.6.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.6.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.7.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.7.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.7.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '1.7.4', $total);


        // break

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.1.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.1.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.1.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.1.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.2.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.2.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.2.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.2.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.3.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.3.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.3.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.3.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.4.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.4.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.4.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.4.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.5.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.5.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.5.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.5.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.6.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.6.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.6.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.6.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.7.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.7.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.7.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.7.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.8.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.8.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.8.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.8.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.9.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.9.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.9.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '2.9.4', $total);


        // break

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '3.1.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '3.1.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '3.1.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '3.1.4', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '3.2.1', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '3.3.1', $total);


        // break

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '4.1.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '4.2.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '4.3.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '4.4.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '4.5.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '4.6.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '4.7.1', $total);


        // break

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '5.1.1', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '5.2.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '5.2.2', $total);


        // break

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.1.1', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.2.1', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.3.1', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.4.1', $total);


        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.5.1', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.5.2', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.5.3', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.5.4', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.5.5', $total);

        $total = 0;
        $this->saveInstitutionYearValue($institution_name, $year, '6.5.6', $total);

        return redirect('/institution-report')->with('primary', 'Successfully Updated Current Year KPIs');
    }

    /**
     * @param $institution_name
     * @param $year
     * @param $kpiNumber
     * @param $totalValue
     */
    private function saveInstitutionYearValue(InstitutionName $institution_name, $year, $kpiNumber, $totalValue)
    {
        $kpi = InstitutionReportCard::getEnum('kpi')[$kpiNumber];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $totalValue;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);
    }

    /**
     * @param $year
     * @param $kpiNumber
     * @param $totalValue
     * @return void
     */
    private function saveReportYearValue($year, $kpiNumber, $totalValue)
    {
        $kpi = ReportCard::getEnum('kpi')[$kpiNumber];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $totalValue;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);
    }
}
