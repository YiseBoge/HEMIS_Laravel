<?php

namespace App\Http\Controllers\Institution;

use App\Models\Institution\BuildingPurpose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $purpose = new BuildingPurpose();
//        $purpose->purpose = 'Others';
//        $purpose->save();

        $buildingPurposes = BuildingPurpose::all();

        $requestedPurpose = $request->input('building_purpose');
        if ($requestedPurpose == null){
            $requestedPurpose = 0;
        }
        $buildingPurpose = BuildingPurpose::where('purpose', $buildingPurposes[$requestedPurpose])->get()->first();

        $data = array(
            'buildings' => $buildingPurpose->buildings(),
            'building_purposes' => $buildingPurposes,
            'current_purpose' => $requestedPurpose,
            'page_name' => 'institution.buildings.index'
        );

        return view('institutions.buildings.index')->with('data', $data);
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
