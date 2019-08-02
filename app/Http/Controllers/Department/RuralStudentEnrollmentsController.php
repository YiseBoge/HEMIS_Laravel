<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\Enrollment;
use App\Models\Department\RuralStudentEnrollment;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RuralStudentEnrollmentsController extends Controller
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

        $requestedRegion = $request->input('region');
        if ($requestedRegion == null) {
            $requestedRegion = 'Rural';
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
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
                                        foreach ($department->ruralStudentEnrollments as $enrollment) {
                                            $enrollments[] = $enrollment;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->ruralStudentEnrollments as $enrollment) {
                                            if ($enrollment->region == $requestedRegion) {
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
            $enrollments = Enrollment::with('department')->get();
        }

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'enrollments' => $enrollments,
            'departments' => DepartmentName::all(),
            'programs' => College::getEnum("EducationPrograms"),
            'education_levels' => College::getEnum("EducationLevels"),
            'regions' => RuralStudentEnrollment::getEnum('Regions'),

            'selected_department' => $requestedDepartment,
            'selected_region' => $requestedRegion,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            'page_name' => 'enrollment.rural_students.index'
        );
        //return $filteredEnrollments;
        return view("enrollment.rural_students.index")->with($data);
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
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'regions' => RuralStudentEnrollment::getEnum('Regions'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.rural_students.create'
        );
        return view("enrollment.rural_students.create")->with($data);
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
            'male_number' => 'required',
            'female_number' => 'required'
        ]);

        $enrollment = new RuralStudentEnrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->region = $request->input('region');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
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
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->ruralStudentEnrollments()->save($enrollment);

        return redirect("/enrollment/rural-area-students")->with('success', 'Successfully Added Rural Area Enrollment');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/enrollment/rural-area-students");
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

        $ruralStudenetEnrollment = RuralStudentEnrollment::find($id);
        $department = $ruralStudenetEnrollment->department()->first();
        $college = $department->college()->first();

        $data = array(
            'id' => $ruralStudenetEnrollment->id,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'region' => $ruralStudenetEnrollment->region,
            'male_students_number' => $ruralStudenetEnrollment->male_students_number,
            'female_students_number' => $ruralStudenetEnrollment->female_students_number,
            'year_level' => $department->year_level,
            'page_name' => 'enrollment.rural_students.edit'
        );
        return view("enrollment.rural_students.edit")->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $ruralStudenetEnrollment = RuralStudentEnrollment::find($id);
        $ruralStudenetEnrollment->male_students_number = $request->input("male_number");
        $ruralStudenetEnrollment->female_students_number = $request->input("female_number");

        $ruralStudenetEnrollment->save();

        return redirect("/enrollment/rural-area-students");


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
        $item = RuralStudentEnrollment::find($id);
        $item->delete();
        return redirect('/enrollment/rural-area-students');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        $enrollment = RuralStudentEnrollment::find($id);
        if ($action == "approve") {
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $enrollment->save();
        } elseif ($action == "disapprove") {
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
                                        foreach ($department->ruralStudentEnrollments as $enrollment) {
                                            if ($enrollment->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                                                $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $enrollment->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/enrollment/rural-area-students?department=" . $selectedDepartment)->with('primary', 'Success');
    }
}
