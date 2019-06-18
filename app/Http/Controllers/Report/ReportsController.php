<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\ReportCard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ReportsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
//        foreach (ReportCard::all() as $rep){
//            $yearValue = new ReportYearValue();
//            $yearValue->year = '2021';
//            $yearValue->value = 40;
//            $rep->reportYearValues()->save($yearValue);
//        }
        $reports = ReportCard::groupedReports();
        $card = ReportCard::all()->sortBy('year')->first();
        $years = $card != null ? $card->reportYearValues : array();

        $data = [
            'reports' => $reports,
            'years' => $years,
            'page_name' => 'report.report_card.index'
        ];
        return view('reports.report_card.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $reports = ReportCard::groupedReports();
        $card = ReportCard::all()->sortBy('year')->first();
        $years = $card != null ? $card->reportYearValues : array();

        $report = ReportCard::find($id);
        $baseline = $report->reportYearValues->sortBy('year')->first();
        $change = 0;

        $data = [
            'reports' => $reports,
            'report' => $report,
            'years' => $years,
            'baseline' => $baseline,
            'change' => $change,
            'page_name' => 'reports.report_card.edit'
        ];

        return view('reports.report_card.index')->with($data);
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
        $report = ReportCard::find($id);
        $report->target = $request->input('target');

        $report->save();
//        // die('WokkaFlokka');
//        $target_info = PprcInfo::find($id);
//        // die($target_info->type);
//        $target_info->value = $request->input('target');
//        $target_info->save();
//
        return redirect('/report');
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

    /**
     * Add new Year Value to report
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function newYearValue(Request $request, $id)
    {
        $this->validate($request, [
            'year' => 'required',
            'value' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $report = ReportCard::find($id);
    }
}
