<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\OtherRegionStudent;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OtherRegionStudentsController extends Controller
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

        $enrollments = array();
        $total = 0;
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->otherRegionStudents as $enrollment){
                        $enrollments[] = $enrollment;
                        $total += $enrollment->male_students_number + $enrollment->female_students_number;
                    }
            } else
                if ($college->education_level == $requestedLevel && $college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->otherRegionStudents as $enrollment){
                            $enrollments[] = $enrollment;
                            $total += $enrollment->male_students_number + $enrollment->female_students_number;
                        }
        }

        $data = array(
            'enrollments' => $enrollments,
            'departments' => $collegeDeps,
            'programs' => College::getEnum("EducationPrograms"),
            'education_levels' => College::getEnum("EducationLevels"),
            'total' => $total,

            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            'page_name' => 'enrollment.other_region_students.index'
        );
        return view("enrollment.other_region_students.index")->with($data);
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
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.other_region_students.create'
        );
        return view('enrollment.other_region_students.create')->with($data);
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

        $enrollment = new OtherRegionStudent;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');

        $enrollment->department_id = $department->id;

        if ($enrollment->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $enrollment->save();

        return redirect("/enrollment/other-region-students")->with('success', 'Successfully Added Other Region Enrollment');
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
        return redirect("/enrollment/other-region-students");
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

        $otherRegionStudentsEnrollment = OtherRegionStudent::findOrFail($id)->first();
        $department = $otherRegionStudentsEnrollment->department()->first();
        $college = $department->college()->first();
        $data = array(
            'id' => $id,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'year_level' => $department->year_level,
            'male_students_number' => $otherRegionStudentsEnrollment->male_students_number,
            'female_students_number' => $otherRegionStudentsEnrollment->female_students_number,
            'page_name' => 'enrollment.other_region_students.edit'
        );
        return view('enrollment.other_region_students.edit')->with($data);
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

        $otherRegionStudentsEnrollment = OtherRegionStudent::findOrFail($id);

        $otherRegionStudentsEnrollment->male_students_number = $request->input("male_number");
        $otherRegionStudentsEnrollment->female_students_number = $request->input("female_number");
        $otherRegionStudentsEnrollment->approval_status = "Pending";

        $otherRegionStudentsEnrollment->save();

        return redirect("/enrollment/other-region-students")->with('primary', 'Successfully Updated');
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
        $item = OtherRegionStudent::findOrFail($id);
        $item->delete();
        return redirect('/enrollment/other-region-students')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $enrollment = OtherRegionStudent::findOrFail($id);
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $enrollment->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->otherRegionStudents);
                        }
                    }
                }
            }
        }
        return redirect("/enrollment/other-region-students?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
