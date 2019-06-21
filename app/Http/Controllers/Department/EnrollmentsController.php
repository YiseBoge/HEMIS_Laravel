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
use App\Services\GeneralReportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EnrollmentsController extends Controller
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $requestedType=$request->input('student_type');
        if($requestedType==null){
            $requestedType='Normal';
        }

        $requestedProgram=$request->input('program');
        if($requestedProgram==null){
            $requestedProgram='Regular';
        }

        $requestedLevel=$request->input('education_level');
        if($requestedLevel==null){
            $requestedLevel='Undergraduate';
        }

        $enrollments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->department_name == $user->departmentName->department_name) {                                                                      
                                    foreach ($department->enrollments as $enrollment) {
                                        if ($enrollment->student_type == $requestedType) {
                                            if ($department->year_level == 1) {
                                                $service = new GeneralReportService("2018/19");
                                                return $service->nonAcademicAttrition();
                                            } 
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

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);

        $data = array(
            'enrollments' => $enrollments,
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'student_types' => Enrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),

            'selected_student_type' => $requestedType,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            'page_name' => 'enrollment.normal.index'
        );
        //return $filteredEnrollments;
        return view("enrollment.normal.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $year_levels = Department::getEnum('YearLevels');
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);

        $data = array(
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'student_types' => Enrollment::getEnum('StudentTypes'),
            'year_levels' => $year_levels,
            'page_name' => 'enrollment.normal.create'
        );
        return view('enrollment.normal.create')->with($data);
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

        $enrollment = new Enrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->student_type = $request->input('student_type');

        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if($band == null){
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if($college == null){
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
        if($department == null){
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->enrollments()->save($enrollment);

        return redirect("/enrollment/normal");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function viewChart(Request $request){

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $requestedType=$request->input('student_type');
        if($requestedType==null){
            $requestedType='Normal';
        }

        $requestedProgram=$request->input('program');
        if($requestedProgram==null){
            $requestedProgram='Regular';
        }

        $requestedCollege=$request->input('college');
        if($requestedCollege==null){
            $requestedCollege = CollegeName::get()->first()->college_name;
        }

        $requestedLevel=$request->input('education_level');
        if($requestedLevel==null){
            $requestedLevel='Undergraduate';
        }


        $requestedBand=$request->input('band');
        if($requestedBand==null){
            $requestedBand = BandName::get()->first()->band_name;
        }

        $requestedDepartment=$request->input('department');
        if($requestedDepartment==null){
            $requestedDepartment=DepartmentName::get()->first()->department_name;
        }

        $enrollments = array();

        /*if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $requestedCollege && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {

                            foreach ($college->departments as $department) {
                                if ($department->year_level == $requestedYearLevel) {
                                    foreach ($department->enrollments as $enrollment) {
                                        if ($enrollment->student_type == $requestedType) {
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
        }*/

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'programs' => College::getEnum("EducationPrograms"),
            'education_levels' => College::getEnum("EducationLevels"),
            'student_types' => Enrollment::getEnum('StudentTypes'),
            'departments' => DepartmentName::all(),

            'selected_student_type' => $requestedType,
            'selected_program' => $requestedProgram,
            'selected_college' => $requestedCollege,
            'selected_education_level' => $requestedLevel,
            'selected_band' => $requestedBand,
            'selected_department' => $requestedDepartment,

            'page_name' => 'enrollment.normal.index'
        );
        //return $filteredEnrollments;
        return view("enrollment.normal.chart")->with($data);
    }

    public function chart(Request $request){

        $user = Auth::user();
        $institution = $user->institution();

        $requestedType=$request->input('student_type');
        if($requestedType==null){
            $requestedType='Normal';
        }

        $requestedProgram=$request->input('program');
        if($requestedProgram==null){
            $requestedProgram='Regular';
        }

        $requestedCollege=$request->input('college');
        if($requestedCollege==null){
            $requestedCollege = CollegeName::get()->first()->college_name;
        }

        $requestedLevel=$request->input('education_level');
        if($requestedLevel==null){
            $requestedLevel='Undergraduate';
        }


        $requestedBand=$request->input('band');
        if($requestedBand==null){
            $requestedBand = BandName::get()->first()->band_name;
        }

        $requestedDepartment=$request->input('department');
        if($requestedDepartment==null){
            $requestedDepartment=DepartmentName::get()->first()->department_name;
        }

        $year_levels = array();
        foreach(Department::getEnum('YearLevels') as $key => $value){
            $year_levels[] = $value;
        }
        array_pop($year_levels);

        $enrollments = array();

        foreach($year_levels as $year){
            $yearEnrollment = 0;
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $requestedCollege && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->department_name == $requestedDepartment && $department->year_level == $year) {
                                    foreach ($department->enrollments as $enrollment) {
                                        if ($enrollment->student_type == $requestedType) {
                                            $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
                                            
                                        }
                                    }
                                }                                
                            }
                           
                        }
                    }
                }
                
            }
           
            $enrollments[] = $yearEnrollment;
            //return $enrollments;
            
        }

        
        
        $result = array(
            "year_levels" => $year_levels,
            "enrollments" => $enrollments
        );
        return response()->json($result);
    }
}
