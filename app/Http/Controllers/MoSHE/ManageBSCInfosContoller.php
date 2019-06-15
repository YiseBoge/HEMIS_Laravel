<?php

namespace App\Http\Controllers\MoSHE;

use App\Http\Controllers\Controller;
use App\Models\MoSHE\MoSHEBSC;
use Illuminate\Http\Request;

class ManageBSCInfosContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bsc_info = MoSHEBSC::all();
        $data = [
            'bsc_info' => $bsc_info,
            'page_name' => 'moshe_admin.manage_bsc_info.index'
        ];
        return view('moshe_admin.manage_bsc_info.index')->with('data', $data);
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
