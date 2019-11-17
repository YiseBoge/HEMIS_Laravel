<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\DepartmentName;
use App\Models\Department\SpecialProgramTeacher;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpecialProgramTeacherController extends Controller
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

        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);
        $status = SpecialProgramTeacher::getEnum('ProgramStats')[$requestedStatus = request()->query('program_status', 'COMPLETED')];

        $filteredTeachers = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->SpecialProgramTeachers as $teacher)
                        $filteredTeachers[] = $teacher;
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->SpecialProgramTeachers()->where('program_stat', $status) as $teacher)
                        $filteredTeachers[] = $teacher;
        }

        $data = [
            'program_status' => $requestedStatus,
            'special_program_teachers' => $filteredTeachers,
            'departments' => $collegeDeps,

            'selected_department' => $requestedDepartment,
            'selected_status' => $requestedStatus,
            'page_name' => 'staff.special-program-teacher.index'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.special_program_teacher.index')->with($data);

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

        $data = [
            'program_type' => SpecialProgramTeacher::getEnum("ProgramTypes"),
            'program_status' => SpecialProgramTeacher::getEnum("ProgramStats"),
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'staff.special-program-teacher.create'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.special_program_teacher.create')->with($data);
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

        $specialProgramTeacher = new SpecialProgramTeacher;
        $specialProgramTeacher->male_number = $request->input('male_number');
        $specialProgramTeacher->female_number = $request->input('female_number');
        $specialProgramTeacher->program_stat = $request->input('program_status');
        $specialProgramTeacher->program_type = $request->input('program_type');

        $specialProgramTeacher->department_id = $department->id;

        if ($specialProgramTeacher->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $specialProgramTeacher->save();

        return redirect("/department/special-program-teacher")->with('success', 'Successfully Added Special Program Enrollment');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/department/special-program-teacher");
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

        $specialProgramTeacher = SpecialProgramTeacher::find($id);

        $data = [
            'id' => $id,
            'program_type' => $specialProgramTeacher->program_type,
            'program_status' => $specialProgramTeacher->program_stat,
            'male_number' => $specialProgramTeacher->male_number,
            'female_number' => $specialProgramTeacher->female_number,
            'page_name' => 'staff.special-program-teacher.edit'
        ];

        return view('departments.special_program_teacher.edit')->with($data);
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

        $specialProgramTeacher = SpecialProgramTeacher::find($id);

        $specialProgramTeacher->male_number = $request->input("male_number");
        $specialProgramTeacher->female_number = $request->input("female_number");
        $specialProgramTeacher->approval_status = "Pending";

        $specialProgramTeacher->save();

        return redirect("/department/special-program-teacher")->with('primary', 'Successfully Updated');

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
        $item = SpecialProgramTeacher::find($id);
        $item->delete();
        return redirect('/department/special-program-teacher')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $specialProgramTeacher = SpecialProgramTeacher::find($id);
            $specialProgramTeacher->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $specialProgramTeacher->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->specialProgramTeachers);
                        }
                    }
                }
            }
        }
        return redirect("/department/special-program-teacher")->with('primary', 'Success');
    }
}
