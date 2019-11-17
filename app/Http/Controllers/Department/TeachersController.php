<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\DepartmentName;
use App\Models\Department\Teacher;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TeachersController extends Controller
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedLevel = request()->query('education_level', 'Undergraduate');
        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);

        $teachers = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->teachers as $teacher)
                        $teachers[] = $teacher;
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->teachers()->where('level_of_education', $requestedLevel) as $teacher)
                        $teachers[] = $teacher;
        }

        $data = array(
            'teachers' => $teachers,
            'departments' => $collegeDeps,
            'education_levels' => Teacher::getEnum("EducationLevels"),

            'selected_department' => $requestedDepartment,
            'selected_level' => $requestedLevel,
            'page_name' => 'staff.teachers.index'
        );
        //return $filteredEnrollments;
        return view("departments.teachers.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $data = array(
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'education_levels' => Teacher::getEnum("EducationLevels"),
            'page_name' => 'staff.teachers.create'
        );
        return view('departments.teachers.create')->with($data);
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
            'citizenship' => 'required',
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

        $teacher = new Teacher;
        $teacher->male_number = $request->input('male_number');
        $teacher->female_number = $request->input('female_number');
        $teacher->level_of_education = $request->input('education_level');
        $teacher->citizenship = $request->input('citizenship');

        $teacher->department_id = $department->id;

        if ($teacher->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $teacher->save();

        return redirect("/department/teachers")->with('success', 'Successfully Added Teachers');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/department/teachers");
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

        $teachers = Teacher::find($id);
        $data = array(
            'id' => $id,
            'education_level' => $teachers->level_of_education,
            'citizenship' => $teachers->citizenship,
            'male_number' => $teachers->male_number,
            'female_number' => $teachers->female_number,
            'page_name' => 'departments.teachers.edit'
        );

        return view('departments.teachers.edit')->with($data);
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

        $teachers = Teacher::find($id);

        $teachers->male_number = $request->input("male_number");
        $teachers->female_number = $request->input("female_number");
        $teachers->approval_status = "Pending";

        $teachers->save();

        return redirect("/department/teachers")->with('primary', 'Successfully Updated');


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
        $item = Teacher::find($id);
        $item->delete();
        return redirect('/department/teachers')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $teacher = Teacher::find($id);
            $teacher->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $teacher->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        ApprovalService::approveData($department->teachers);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return redirect("/department/teachers")->with('primary', 'Success');
    }
}
