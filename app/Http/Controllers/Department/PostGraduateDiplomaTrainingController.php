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
use App\Models\Institution\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostGraduateDiplomaTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution();

        $requestedType=$request->input('type');
        if($requestedType==null){
            $requestedType='Normal';
        }

        $requestedProgram=$request->input('program');
        if($requestedProgram==null){
            $requestedProgram='Regular';
        }

        $requestedCollege=$request->input('college');
        if($requestedCollege==null){
            $requestedCollege=null;
        }

        $requestedLevel=$request->input('education_level');
        if($requestedLevel==null){
            $requestedLevel='Undergraduate';
        }


        $requestedBand=$request->input('band');
        if($requestedBand==null){
            $requestedBand=null;
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
                        if($college->collegeName->college_name == $requestedCollege && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram){
                            
                            foreach($college->departments as $department){
                                if($department->year_level == $requestedYearLevel){
                                    foreach($department->enrollments as $enrollment){
                                        if($enrollment->student_type==$requestedType){
                                            $enrollments[]=$enrollment;
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
            'student_types' => Enrollment::getEnum('StudentTypes'),
            'year_levels' => Department::getEnum('YearLevels'),
            'page_name' => 'enrollment.normal.index'
        );
        return view("departments.postgraduate_diploma_training.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
