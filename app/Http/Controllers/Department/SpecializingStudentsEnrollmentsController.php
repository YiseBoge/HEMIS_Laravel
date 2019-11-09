<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\SpecializingStudentsEnrollment;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedType = $request->input('student_type');
        if ($requestedType == null) {
            $requestedType = 'Current';
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedSpecializationType = $request->input('specialization_type');
        if ($requestedSpecializationType == null) {
            $requestedSpecializationType = 'Specialization';
        }

        $requestedYearLevel = $request->input('year_level');
        if ($requestedYearLevel == null) {
            $requestedYearLevel = '1';
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
                                        foreach ($department->specializingStudentEnrollments as $enrollment) {
                                            $enrollments[] = $enrollment;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "Specialization" && $college->education_program == $requestedProgram) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->specializingStudentEnrollments as $enrollment) {
                                            if ($enrollment->student_type == $requestedType && $enrollment->specialization_type == $requestedSpecializationType) {
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
        } else {
            $enrollments = SpecializingStudentsEnrollment::with('department')->get();
        }


        $educationPrograms = College::getEnum("EducationPrograms");
        array_pop($educationPrograms);

        $data = array(
            'enrollments' => $enrollments,
            'departments' => $collegeDeps,
            'programs' => $educationPrograms,
            'specialization_types' => SpecializingStudentsEnrollment::getEnum("SpecializationTypes"),
            'student_types' => SpecializingStudentsEnrollment::getEnum('StudentTypes'),

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
            'bands' => BandName::all(),
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
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
        ]);

        $enrollment = new SpecializingStudentsEnrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->student_type = $request->input('student_type');
        $enrollment->specialization_type = $request->input('specialization_type');
        $enrollment->field_of_specialization = $request->input('field_of_specialization');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

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
            'education_level' => "Specialization", 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "Specialization";
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

        $specializingStudentsEnrollment = SpecializingStudentsEnrollment::find($id);
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
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $specializingStudentsEnrollment = SpecializingStudentsEnrollment::find($id);

        $specializingStudentsEnrollment->male_students_number = $request->input('male_number');
        $specializingStudentsEnrollment->female_students_number = $request->input('female_number');

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
        $item = SpecializingStudentsEnrollment::find($id);
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
            $enrollment = SpecializingStudentsEnrollment::find($id);
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
                                        ApprovalService::approveData($department->specializingStudentEnrollments);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/enrollment/specializing-students?department=" . $selectedDepartment)->with('primary', 'Success');
    }
}
