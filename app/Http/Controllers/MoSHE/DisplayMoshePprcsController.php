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
        $baseline = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'BASELINE']);
        $current = PprcInfo::where(['moshe_pprc_id'=>$pprc->id , 'type'=>'REGULAR' , 'year'=>0]);
        $target = PprcInfo::where('moshe_pprc_id' , $id)->first();
        die(var_dump($target->id));
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
