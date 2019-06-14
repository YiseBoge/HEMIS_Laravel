<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\DisadvantagedStudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DisadvantagedStudentEnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $institution = $user->institution();

        $requestedQuintile = $request->input('quintile');
        if ($requestedQuintile == null) {
            $requestedQuintile = 'Lowest';
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }

        $requestedYearLevel = $request->input('year_level');
        if ($requestedYearLevel == null) {
            $requestedYearLevel = '1';
        }

        $enrollments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                            foreach ($college->departments as $department) {
                                if ($department->year_level == $requestedYearLevel) {

                                    foreach ($department->disadvantagedStudentEnrollments as $enrollment) {
                                        if ($enrollment->quintile == $requestedQuintile) {

                                            $enrollments[] = $enrollment;
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
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'programs' => College::getEnum("EducationPrograms"),
            'education_levels' => College::getEnum("EducationLevels"),
            'quintiles' => DisadvantagedStudentEnrollment::getEnum('Quintiles'),
            'year_levels' => Department::getEnum('YearLevels'),

            'selected_quintile' => $requestedQuintile,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,
            'selected_year' => $requestedYearLevel,

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
            'quintiles' => DisadvantagedStudentEnrollment::getEnum('Quintiles'),
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
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'male_number' => 'required',
            'female_number' => 'required'
        ]);

        $enrollment = new DisadvantagedStudentEnrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->quintile = $request->input('quintile');

        $user = Auth::user();

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

        $department->enrollments()->save($enrollment);

        return redirect("/enrollment/economically-disadvantaged-students");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
