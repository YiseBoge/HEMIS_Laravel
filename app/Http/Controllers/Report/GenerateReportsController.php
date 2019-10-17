<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\StudentAttrition;
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
     * @return Response|string
     */
    public function generateFullReport()
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        $year = $user->currentInstance->year;

        $reportService = new GeneralReportService($year);

        $kpi = ReportCard::getEnum('kpi')['1.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.1.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.2.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.2.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.2.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.3.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.3.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.3.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.4.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.4.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.5.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.5.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.5.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.5.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.6.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.6.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.6.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.7.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.7.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.7.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.7.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.8.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.8.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.8.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.8.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['1.9.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.9.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.9.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['1.9.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['2.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.1.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.1.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.1.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.2.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.2.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.2.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.3.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.3.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.3.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.4.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.4.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.4.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.5.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.5.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.5.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.5.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.6.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.6.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.6.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.6.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.7.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.7.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.7.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.7.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.8.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.8.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.8.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.8.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['2.9.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.9.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.9.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['2.9.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['3.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.1.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.1.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.1.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['3.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['3.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.4.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['3.4.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['4.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.5.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.6.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['4.7.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['5.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['5.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['5.2.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = ReportCard::getEnum('kpi')['6.1.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.2.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.3.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.4.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = ReportCard::getEnum('kpi')['6.5.1'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.5.2'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.5.3'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.5.4'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.5.5'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = ReportCard::getEnum('kpi')['6.5.6'];
        $rep = ReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues;
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new ReportYearValue() : $value;
        $yearValue->year = $year;
        $total = 0;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        return redirect('/report')->with('primary', 'Successfully Updated Current Year KPIs');
    }

    /**
     * Generate specific institution KPI Report.
     *
     * @return void
     */
    public function generateInstitutionReport()
    {
        $user = Auth::user();
        $user->authorizeRoles('University Admin');
        $year = $user->currentInstance->year;
        $institution_name = $user->institutionName;

        $reportService = new InstitutionReportService($institution_name, $year);

        $kpi = InstitutionReportCard::getEnum('kpi')['1.1.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->enrollment('All', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['1.1.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->enrollment('All', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->enrollment('All', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['1.2.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->enrollment('Female', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['1.2.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->enrollment('Female', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->enrollment('Female', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['1.3.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->specialNeedEnrollment(College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['1.3.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->specialNeedEnrollment(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->specialNeedEnrollment(College::getEnum('education_level')['POST_GRADUATE_PHD']);;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = InstitutionReportCard::getEnum('kpi')['2.1.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->dropout('All', 'All', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['2.1.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->dropout('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->dropout('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['2.2.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->dropout('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['2.2.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->dropout('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->dropout('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['2.3.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicDismissal('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['2.3.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicDismissal('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->academicDismissal('All', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['2.4.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicDismissal('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['2.4.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicDismissal('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->academicDismissal('Female', StudentAttrition::getEnum('student_type')['ALL'], College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['2.5.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->graduationRate('All', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['2.5.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->graduationRate('All', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->graduationRate('All', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['2.6.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->graduationRate('Female', College::getEnum('education_level')['UNDERGRADUATE']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['2.6.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->graduationRate('Female', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->graduationRate('Female', College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['2.7.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicAttrition();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['2.7.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->nonAcademicAttrition();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = InstitutionReportCard::getEnum('kpi')['3.1.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->qualifiedStaff();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['3.1.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->qualifiedTeacherToStudent();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['3.2.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->exitExamination();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['3.3.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->degreeEmployment();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = InstitutionReportCard::getEnum('kpi')['4.1.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicStaffPublication();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['4.1.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->publicationByPostgraduates();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['4.1.3'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->patents();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = InstitutionReportCard::getEnum('kpi')['5.1.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicStaffRate('Female', false);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['5.2.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->managementStaffRate('Female', false);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['5.3.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->enrollmentsRate('Female', false);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['5.4.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->academicStaffRate('All', true);;
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['5.5.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->managementStaffRate('All', true);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['5.6.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->enrollmentsRate('All', true);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = InstitutionReportCard::getEnum('kpi')['6.1.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->diasporaCourses();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['6.2.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->foreignStudents(College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->foreignStudents(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->foreignStudents(College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['6.2.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->jointEnrollment(College::getEnum('education_level')['UNDERGRADUATE']) +
            $reportService->jointEnrollment(College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $reportService->jointEnrollment(College::getEnum('education_level')['POST_GRADUATE_PHD']);
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        $kpi = InstitutionReportCard::getEnum('kpi')['6.3.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->expatriateStaff();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);


        // break

        $kpi = InstitutionReportCard::getEnum('kpi')['7.1.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->budgetNotFromGovernment();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['7.2.1'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->nonUtilizedFunds();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        $kpi = InstitutionReportCard::getEnum('kpi')['7.2.2'];
        $rep = InstitutionReportCard::where('kpi', $kpi)->get()->first();
        $values = $rep->reportYearValues()->where('institution_name_id', $institution_name->id)->get();
        $value = null;
        foreach ($values as $val) if ($val->year == $year) $value = $val;
        $yearValue = $value == null ? new InstitutionYearValue() : $value;
        $yearValue->year = $year;
        $yearValue->institution_name_id = $institution_name->id;
        $total = $reportService->unjustifiableExpenses();
        $yearValue->value = $total;
        $rep->reportYearValues()->save($yearValue);

        return redirect('/institution-report')->with('primary', 'Successfully Updated Current Year KPIs');
    }
}
