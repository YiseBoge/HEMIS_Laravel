<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\AgeEnrollment;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AgeEnrollmentsController extends Controller
{
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

        $ageEnrollments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                            foreach ($college->departments as $department) {
                                if ($user->hasRole('College Super Admin')) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->ageEnrollments as $ageEnrollment) {
                                            $ageEnrollments[] = $ageEnrollment;
                                        }
                                    }
                                } else {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->ageEnrollments as $ageEnrollment) {
                                            $ageEnrollments[] = $ageEnrollment;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        } else {
            $ageEnrollments = AgeEnrollment::all();
        }

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);

        $data = ['enrollment_info' => $ageEnrollments,
            'departments' => DepartmentName::all(),
            'age_range' => AgeEnrollment::getEnum('Ages'),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => Department::getEnum('YearLevels'),

            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,
            'page_name' => 'enrollment.age_enrollment.index'];

        return view('enrollment.age_enrollment.index')->with($data);
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

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $year_levels = Department::getEnum('YearLevels');
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);

        $data = ['enrollment_info' => AgeEnrollment::all(),
            'age_range' => AgeEnrollment::getEnum('Ages'),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,
            'page_name' => 'enrollment.age_enrollment.create'];
        return view('enrollment.age_enrollment.create')->with($data);
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
            'number_of_males' => 'required',
            'number_of_females' => 'required',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $age_enrollment = new AgeEnrollment();
        $age_enrollment->male_students_number = $request->input('number_of_males');
        $age_enrollment->female_students_number = $request->input('number_of_females');

        $age_enrollment->age = $request->input('age_range');

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

        $department->ageEnrollments()->save($age_enrollment);

        return redirect('enrollment/age-enrollment');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
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

        $ageEnrollment = AgeEnrollment::find($id);
        $department = $ageEnrollment->department()->first();
        $college = $department->college()->first();

        $data = [
            'id' => $id,
            'age_range' => $ageEnrollment->age,
            'male_students_number' => $ageEnrollment->male_students_number,
            'female_students_number' => $ageEnrollment->female_students_number,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'year_level' => $department->year_level,
            'page_name' => 'enrollment.age_enrollment.edit'];
            
        return view('enrollment.age_enrollment.edit')->with($data);
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
        $user->authorizeRoles('Department Admin');

        $ageEnrollment = AgeEnrollment::find($id);

        $ageEnrollment->male_students_number = $request->input("number_of_males");
        $ageEnrollment->female_students_number = $request->input("number_of_females");

        $ageEnrollment->save();

        return redirect('enrollment/age-enrollment');
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
        $item = AgeEnrollment::find($id);
        $item->delete();
        return redirect('/enrollment/age-enrollment');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        $enrollment = AgeEnrollment::find($id);
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
                                        foreach ($department->ageEnrollments as $enrollment) {
                                            if($enrollment->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]){
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
        return redirect("/enrollment/age-enrollment?department=" . $selectedDepartment);
    }

}
