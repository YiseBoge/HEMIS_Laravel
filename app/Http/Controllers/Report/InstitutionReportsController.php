<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Institution\InstitutionName;
use App\Models\Report\InstitutionReportCard;
use App\Models\Report\InstitutionYearValue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InstitutionReportsController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles(['University Admin', 'Super Admin']);
        $institution_name = $user->institutionName;

        if ($institution_name == null) {
            if ($request->has('institution_name')) {
                $institution_name = InstitutionName::all()[$request->input('institution_name')];
            } else {
                $institution_name = InstitutionName::all()->first();
            }
        }

        $reports = InstitutionReportCard::groupedReports();
        $card = InstitutionReportCard::all()->sortBy('year')->first();
        $years = $card != null ? $card->reportYearValues()->where('institution_name_id', $institution_name->id)->get()->sortBy('year') : array();

        $ind = 0;
        foreach (InstitutionName::all() as $key => $inst) {
            if ($inst->id == $institution_name->id) {
                $ind = $key;
            }
        }

        $data = [
            'reports' => $reports,
            'years' => $years,
            'institution_names' => InstitutionName::all(),
            'institution_name' => $institution_name,
            'ind' => $ind,
            'page_name' => 'report.institution_report_card.index'
        ];
        return view('reports.institution_report_card.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return redirect('/institution-report');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return redirect('/institution-report');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/institution-report');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        $user = Auth::user();
        $user->authorizeRoles('University Admin');
        $institution_name = $user->institutionName;

        $reports = InstitutionReportCard::groupedReports();
        $card = InstitutionReportCard::all()->sortBy('year')->first();
        $years = $card != null ? $card->reportYearValues()->where('institution_name_id', $institution_name->id)->get()->sortBy('year') : array();


        $report = InstitutionReportCard::find($id);
        $target = $report->target($institution_name);
        $baseline = $report->reportYearValues()->where('institution_name_id', $institution_name->id)->get()->sortBy('year')->first();
        $change = 0;

        $ind = 0;
        foreach (InstitutionName::all() as $key => $inst) {
            if ($inst->id == $institution_name->id) {
                $ind = $key;
            }
        }


        $data = [
            'reports' => $reports,
            'years' => $years,
            'institution_names' => InstitutionName::all(),
            'institution_name' => $institution_name,
            'ind' => $ind,
            'report' => $report,
            'target' => $target,
            'baseline' => $baseline,
            'change' => $change,

            'has_modal' => 'yes',
            'page_name' => 'report.institution_report_card.edit'
        ];
        return view('reports.institution_report_card.index')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $target = InstitutionYearValue::find($id);
        $target->value = $request->input('target');

        $target->save();

        return redirect('/institution-report')->with('primary', 'Successfully Updated Target');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
