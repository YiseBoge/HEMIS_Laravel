<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Band\BandName;
use App\Models\Department\DepartmentName;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Institution\Institution;
use App\Models\Department\SpecializingStudentsEnrollment;
use Illuminate\Support\Facades\Auth;

class SpecializingStudentsEnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'enrollments' => SpecializingStudentsEnrollment::info()->get(),
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => College::getEnum("EducationPrograms"),
            'specialization_types' => SpecializingStudentsEnrollment::getEnum("SpecializationTypes"),
            'student_types' => SpecializingStudentsEnrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.specializing_student_enrollment.create'
        );
        return view("enrollment.specializing_student_enrollment.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => College::getEnum("EducationPrograms"),
            'specialization_types' => SpecializingStudentsEnrollment::getEnum("SpecializationTypes"),
            'student_types' => SpecializingStudentsEnrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.specializing_student_enrollment.create'
        );
        return view('enrollment.specializing_student_enrollment.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'male_number' => 'required',
            'female_number' => 'required'
        ]);

        $enrollment = new SpecializingStudentsEnrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->student_type = $request->input('student_type');
        $enrollment->specialization_type = $request->input('specialization_type');
        $enrollment->field_of_specialization = $request->input('field_of_specialization');

        $user = Auth::user();

        $institution = Institution::where('id', $user->institution_id)->first();

        $bandName = BandName::where('band_name', $request->input("band"))->first();
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if($band == null){
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);            
            $bandName->band()->save($band);
        }

        $collegeName = CollegeName::where('college_name', $request->input("college"))->first();
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if($college == null){
            $college = new College;
            $college->education_level = "Specialization";
            $college->education_program = $request->input("program");
            $college->college_name_id = 0;
            $band->colleges()->save($college);           
            $collegeName->college()->save($college);
        }

        $departmentName = DepartmentName::where('department_name', $request->input("department"))->first();
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'college_id' => $college->id])->first();
        if($department == null){
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = 0;             
            $college->departments()->save($department);            
            $departmentName->department()->save($department);                      
        }

        $department->enrollments()->save($enrollment);

        return redirect("/enrollment/specializing-student");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
