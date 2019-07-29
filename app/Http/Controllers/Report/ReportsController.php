<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\ReportCard;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
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
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $reports = ReportCard::groupedReports();
        $card = ReportCard::all()->sortBy('year')->first();
        $years = $card != null ? $card->reportYearValues->sortBy('year') : array();

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
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

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
            'page_name' => 'report.report_card.edit'
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
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $report = ReportCard::find($id);
        $report->target = $request->input('target');

        $report->save();

        return redirect('/report')->with('primary', 'Successfully Updated Target');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = ReportCard::find($id);
        $item->delete();
        return redirect('/report');
    }
}
