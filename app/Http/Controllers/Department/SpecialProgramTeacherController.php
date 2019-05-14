<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\SpecialProgramTeacher;
use App\Models\Institution\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SpecialProgramTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestedType=$request->input('program_type');
        if($requestedType==null){
            $requestedType='ELIP';
        }

        $requestedStatus=$request->input('program_status');
        if($requestedStatus==null){
            $requestedStatus='COMPLETED';
        }

        $requestedCollege=$request->input('college_names');
        if($requestedCollege==null){
            $requestedCollege=CollegeName::all()->first()->id;
        }

        $requestedBand=$request->input('band_names');
        if($requestedBand==null){
            $requestedBand=BandName::all()->first()->id;
        }

        //return $requestedType;

        $band=Band::where('band_name_id',$requestedBand)->first();
        $college=College::where(['college_name_id'=>$requestedCollege,'band_id'=>$band->id])->first();
        $departments=Department::where(['college_id'=>$college->id])->get();
        $filteredTeachers = array();

        foreach ($departments as $department){

            foreach ($department->SpecialProgramTeachers as $teacher){
                if($teacher->program_type==$requestedType && $teacher->program_status==$requestedStatus){
                    $filteredTeachers[]=$teacher;
                }
            }
        }


        //$specialProgramTeachers=SpecialProgramTeacher::all();
        //$specialProgramTeachers= SpecialProgramTeacher::where(['program_type'=>$requestedType,'program_status'=>$requestedStatus])->get();
        $data=[
            'program_type'=>$requestedType,
            'program_status'=>$requestedStatus,
            'special_program_teachers'=>$filteredTeachers,
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'page_name'=>'departments.special-program-teacher.index'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.special_program_teacher.index')->with('data',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'program_type'=>SpecialProgramTeacher::getEnum("ProgramTypes"),
            'program_status'=>SpecialProgramTeacher::getEnum("ProgramStats"),
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'departments'=>DepartmentName::all(),
            'page_name'=>'departments.special-program-teacher.create'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.special_program_teacher.create')->with('data',$data);
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



        $specialProgramTeacher=new SpecialProgramTeacher;
        $specialProgramTeacher->male_number= $request->input('male_number');
        $specialProgramTeacher->female_number= $request->input('female_number');
        $specialProgramTeacher->program_status=$request->input('program_status');
        $specialProgramTeacher->program_type=$request->input('program_type');

        //return $specialProgramTeacher->program_type;

        $user = Auth::user();
        $institution = Institution::where('id', $user->institution_id)->first();

        $bandName = BandName::where('id', $request->input("band_names"))->first();
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if($band == null){
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = CollegeName::where('id', $request->input("college_names"))->first();
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id])->first();
        if($college == null){
            $college = new College;
            $college->education_level = 'NONE';
            $college->education_program = 'NONE';
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = DepartmentName::where('id', $request->input("department"))->first();
        $department = Department::where(['department_name_id' => $departmentName->id,'college_id' => $college->id])->first();
        if($department == null){
            $department = new Department;
            $department->year_level ='NONE';
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->specialProgramTeachers()->save($specialProgramTeacher);

        return redirect("/department/special-program-teacher");


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
