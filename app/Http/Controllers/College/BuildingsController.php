<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Institution\Building;
use App\Models\Institution\BuildingPurpose;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BuildingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        if ($requestedPurpose == null) {
            $requestedPurpose = 0;
        }
        $buildingPurpose = $buildingPurposes[$requestedPurpose];

        $user = Auth::user();
        $user->authorizeRoles(['College Admin', 'College Super Admin']);
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

        return view('institutions.buildings.index')->with($data);
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

        return view('institutions.buildings.create')->with($data);
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
            'date_started' => 'required|date|before:now',
            'date_completed' => 'required|date|after:date_started',
            'budget_allocated' => 'required|numeric|between:0,1000000000',
            'financial_status' => 'numeric|between:0,1000000000',
            'completion_status' => 'numeric|between:0,100',
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

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = null;
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
            $college->college_name_id = null;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $building->college_id = $college->id;

        if ($building->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $building->save();

        $purposes = $request->input('building_purposes');
        if ($purposes != null) {
            foreach ($purposes as $purposeString) {
                $purpose = BuildingPurpose::where('purpose', $purposeString)->first();
                $purpose->buildings()->attach([$building->id]);
            }
        }

        return redirect('institution/buildings')->with('success', 'Successfully Added Building');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('institution/buildings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $building = Building::find($id);

        // die(print_r($building));

        $data = array(
            'id' => $id,
            'building' => $building,
            'page_name' => 'institution.buildings.edit'
        );
        return view('institutions.buildings.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'budget_allocated' => 'required|numeric|between:0,1000000000',
            'financial_status' => 'numeric|between:0,1000000000',
            'completion_status' => 'numeric|between:0,100',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $building = Building::find($id);

        $building->budget_allocated = $request->input("budget_allocated");
        $building->financial_status = $request->input("financial_status");
        $building->completion_status = $request->input("completion_status");

        $building->save();
        return redirect('/institution/buildings')->with('primary', 'Successfully Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = Building::find($id);
        $item->delete();
        return redirect('/institution/buildings')->with('primary', 'Successfully Deleted');
    }
}
