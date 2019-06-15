<?php

namespace App\Http\Controllers\MoSHE;

use App\Http\Controllers\Controller;
use App\Models\MoSHE\MoshePprc;
use App\Models\MoSHE\PprcInfo;
use Illuminate\Http\Request;

class ManagePprcInfosContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pprc_info = MoshePprc::all();
        $data = [
            'pprc_info' => $pprc_info,
            'page_name' => 'moshe_admin.manage_pprc_info.index'
        ];
        return view('moshe_admin.manage_pprc_info.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $bsc_info = MoSHEBSC::all();
        // die('Allah is good');
        $data = [ 'bsc_info' => [],
         'page_name' => 'moshe_admin.manage_bsc_info.create',
         'categories' => MoSHEBSC::getEnum('Categories')];
        return view('moshe_admin.manage_bsc_info.index')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'categories' => 'required',
            'policy' => 'required',
            'kpi_indicator' => 'required'
        ]);

        $moshe_bsc = new MoSHEBSC();
        $bsc_info = new BSCInfo();

        $moshe_bsc->category = $request->input('categories');
        $moshe_bsc->policy = $request->input('policy');
        $moshe_bsc->kpi_description = $request->input('kpi_indicator');

        $bsc_info->year = 2018;
        $bsc_info->value = 100000;
        $bsc_info->type = 'Target';

        $moshe_bsc->save();
        $moshe_bsc->BSCInfo()->save($bsc_info);

        // die('got to the motherfucker');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
