<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $buildings = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->buildings as $building) {
                                foreach ($building->buildingPurposes as $purpose) {
                                    if ($purpose->purpose == $buildingPurpose->purpose) {
                                        $buildings[] = $building;
                                    }
                                }
                            }
                        }
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
            'page_name' => 'buildings.buildings.index'
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
        if ($user == null) abort(401, 'Login required.');
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if($band == null){
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);            
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }
        $building->college_id = $college->id;

        $building->save();

        $purposes = $request->input('building_purposes');
        if ($purposes != null){
            foreach ($purposes as $purposeString){
                $purpose = BuildingPurpose::where('purpose', $purposeString)->first();
                $purpose->buildings()->attach([$building->id]);
            }
        }

        $college->buildings()->save($building);

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
