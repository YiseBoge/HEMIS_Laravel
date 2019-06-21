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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpecialProgramTeacherController extends Controller
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

        $requestedStatus=$request->input('program_status');
        if($requestedStatus==null){
            $requestedStatus='Completed';
        }

//        $band=Band::where('band_name_id',$requestedBand)->first();
//        $college=College::where(['college_name_id'=>$requestedCollege,'band_id'=>$band->id])->first();
//        $departments=Department::where(['college_id'=>$college->id])->get();
        $filteredTeachers = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->id == $user->bandName->id) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->id == $user->collegeName->id) {
                            foreach ($college->departments as $department) {
                                if($department->departmentName->id == $user->departmentName->id){
                                    foreach ($department->SpecialProgramTeachers as $teacher) {
                                        if ($teacher->program_stat == $requestedStatus) {
                                            $filteredTeachers[] = $teacher;
                                        }
                                    }
                                }                                
                            }
                        }
                    }
                }
            }
        } else {
            $filteredTeachers = SpecialProgramTeacher::with('department')->get();
        }



        //$specialProgramTeachers=SpecialProgramTeacher::all();
        //$specialProgramTeachers= SpecialProgramTeacher::where(['program_type'=>$requestedType,'program_status'=>$requestedStatus])->get();
        $data=[
            'program_status'=>$requestedStatus,
            'special_program_teachers'=>$filteredTeachers,

            'selected_status' => $requestedStatus,

            'page_name' => 'staff.special-program-teacher.index'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.special_program_teacher.index')->with($data);

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

        $data=[
            'program_type'=>SpecialProgramTeacher::getEnum("ProgramTypes"),
            'program_status'=>SpecialProgramTeacher::getEnum("ProgramStats"),
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'departments'=>DepartmentName::all(),
            'page_name' => 'staff.special-program-teacher.create'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.special_program_teacher.create')->with($data);
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



        $specialProgramTeacher=new SpecialProgramTeacher;
        $specialProgramTeacher->male_number= $request->input('male_number');
        $specialProgramTeacher->female_number= $request->input('female_number');
        $specialProgramTeacher->program_stat = $request->input('program_status');
        $specialProgramTeacher->program_type=$request->input('program_type');



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
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id])->first();
        if($college == null){
            $college = new College;
            $college->education_level = 'NONE';
            $college->education_program = 'NONE';
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
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
}
