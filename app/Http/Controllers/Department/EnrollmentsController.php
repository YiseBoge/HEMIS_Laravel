<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Band\BandName;
use App\Models\Department\DepartmentName;
use App\Models\Institution\Institution;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
            $requestedCollege=CollegeName::all()->first()->id;
        }

        $requestedLevel=$request->input('education_level');
        if($requestedLevel==null){
            $requestedLevel='Undergraduate';
        }


        $requestedBand=$request->input('band');
        if($requestedBand==null){
            $requestedBand=BandName::all()->first()->id;
        }

        $requestedYearLevel=$request->input('year_level');
        if($requestedYearLevel==null){
            $requestedYearLevel='1';
        }

        $enrollments = array();

        if($institution!=null){
            foreach($institution->bands as $band){
                if($band->bandName->band_name == $requestedBand){
                    foreach($band->colleges as $college){
                        if($college->collegeName->college_name == $requestedCollege){
                            foreach($college->deparments as $department){
                                foreach($department->enrollments as $enrollment){
                                    $enrollments[]=$enrollment;
                                }
                            }
                        }
                    }
                }
            } 
        }else{
            $enrollments = Enrollment::with('department')->get();
        }

        $studentTypes=Enrollment::getEnum('StudentTypes');
        $educationPrograms=College::getEnum('EducationPrograms');
        $colleges=CollegeName::all();
        $bands=BandName::all();
        $educationLevels=College::getEnum("EducationLevels");
        $yearLevels=Department::getEnum('YearLevels');

        //return $requestedBand;

        $filteredEnrollments = array();


        $bandNameId=BandName::where('band_name',$requestedBand)->first();

        $collegeNameId=CollegeName::where('college_name',$requestedCollege)->first();
        $band = $institution->bands()->where('band_name_id',$requestedBand)->first();
        $band=Band::where('band_name_id',$requestedBand)->first();
        //return $band;
        if($band!=null){
            $college=College::where(['college_name_id'=>$requestedCollege,'band_id'=>$band->id,'education_level'=>$requestedLevel,'education_program'=>$requestedProgram])->first();
            if($college!=null){
                $departments=Department::where(['college_id'=>$college->id,'year_level'=>$requestedYearLevel])->get();
                foreach ($departments as $department){

                    foreach ($department->enrollments as $enrollment ){

                        if($enrollment->student_type==$requestedType){
                            $filteredEnrollments[]=$enrollment;
                        }

                    }

                }
            }




        }



        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'enrollments' => $filteredEnrollments,
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'student_types' => Enrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.normal.index'
        );
        //return $filteredEnrollments;
        return view("enrollment.normal.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
            'student_types' => Enrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.normal.create'
        );
        return view('enrollment.normal.create')->with($data);
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

        $enrollment = new Enrollment;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->student_type = $request->input('student_type');

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
            $college->education_level = $request->input("education_level");
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

        return redirect("/enrollment/normal");

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
