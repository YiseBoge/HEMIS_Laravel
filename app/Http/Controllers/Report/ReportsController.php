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
        $reports = ReportCard::groupedReports();
        $card = ReportCard::all()->first();
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
        // die('MotherFUckerr');
//        $pprc = MoshePprc::find($id);
//        $baseline = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'Baseline'])->first();
//        $current = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'regular' , 'year'=>'0'])->first();
//        $target = PprcInfo::where(['moshe_pprc_id' => $id , 'type'=>'Target'])->first();
//        $change = round((($current->value - $baseline->value)/($target->value - $baseline->value))*100 , 2);
//        // die($change);
//        // die(var_dump($target->id));
//
//        $data = [
//            'pprc_info' => [],
//            'pprc' => $pprc,
//            'baseline'=>$baseline,
//            'current' => $current,
//            'target' => $target,
//            'change' => $change,
//            'page_name' => 'moshe_admin.display_moshe_pprc.edit'
//        ];
//
//        return view('moshe_admin.display_moshe_pprc.index')->with('data', $data);
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
//        // die('WokkaFlokka');
//        $target_info = PprcInfo::find($id);
//        // die($target_info->type);
//        $target_info->value = $request->input('target');
//        $target_info->save();
//
//        return redirect('moshe-admin/display-pprc/');
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
