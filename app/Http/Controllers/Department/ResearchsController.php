<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Band\Research;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ResearchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $institution = $user->institution();

        $user = Auth::user();
        $institution = $user->institution();

        $requestedType = $request->input('type');
        if ($requestedType == null) {
            $requestedType = 'Normal';
        }

        $requestedStatus = $request->input('status');
        if ($requestedStatus == null) {
            $requestedStatus = 'On Going';
        }

        $researches = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                    foreach ($department->researches as $research) {
                                        if ($research->type == $requestedType && $research->status == $requestedStatus) {
                                            $researches[] = $research;
                                        }
                                    }
                                }                                
                            }
                        }
                    }
                }
            }
        } else {
            $researches = Research::with('department')->get();
        }

        $data = array(
            'researchs' => $researches,
            'bands' => BandName::all(),
            'completions' => Research::getEnum('Completions'),
            'types' => Research::getEnum('Types'),
            'page_name' => 'bands.research.index',

            "selected_type" => $requestedType,
            "selected_status" => $requestedStatus
        );
        return view("bands.research.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'completions' => Research::getEnum('Completions'),
            'types' => Research::getEnum('Types'),
            'page_name' => 'bands.research.create'
        );
        return view("bands.research.create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'number' => 'required',
            'female_number' => 'required',
            'budget' => 'required',
            'external_budget' => 'required',
            'male_participating_number' => 'required',
            'female_participating_number' => 'required',
            'other_male_number' => 'required',
            'other_female_number' => 'required'
        ]);

        $research = new Research;
        $research->number = $request->input('number');
        $research->male_teachers_participating_number = $request->input('male_participating_number');
        $research->female_teachers_participating_number = $request->input('female_participating_number');
        $research->female_researchers_number = $request->input('female_number');
        $research->male_researchers_other_number = $request->input('other_male_number');
        $research->female_researchers_other_number = $request->input('other_male_number');
        $research->budget_allocated = $request->input('other_male_number');
        $research->budget_from_externals = $request->input('other_male_number');
        $research->status = $request->input('status');
        $research->type = $request->input('type');

        $user = Auth::user();

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
        if($college == null){
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if($department == null){
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->researches()->save($research);

        return redirect("/institution/researches");
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
