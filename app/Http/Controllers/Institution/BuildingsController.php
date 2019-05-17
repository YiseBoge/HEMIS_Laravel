<?php

namespace App\Http\Controllers\Institution;

use App\Models\Institution\Building;
use App\Models\Institution\BuildingPurpose;
use App\Models\Institution\Institution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $buildingPurpose = $buildingPurposes[$requestedPurpose];

        $data = array(
            'buildings' => $buildingPurpose->buildings,
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
        $buildingPurposes = BuildingPurpose::all();

        $data = array(
            'building_purposes' => $buildingPurposes,
            'page_name' => 'institution.buildings.create'
        );

        return view('institutions.buildings.create')->with('data', $data);
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
            'building_name' => 'required',
            'contractor_name' => 'required',
            'consultant_name' => 'required',
            'date_started' => 'required',
            'date_completed' => 'required',
            'budget_allocated' => 'required',
        ]);

        $building = new Building();
        $building->building_name = $request->input('building_name');
        $building->contractor_name = $request->input('contractor_name');
        $building->consultant_name = $request->input('consultant_name');
        $building->date_started = $request->input('date_started');
        $building->date_completed = $request->input('date_completed');
        $building->budget_allocated = $request->input('budget_allocated');
        $building->completion_status = $request->input('financial_status');
        $building->financial_status = $request->input('financial_status');

        $user = Auth::user();
        $institution = Institution::where('id', $user->institution_id)->first();
        $building->institution_id = $institution->id;

        $building->save();

        $purposes = $request->input('building_purposes');
        if ($purposes != null){
            foreach ($purposes as $purposeString){
                $purpose = BuildingPurpose::where('purpose', $purposeString)->first();
                $purpose->buildings()->attach([$building->id]);
            }
        }

        return redirect('institution/buildings');
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
