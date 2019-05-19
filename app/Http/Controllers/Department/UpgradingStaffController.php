<?php

namespace App\Http\Controllers\Department;

use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\UpgradingStaff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UpgradingStaffController extends Controller
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

        $requestedLevel=$request->input('education_level');
        if($requestedLevel==null){
            $requestedLevel='MASTERS';
        }

        $requestedPlace=$request->input('study_place');
        if($requestedPlace==null){
            $requestedPlace='ETHIOPIA';
        }

        $requestedCollege=$request->input('college_names');
        if($requestedCollege==null){
            $requestedCollege=CollegeName::all()->first()->id;
        }

        $requestedBand=$request->input('band_names');
        if($requestedBand==null){
            $requestedBand=BandName::all()->first()->id;
        }


//        $band=Band::where('band_name_id',$requestedBand)->first();
//        $college=College::where(['college_name_id'=>$requestedCollege,'band_id'=>$band->id])->first();
//        $departments=Department::where(['college_id'=>$college->id])->get();
        $filteredTeachers = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->id == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->id == $requestedCollege) {
                            foreach ($college->departments as $department) {
                                foreach ($department->UpgradingStaffs as $staff){
                                    if(strtoupper($staff->study_place)==$requestedPlace && strtoupper($staff->education_level)==$requestedLevel){
                                        $filteredTeachers[]=$staff;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $filteredTeachers = UpgradingStaff::with('department')->get();
        }



        //$specialProgramTeachers=SpecialProgramTeacher::all();
        //$specialProgramTeachers= SpecialProgramTeacher::where(['program_type'=>$requestedType,'program_status'=>$requestedStatus])->get();
        $data=[
            'education_level'=>$requestedLevel,
            'study_place'=>$requestedPlace,
            'upgrading_staff'=>$filteredTeachers,
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'page_name'=>'departments.upgrading-staff.index'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.upgrading_staff.index')->with('data',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'education_level'=>UpgradingStaff::getEnum("EducationLevels"),
            'study_place'=>UpgradingStaff::getEnum("StudyPlaces"),
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'departments'=>DepartmentName::all(),
            'page_name'=>'departments.upgrading-staff.create'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.upgrading_staff.create')->with('data',$data);
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



        $upgradingStaff=new UpgradingStaff();
        $upgradingStaff->male_number= $request->input('male_number');
        $upgradingStaff->female_number= $request->input('female_number');
        $upgradingStaff->education_level=$request->input('education_level');
        $upgradingStaff->study_place=$request->input('study_place');



        $user = Auth::user();
        $institution = $user->institution();

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

        $department->upgradingStaffs()->save($upgradingStaff);

        return redirect("/department/upgrading-staff");


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
