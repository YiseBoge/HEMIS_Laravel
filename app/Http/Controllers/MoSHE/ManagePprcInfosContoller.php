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
        $data = [ 'pprc_info' => [],
         'page_name' => 'moshe_admin.manage_pprc_info.create',
         'categories' => MoshePprc::getEnum('Categories')];
        return view('moshe_admin.manage_pprc_info.index')->with('data', $data);
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

        $moshe_pprc = new MoshePprc();
        $pprc_info_target = new PprcInfo();
        $pprc_info_baseline = new PprcInfo();
        $pprc_info_current = new PprcInfo();

        $moshe_pprc->category = $request->input('categories');
        $moshe_pprc->policy = $request->input('policy');
        $moshe_pprc->kpi_description = $request->input('kpi_indicator');

        $pprc_info_target->year = '0';//get this from the current year
        $pprc_info_target->value = 4;
        $pprc_info_target->type = 'TARGET';

        $pprc_info_current->year = '0';//get this from the current year
        $pprc_info_current->value = 3;
        $pprc_info_current->type = 'REGULAR';

        $pprc_info_baseline->year = '0';//get this from the current year
        $pprc_info_baseline->value = 2;
        $pprc_info_baseline->type = 'BASELINE';

        $moshe_pprc->save();
        $moshe_pprc->PprcInfo()->save($pprc_info_target);
        $moshe_pprc->PprcInfo()->save($pprc_info_current);
        $moshe_pprc->PprcInfo()->save($pprc_info_baseline);

        return redirect('moshe-admin/manage-pprc/');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [ 'pprc_info' => [] , 'pprc_obj' => MoshePprc::find($id),
        'page_name' => 'moshe_admin.manage_pprc_info.edit',
        'categories' => MoshePprc::getEnum('Categories')];
       return view('moshe_admin.manage_pprc_info.index')->with('data', $data);
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
        $this->validate($request, [
            'categories' => 'required',
            'policy' => 'required',
            'kpi_indicator' => 'required'
        ]);
        
        $moshe_pprc = MoshePprc::find($id);

        $moshe_pprc->category = $request->input('categories');
        $moshe_pprc->policy = $request->input('policy');
        $moshe_pprc->kpi_description = $request->input('kpi_indicator');

        $moshe_pprc->save();

        return redirect('moshe-admin/manage-pprc/');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pprc_obj = MoshePprc::find($id);
        $pprc_info = PprcInfo::where('moshe_pprc_id' , $pprc_obj->id);

        // die($pprc_info->id);

        $pprc_obj->delete();
        $pprc_info->delete();

        return redirect('moshe-admin/manage-pprc/');
    }
}