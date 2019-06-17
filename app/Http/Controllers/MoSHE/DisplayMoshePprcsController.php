<?php

namespace App\Http\Controllers\MoSHE;

use App\Http\Controllers\Controller;
use App\Models\MoSHE\MoshePprc;
use App\Models\MoSHE\PprcInfo;
use Illuminate\Http\Request;


class DisplayMoshePprcsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pprcs = MoshePprc::all();
        $data = [
            'pprc_info' => $pprcs,
            'page_name' => 'moshe_admin.display_moshe_pprc.index'
        ];
        return view('moshe_admin.display_moshe_pprc.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $pprc = MoshePprc::find($id);
        $baseline = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'Baseline'])->first();
        $current = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'regular' , 'year'=>'0'])->first();
        $target = PprcInfo::where(['moshe_pprc_id' => $id , 'type'=>'Target'])->first();
        $change = round((($current->value - $baseline->value)/($target->value - $baseline->value))*100 , 2);
        // die($change);
        // die(var_dump($target->id));

        $data = [
            'pprc_info' => [],
            'pprc' => $pprc,
            'baseline'=>$baseline,
            'current' => $current,
            'target' => $target,
            'change' => $change,
            'page_name' => 'moshe_admin.display_moshe_pprc.detail'
        ];

        return view('moshe_admin.display_moshe_pprc.index')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // die('MotherFUckerr');
        $pprc = MoshePprc::find($id);
        $baseline = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'Baseline'])->first();
        $current = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'regular' , 'year'=>'0'])->first();
        $target = PprcInfo::where(['moshe_pprc_id' => $id , 'type'=>'Target'])->first();
        $change = round((($current->value - $baseline->value)/($target->value - $baseline->value))*100 , 2);
        // die($change);
        // die(var_dump($target->id));

        $data = [
            'pprc_info' => [],
            'pprc' => $pprc,
            'baseline'=>$baseline,
            'current' => $current,
            'target' => $target,
            'change' => $change,
            'page_name' => 'moshe_admin.display_moshe_pprc.edit'
        ];

        return view('moshe_admin.display_moshe_pprc.index')->with('data', $data);
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
        // die('WokkaFlokka');
        $target_info = PprcInfo::find($id);
        // die($target_info->type);
        $target_info->value = $request->input('target');
        $target_info->save();

        return redirect('moshe-admin/display-pprc/');
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
