<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\OtherAttrition;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OtherAttritionController extends Controller
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
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedProgram = request()->query('program', 'Regular');
        $requestedLevel = request()->query('education_level', 'Undergraduate');
        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);
        $requestedType = request()->query('type', 'CET');
        $requestedCase = request()->query('case', 'Readmission of Next Semester');

        $attrition = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->otherAttritions as $attr)
                        $attrition[] = $attr;
            } else
                if ($college->education_level == $requestedLevel && $college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->otherAttritions()->where([
                            'type' => $requestedType, 'case' => $requestedCase])->get() as $attr)
                            $attrition[] = $attr;
        }

        $data = array(
            'attritions' => $attrition,
            'departments' => $collegeDeps,
            'programs' => College::getEnum('EducationPrograms'),
            'education_levels' => College::getEnum('EducationLevels'),
            'types' => OtherAttrition::getEnum('Types'),
            'cases' => OtherAttrition::getEnum('Cases'),
            'page_name' => 'students.other_attrition.index',

            'selected_department' => $requestedDepartment,
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
            'page_name' => 'students.other_attrition.create'
        );
        return view("departments.other_attrition.create")->with($data);
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
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'None');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

        $attrition = new OtherAttrition;
        $attrition->type = $request->input('type');
        $attrition->case = $request->input('case');
        $attrition->male_students_number = $request->input('male_number');
        $attrition->female_students_number = $request->input('female_number');

        $attrition->department_id = $department->id;

        if ($attrition->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $attrition->save();

        return redirect("/student/other-attrition")->with('success', 'Successfully Added Other Information');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        return redirect("/student/other-attrition");

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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $otherAttrition = OtherAttrition::find($id);
        $department = $otherAttrition->department()->first();
        $college = $department->college()->first();
        $data = array(
            'id' => $id,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'year_level' => $department->year_level,
            'student_type' => $otherAttrition->student_type,
            'type' => $otherAttrition->type,
            'case' => $otherAttrition->case,
            'male_students_number' => $otherAttrition->male_students_number,
            'female_students_number' => $otherAttrition->female_students_number,
            'page_name' => 'departments.other_attrition.edit'
        );

        return view("departments.other_attrition.edit")->with($data);
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
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $otherAttrition = OtherAttrition::find($id);

        $otherAttrition->male_students_number = $request->input("male_number");
        $otherAttrition->female_students_number = $request->input("female_number");
        $otherAttrition->approval_status = "Pending";

        $otherAttrition->save();

        return redirect("/student/other-attrition")->with('primary', 'Successfully Updated');
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
        $item = OtherAttrition::find($id);
        $item->delete();
        return redirect('/student/other-attrition')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $attrition = OtherAttrition::find($id);
            $attrition->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $attrition->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        ApprovalService::approveData($department->otherAttritions);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/student/other-attrition?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
