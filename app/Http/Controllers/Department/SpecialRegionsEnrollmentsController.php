<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\SpecialRegionEnrollment;
use App\Models\Institution\Institution;
use App\Models\Institution\RegionName;
use App\Services\ApprovalService;
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();
        $collegeDeps = $user->collegeName->departmentNames;

        $selectedStudentType = $request->input('student_type');
        if ($selectedStudentType == null) {
            $requestedStudentType = 'Normal';
        } else {
            $requestedStudentType = SpecialRegionEnrollment::getEnum('student_type')[$selectedStudentType];
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedYearLevel = $request->input('year_level');
        if ($requestedYearLevel == null) {
            $requestedYearLevel = '1';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }

        $requestedType = $request->input('region_type');
        if ($requestedType == null) {
            $requestedType = 'Emerging Regions';
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->id;
        }

        $enrollments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->specialRegionEnrollments as $enrollment) {
                                            $enrollments[] = $enrollment;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->specialRegionEnrollments as $enrollment) {
                                            if ($enrollment->region_type == $requestedType) {
                                                if ($enrollment->student_type == $requestedStudentType) {
                                                    $enrollments[] = $enrollment;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $enrollments = SpecialRegionEnrollment::all();
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

        $enrollment = new SpecialRegionEnrollment;

        $enrollment->male_number = $request->input('male_number');
        $enrollment->female_number = $request->input('female_number');
        $enrollment->region_type = $request->input('region_type');
        $enrollment->student_type = $request->input('student_type');
        $enrollment->region_name_id = null;

        $regionName = RegionName::where('name', $request->input("region"))->first();

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
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = $request->input("education_level");
            $college->education_program = $request->input("program");
            $college->college_name_id = null;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => Department::getEnum('year_level')[$request->input("year_level")],
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = null;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

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

        $specialRegionEnorllment = SpecialRegionEnrollment::find($id);
        $specialRegionEnorllment->male_number = $request->input("male_number");
        $specialRegionEnorllment->female_number = $request->input("female_number");

        $specialRegionEnorllment->save();
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

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        ApprovalService::approveData($department->specialRegionEnrollments);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/enrollment/special-region-students?department=" . $selectedDepartment)->with('primary', 'Success');
    }
}
