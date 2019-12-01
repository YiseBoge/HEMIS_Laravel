<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\SpecialRegionEnrollment;
use App\Models\Institution\Institution;
use App\Models\Institution\RegionName;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpecialRegionsEnrollmentsController extends Controller
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
        $requestedYearLevel = request()->query('year_level', '1');
        $requestedType = request()->query('region_type', 'Emerging Regions');
        $requestedStudentType = SpecialRegionEnrollment::getEnum('student_type')[$selectedStudentType = request()->query('student_type', 'NORMAL')];

        $enrollments = array();
        $total = 0;
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->specialRegionEnrollments as $enrollment){
                        $enrollments[] = $enrollment;
                        $total += $enrollment->male_number + $enrollment->female_number;
                    }
            } else
                if ($college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->specialRegionEnrollments()->where('student_type', $requestedStudentType)->get() as $enrollment){
                            $enrollments[] = $enrollment;
                            $total += $enrollment->male_number + $enrollment->female_number;
                        }
        }

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $year_levels = Department::getEnum("YearLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);

        $data = array(
            'enrollments' => $enrollments,
            'types' => SpecialRegionEnrollment::getEnum("RegionTypes"),
            'student_types' => SpecialRegionEnrollment::getEnum('StudentTypes'),
            'departments' => $collegeDeps,
            'regions' => RegionName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,
            'total' => $total,

            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_year' => $requestedYearLevel,
            'selected_education_level' => $requestedLevel,
            'selected_type' => $requestedType,
            'selected_student_type' => $selectedStudentType,

            'page_name' => 'enrollment.special_region_students.index'
        );
        return view("enrollment.special_region_students.index")->with($data);
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
        $year_levels = Department::getEnum("YearLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);

        $data = array(
            'types' => SpecialRegionEnrollment::getEnum("RegionTypes"),
            'student_types' => SpecialRegionEnrollment::getEnum('StudentTypes'),
            'regions' => RegionName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,
            'page_name' => 'enrollment.special_region_students.create'
        );
        return view('enrollment.special_region_students.create')->with($data);
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
        $regionName = RegionName::where('name', $request->input("region"))->first();

        $enrollment = new SpecialRegionEnrollment;

        $enrollment->male_number = $request->input('male_number');
        $enrollment->female_number = $request->input('female_number');
        $enrollment->region_type = $request->input('region_type');
        $enrollment->student_type = $request->input('student_type');

        $enrollment->department_id = $department->id;
        $enrollment->region_name_id = $regionName->id;

        if ($enrollment->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $enrollment->save();

        return redirect("/enrollment/special-region-students")->with('success', 'Successfully Added Special Region Enrollment');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/enrollment/special-region-students");
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

        $specialRegionEnrollment = SpecialRegionEnrollment::find($id);
        $regionName = $specialRegionEnrollment->regionName()->first();
        $department = $specialRegionEnrollment->department()->first();
        $college = $department->college()->first();

        $data = array(
            'id' => $specialRegionEnrollment->id,
            'type' => $specialRegionEnrollment->region_type,
            'student_type' => $specialRegionEnrollment->student_type,
            'male_number' => $specialRegionEnrollment->male_number,
            'female_number' => $specialRegionEnrollment->female_number,
            'region' => $regionName,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'year_level' => $department->year_level,
            'page_name' => 'enrollment.special_region_students.edit'
        );
        return view('enrollment.special_region_students.edit')->with($data);
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

        $specialRegionEnrollment = SpecialRegionEnrollment::find($id);
        $specialRegionEnrollment->male_number = $request->input("male_number");
        $specialRegionEnrollment->female_number = $request->input("female_number");
        $specialRegionEnrollment->approval_status = "Pending";

        $specialRegionEnrollment->save();
        return redirect("/enrollment/special-region-students")->with('primary', 'Successfully Updated');
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
        $item = SpecialRegionEnrollment::find($id);
        $item->delete();
        return redirect('/enrollment/special-region-students')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $enrollment = SpecialRegionEnrollment::find($id);
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $enrollment->save();
        } else {

            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->specialRegionEnrollments);
                        }
                    }
                }
            }
        }
        return redirect("/enrollment/special-region-students?department=" . $selectedDepartment)->with('primary', 'Success');
    }
}
