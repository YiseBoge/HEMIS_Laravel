<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\StudentAttrition;
use App\Models\Report\ReportCard;
use App\Models\Report\ReportYearValue;
use App\Services\GeneralReportService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GenerateReportsController extends Controller
{
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

        if ($year == null) {
            return "NO yeaaaaarrrr";
        }

        $reportService = new GeneralReportService($year);

        $kpi = ReportCard::getEnum('kpi')['1.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->enrollment('All', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.1.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->enrollment('All', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->enrollment('All', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->enrollment('Female', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->enrollment('Female', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.2.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = $reportService->enrollment('Female', College::getEnum('education_level')['UNDERGRADUATE']);
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->specialNeedEnrollment(College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.3.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->specialNeedEnrollment(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->specialNeedEnrollment(College::getEnum('education_level')['POST_GRADUATE_PHD']);;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->disadvantagedStudentEnrollment(College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->disadvantagedStudentEnrollment(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->disadvantagedStudentEnrollment(College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.5.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->emergingRegionsEnrollment(College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->emergingRegionsEnrollment(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->emergingRegionsEnrollment(College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.6.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->ruralAreasEnrollment(College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->ruralAreasEnrollment(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->ruralAreasEnrollment(College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.7.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->privateEnrollments(College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->privateEnrollments(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->privateEnrollments(College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['2.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->dropout('All', 'All', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.1.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->dropout('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->dropout('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.2.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->dropout('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->dropout('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->academicDismissal('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.3.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->academicDismissal('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->academicDismissal('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->academicDismissal('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.4.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->academicDismissal('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->academicDismissal('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.5.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->graduationRate('All', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.5.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->graduationRate('All', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->graduationRate('All', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.6.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->graduationRate('Female', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.6.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->graduationRate('Female', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->graduationRate('Female', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.7.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->dropout('All', StudentAttrition::getEnum('student_type')['SPECIAL_NEED_STUDENTS'], College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['SPECIAL_NEED_STUDENTS'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['SPECIAL_NEED_STUDENTS'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.8.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->dropout('All', StudentAttrition::getEnum('student_type')['ECONOMICALLY_DISADVANTAGED_STUDENTS'], College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['ECONOMICALLY_DISADVANTAGED_STUDENTS'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['ECONOMICALLY_DISADVANTAGED_STUDENTS'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.9.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->dropout('All', StudentAttrition::getEnum('student_type')['EMERGING_REGION_STUDENTS'], College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['EMERGING_REGION_STUDENTS'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['EMERGING_REGION_STUDENTS'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.10.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.10.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['3.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.1.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['3.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->exitExamination();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = $reportService->degreeEmployment();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['4.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.1.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.1.3'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['5.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['5.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['5.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['5.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['5.5.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['5.6.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['6.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['6.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.2.2'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['6.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['7.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['7.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['7.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get();
        $value = $rep->reportYearValues()->where('year', $year)->get();
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->value = 0 /* calculated value here */
        ;
        $rep->reportYearValues()->save($yearValue);

        return redirect('/report');
    }
}
