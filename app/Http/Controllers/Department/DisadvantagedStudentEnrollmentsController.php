<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\DisadvantagedStudentEnrollment;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DisadvantagedStudentEnrollmentsController extends Controller
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
        $requestedQuintile = request()->query('quintile', 'Lowest');
        $requestedType = DisadvantagedStudentEnrollment::getEnum('student_type')[$selectedType = request()->query('student_type', 'NORMAL')];

        $enrollments = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->disadvantagedStudentEnrollments as $enrollment)
                        $enrollments[] = $enrollment;
            } else
                if ($college->education_level == $requestedLevel && $college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->disadvantagedStudentEnrollments()->where([
                            'student_type' => $requestedType, 'quintile' => $requestedQuintile])->get() as $enrollment)
                            $enrollments[] = $enrollment;
        }

        $data = array(
            'enrollments' => $enrollments,
            'departments' => $collegeDeps,
            'programs' => College::getEnum("EducationPrograms"),
            'education_levels' => College::getEnum("EducationLevels"),
            'quintiles' => DisadvantagedStudentEnrollment::getEnum('Quintiles'),
            'student_types' => DisadvantagedStudentEnrollment::getEnum('StudentTypes'),

            'selected_department' => $requestedDepartment,
            'selected_quintile' => $requestedQuintile,
            'selected_type' => $selectedType,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            'page_name' => 'enrollment.disadvantaged_students.index'
        );
        //return $filteredEnrollments;
        return view("enrollment.disadvantaged_students.index")->with($data);
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
        $educationLevels = College::getEnum("EducationLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);

        $data = array(
            'colleges' => CollegeName::all(),
            'departments' => DepartmentName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'quintiles' => DisadvantagedStudentEnrollment::getEnum('Quintiles'),
            'student_types' => DisadvantagedStudentEnrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.disadvantaged_students.create'
        );
        return view("enrollment.disadvantaged_students.create")->with($data);
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
            'student_type' => 'required',
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

        $enrollment = new DisadvantagedStudentEnrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->quintile = $request->input('quintile');
        $enrollment->student_type = $request->input('student_type');

        $enrollment->department_id = $department->id;

        if ($enrollment->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $enrollment->save();

        return redirect("/enrollment/economically-disadvantaged")->with('success', 'Successfully Added Economically Disadvantaged Enrollment');
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
        return redirect("/enrollment/economically-disadvantaged");
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $disadvantagedStudentEnrollment = DisadvantagedStudentEnrollment::find($id);
        $department = $disadvantagedStudentEnrollment->department()->first();
        $college = $department->college()->first();

        $data = array(
            'id' => $disadvantagedStudentEnrollment->id,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'quintile' => $disadvantagedStudentEnrollment->quintile,
            'student_type' => $disadvantagedStudentEnrollment->student_type,
            'male_students_number' => $disadvantagedStudentEnrollment->male_students_number,
            'female_students_number' => $disadvantagedStudentEnrollment->female_students_number,
            'year_level' => $department->year_level,
            'page_name' => 'enrollment.disadvantaged_students.edit'
        );

        return view("enrollment.disadvantaged_students.edit")->with($data);
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $disadvantagedStudentEnrollment = DisadvantagedStudentEnrollment::find($id);
        $disadvantagedStudentEnrollment->male_students_number = $request->input("male_number");
        $disadvantagedStudentEnrollment->female_students_number = $request->input("female_number");
        $disadvantagedStudentEnrollment->approval_status = "Pending";

        $disadvantagedStudentEnrollment->save();

        return redirect("/enrollment/economically-disadvantaged")->with('primary', 'Successfully Updated');
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
        $item = DisadvantagedStudentEnrollment::find($id);
        $item->delete();
        return redirect('/enrollment/economically-disadvantaged')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $enrollment = DisadvantagedStudentEnrollment::find($id);
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $enrollment->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->disadvantagedStudentEnrollments);
                        }
                    }
                }
            }
        }
        return redirect("/enrollment/economically-disadvantaged?department=" . $selectedDepartment)->with('primary', 'Success');
    }
}
