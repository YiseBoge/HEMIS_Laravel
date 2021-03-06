<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\SpecializingStudentsEnrollment;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpecializingStudentsEnrollmentsController extends Controller
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
        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);
        $requestedSpecializationType = request()->query('specialization_type', 'Specialization');
        $requestedYearLevel = request()->query('year_level', '1');
        $requestedType = request()->query('student_type', 'Current');

        $enrollments = array();
        $total = 0;
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->specializingStudentEnrollments as $enrollment){
                        $enrollments[] = $enrollment;
                        $total += $enrollment->male_students_number + $enrollment->female_students_number;
                    }
            } else
                if ($college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->specializingStudentEnrollments()->where([
                            'student_type' => $requestedType, 'specialization_type' => $requestedSpecializationType])->get() as $enrollment){
                            $enrollments[] = $enrollment;
                            $total += $enrollment->male_students_number + $enrollment->female_students_number;
                        }
        }

        $educationPrograms = College::getEnum("EducationPrograms");
        array_pop($educationPrograms);

        $data = array(
            'enrollments' => $enrollments,
            'departments' => $collegeDeps,
            'programs' => $educationPrograms,
            'specialization_types' => SpecializingStudentsEnrollment::getEnum("SpecializationTypes"),
            'student_types' => SpecializingStudentsEnrollment::getEnum('StudentTypes'),
            'total' => $total,

            'selected_department' => $requestedDepartment,
            'selected_student_type' => $requestedType,
            'selected_program' => $requestedProgram,
            'selected_specialization' => $requestedSpecializationType,
            'selected_year' => $requestedYearLevel,

            'page_name' => 'enrollment.specializing_student_enrollment.index'
        );
        return view("enrollment.specializing_students.index")->with($data);
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

        $educationPrograms = College::getEnum("EducationPrograms");
        array_pop($educationPrograms);

        $data = array(
            'colleges' => CollegeName::all(),
            'departments' => DepartmentName::all(),
            'programs' => $educationPrograms,
            'specialization_types' => SpecializingStudentsEnrollment::getEnum("SpecializationTypes"),
            'student_types' => SpecializingStudentsEnrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.specializing_student_enrollment.create'
        );
        return view('enrollment.specializing_students.create')->with($data);
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
            'male_number' => 'required|numeric|between:0,10000000',
            'female_number' => 'required|numeric|between:0,10000000',
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

        $enrollment = new SpecializingStudentsEnrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->student_type = $request->input('student_type');
        $enrollment->specialization_type = $request->input('specialization_type');
        $enrollment->field_of_specialization = $request->input('field_of_specialization');

        $enrollment->department_id = $department->id;

        if ($enrollment->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $enrollment->save();

        return redirect("/enrollment/specializing-students")->with('success', 'Successfully Added Specializing Students Enrollment');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/enrollment/specializing-students");
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

        $specializingStudentsEnrollment = SpecializingStudentsEnrollment::findOrFail($id);
        $department = $specializingStudentsEnrollment->department()->first();
        $college = $department->college()->first();
        $data = array(
            'id' => $specializingStudentsEnrollment->id,
            'program' => $college->education_program,
            'specialization_type' => $specializingStudentsEnrollment->specialization_type,
            'student_type' => $specializingStudentsEnrollment->student_type,
            'field_of_specialization' => $specializingStudentsEnrollment->field_of_specialization,
            'male_students_number' => $specializingStudentsEnrollment->male_students_number,
            'female_students_number' => $specializingStudentsEnrollment->female_students_number,
            'year_level' => $department->year_level,
            'page_name' => 'enrollment.specializing_students.edit'
        );

        return view('enrollment.specializing_students.edit')->with($data);
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
            'male_number' => 'required|numeric|between:0,10000000',
            'female_number' => 'required|numeric|between:0,10000000',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $specializingStudentsEnrollment = SpecializingStudentsEnrollment::findOrFail($id);

        $specializingStudentsEnrollment->male_students_number = $request->input('male_number');
        $specializingStudentsEnrollment->female_students_number = $request->input('female_number');
        $specializingStudentsEnrollment->approval_status = "Pending";

        $specializingStudentsEnrollment->save();

        return redirect("/enrollment/specializing-students")->with('primary', 'Successfully Updated');


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
        $item = SpecializingStudentsEnrollment::findOrFail($id);
        $item->delete();
        return redirect('/enrollment/specializing-students')->with('primary', 'Successfully Updated');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $enrollment = SpecializingStudentsEnrollment::findOrFail($id);
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $enrollment->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->specializingStudentEnrollments);
                        }
                    }
                }
            }
        }
        return redirect("/enrollment/specializing-students?department=" . $selectedDepartment)->with('primary', 'Success');
    }
}
