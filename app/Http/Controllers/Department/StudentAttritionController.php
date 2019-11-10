<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\StudentAttrition;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudentAttritionController extends Controller
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedStudentType = $request->input('student_type');
        if ($requestedStudentType == null) {
            $requestedStudentType = 'All';
        }

        $requestedType = $request->input('type');
        if ($requestedType == null) {
            $requestedType = 'CET';
        }

        $requestedCase = $request->input('case');
        if ($requestedCase == null) {
            $requestedCase = 'Academic Dismissals With Readmission';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }


        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = $collegeDeps->first()->id;
        }

        $attritions = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($user->hasRole('College Super Admin')) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name) {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->id == $requestedDepartment) {
                                    foreach ($department->studentAttritions as $attrition) {
                                        $attritions[] = $attrition;
                                    }
                                }
                            }
                        }
                    } else {
                        if ($college->education_program == $requestedProgram && $college->education_level == $requestedLevel) {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                    foreach ($department->studentAttritions as $attrition) {
                                        if ($attrition->type == $requestedType && $attrition->case == $requestedCase && $attrition->student_type == $requestedStudentType) {
                                            $attritions[] = $attrition;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
        } else {
            $attritions = StudentAttrition::with('band')->get();
        }

        $data = array(
            'attritions' => $attritions,
            'departments' => $collegeDeps,
            'programs' => College::getEnum('EducationPrograms'),
            'education_levels' => College::getEnum('EducationLevels'),
            'student_types' => StudentAttrition::getEnum('StudentTypes'),
            'types' => StudentAttrition::getEnum('Types'),
            'cases' => StudentAttrition::getEnum('Cases'),
            'page_name' => 'students.student_attrition.index',

            'selected_department' => $requestedDepartment,
            "selected_program" => $requestedProgram,
            "selected_level" => $requestedLevel,
            "selected_student_type" => $requestedStudentType,
            "selected_type" => $requestedType,
            "selected_case" => $requestedCase,
        );
        return view("departments.student_attrition.index")->with($data);
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
            'bands' => BandName::all(),
            'programs' => College::getEnum('EducationPrograms'),
            'education_levels' => College::getEnum('EducationLevels'),
            'years' => Department::getEnum('YearLevels'),
            'student_types' => StudentAttrition::getEnum('StudentTypes'),
            'types' => StudentAttrition::getEnum('Types'),
            'cases' => StudentAttrition::getEnum('Cases'),
            'page_name' => 'students.student_attrition.create'
        );
        return view("departments.student_attrition.create")->with($data);
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

        $attrition = new StudentAttrition;
        $attrition->student_type = $request->input('student_type');
        $attrition->type = $request->input('type');
        $attrition->case = $request->input('case');
        $attrition->male_students_number = $request->input('male_number');
        $attrition->female_students_number = $request->input('female_number');

        $user = Auth::user();
        if ($user == null) return redirect('/login');
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

        $attrition->department_id = $department->id;

        if ($attrition->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $attrition->save();

        return redirect("/student/student-attrition")->with('success', 'Successfully Added Attrition Information');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/student/student-attrition");
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

        $studentAttrition = StudentAttrition::find($id);
        $department = $studentAttrition->department()->first();
        $college = $department->college()->first();
        $data = array(
            'id' => $id,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'year_level' => $department->year_level,
            'student_type' => $studentAttrition->student_type,
            'type' => $studentAttrition->type,
            'case' => $studentAttrition->case,
            'male_students_number' => $studentAttrition->male_students_number,
            'female_students_number' => $studentAttrition->female_students_number,
            'page_name' => 'students.student_attrition.edit'
        );

        return view("departments.student_attrition.edit")->with($data);
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

        $studentAttrition = StudentAttrition::find($id);

        $studentAttrition->male_students_number = $request->input("male_number");
        $studentAttrition->female_students_number = $request->input("female_number");
        $studentAttrition->approval_status = "Pending";

        $studentAttrition->save();

        return redirect("/student/student-attrition")->with('primary', 'Successfully Updated');
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
        $item = StudentAttrition::find($id);
        $item->delete();
        return redirect('/student/student-attrition')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $attrition = StudentAttrition::find($id);
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
                                        ApprovalService::approveData($department->studentAttritions);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/student/student-attrition?department=" . $selectedDepartment)->with('primary', 'Success');
    }
}
