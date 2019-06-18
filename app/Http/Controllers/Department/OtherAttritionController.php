<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\OtherAttrition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OtherAttritionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedType = $request->input('type');
        if ($requestedType == null) {
            $requestedType = 'CET';
        }

        $requestedCase = $request->input('case');
        if ($requestedCase == null) {
            $requestedCase = 'Readmission of Next Semester';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }

        $attritions = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->education_program == $requestedProgram && $college->education_level == $requestedLevel) {
                        foreach ($college->departments as $department) {
                            if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                foreach ($department->otherAttritions as $attrition) {
                                    if ($attrition->type == $requestedType && $attrition->case == $requestedCase) {
                                        $attritions[] = $attrition;
                                    }
                                }
                            }
                        }
                    }

                }

            }
        } else {
            $attritions = OtherAttrition::with('band')->get();
        }

        $data = array(
            'attritions' => $attritions,
            'bands' => BandName::all(),
            'programs' => College::getEnum('EducationPrograms'),
            'education_levels' => College::getEnum('EducationLevels'),
            'types' => OtherAttrition::getEnum('Types'),
            'cases' => OtherAttrition::getEnum('Cases'),
            'page_name' => 'departments.other_attritions.index',

            "selected_program" => $requestedProgram,
            "selected_level" => $requestedLevel,
            "selected_type" => $requestedType,
            "selected_case" => $requestedCase,
        );
        return view("departments.other_attrition.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $data = array(
            'bands' => BandName::all(),
            'programs' => College::getEnum('EducationPrograms'),
            'education_levels' => College::getEnum('EducationLevels'),
            'years' => Department::getEnum('YearLevels'),
            'types' => OtherAttrition::getEnum('Types'),
            'cases' => OtherAttrition::getEnum('Cases'),
            'page_name' => 'departments.other_attritions.create'
        );
        return view("departments.other_attrition.create")->with($data);
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
            'male_number' => 'required',
            'female_number' => 'required',
        ]);

        $attrition = new OtherAttrition;
        $attrition->type = $request->input('type');
        $attrition->case = $request->input('case');
        $attrition->male_students_number = $request->input('male_number');
        $attrition->female_students_number = $request->input('female_number');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = $request->input("education_level");
            $college->education_program = $request->input("program");
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->otherAttritions()->save($attrition);

        return redirect("/student/other-attrition");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}