<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Building;
use App\Models\Institution\BuildingPurpose;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $buildingPurposes = BuildingPurpose::all();

        $requestedPurpose = $request->input('building_purpose');
        if ($requestedPurpose == null){
            $requestedPurpose = 0;
        }
        $buildingPurpose = $buildingPurposes[$requestedPurpose];

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $buildings = array();

        if ($institution != null) {
            foreach ($institution->buildings as $building) {
                foreach ($building->buildingPurposes as $purpose) {
                    if ($purpose->purpose == $buildingPurpose->purpose) {
                        $buildings[] = $building;
                    }
                }
            }
        } else {
            $buildings = $buildingPurpose->buildings;
        }


        $data = array(
            'buildings' => $buildings,
            'building_purposes' => $buildingPurposes,
            'current_purpose' => $requestedPurpose,
            'page_name' => 'institution.buildings.index'
        );

        return view('institutions.buildings.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

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
     * @param Request $request
     * @return Response
     * @throws ValidationException
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
        $building->financial_status = $request->input('financial_status');
        $building->completion_status = $request->input('completion_status');

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $building->institution_id = $institution->id;

        $building->save();

        $purposes = $request->input('building_purposes');
        if ($purposes != null){
            foreach ($purposes as $purposeString){
                $purpose = BuildingPurpose::where('purpose', $purposeString)->first();
                $purpose->buildings()->attach([$building->id]);
            }
        }

        $institution->buildings()->save($building);

        return redirect('institution/buildings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
