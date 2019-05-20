<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\Teacher;
use App\Models\Institution\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
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

        $teachers = array();

        if($institution!=null){
            foreach($institution->bands as $band){
                if($band->bandName->band_name == $requestedBand){
                    foreach($band->colleges as $college){
                        if($college->collegeName->college_name == $requestedCollege && $college->education_level == "None" && $college->education_program == "None"){
                            foreach($college->departments as $department){
                                if($department->year_level == "None"){
                                    return $department;
                                    foreach($department->teachers as $teacher){
                                        if($teacher->level_of_education==$requestedLevel){
                                            $teachers[]=$teacher;
                                        }
                                    }
                                }                                
                            }
                        }
                    }
                }
            }
        } else {
            $teachers = Teacher::with('department')->get();
        }

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'teachers' => $teachers,
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'education_levels' => Teacher::getEnum("EducationLevels"),
            'page_name' => 'departments.teachers.index'
        );
        //return $filteredEnrollments;
        return view("departments.teachers.index")->with($data);
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
            'education_levels' => Teacher::getEnum("EducationLevels"),
            'page_name' => 'departments.teachers.create'
        );
        return view('departments.teachers.create')->with($data);
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
            'female_number' => 'required',
            'citizenship' => 'required'
        ]);

        $teacher = new Teacher;
        $teacher->male_number = $request->input('male_number');
        $teacher->female_number = $request->input('female_number');
        $teacher->level_of_education = $request->input('education_level');
        $teacher->citizenship = $request->input('citizenship');
        

        $user = Auth::user();

        $institution = $user->institution();

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
            'education_level' => "None", 'education_program' => "None"])->first();
        if($college == null){
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = DepartmentName::where('department_name', $request->input("department"))->first();
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if($department == null){
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->teachers()->save($teacher);

        return redirect("/department/teachers");

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
