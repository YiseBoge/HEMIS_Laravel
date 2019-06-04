<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\StaffLeave;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StaffLeaveController extends Controller
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

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'MASTERS';
        }

        $requestedPlace = $request->input('study_place');
        if ($requestedPlace == null) {
            $requestedPlace = 'ETHIOPIA';
        }

        $requestedCollege = $request->input('college_names');
        if ($requestedCollege == null) {
            $requestedCollege = CollegeName::all()->first()->id;
        }

        $requestedBand = $request->input('band_names');
        if ($requestedBand == null) {
            $requestedBand = BandName::all()->first()->id;
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
                                foreach ($department->staffLeaves as $staff) {
                                    if (strtoupper($staff->place_of_study) == $requestedPlace && strtoupper($staff->level_of_study) == $requestedLevel) {
                                        $filteredTeachers[] = $staff;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $filteredTeachers = StaffLeave::with('department')->get();
        }


        //$specialProgramTeachers=SpecialProgramTeacher::all();
        //$specialProgramTeachers= SpecialProgramTeacher::where(['program_type'=>$requestedType,'program_status'=>$requestedStatus])->get();
        $data = [
            'education_level' => $requestedLevel,
            'study_place' => $requestedPlace,
            'upgrading_staff' => $filteredTeachers,
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            
            'selected_college' => $requestedCollege,
            'selected_level' => $requestedLevel,
            'selected_place' => $requestedPlace,
            'selected_band' => $requestedBand,
            'page_name' => 'departments.staff-leave.index'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.staff_leave.index')->with('data', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'education_level' => StaffLeave::getEnum("LevelOfStudies"),
            'study_place' => StaffLeave::getEnum("PlaceOfStudies"),
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'departments.staff-leave.create'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.staff_leave.create')->with('data', $data);
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


        $staffLeave = new staffLeave();
        $staffLeave->number_of_male_students = $request->input('male_number');
        $staffLeave->number_of_female_students = $request->input('female_number');
        $staffLeave->level_of_study = $request->input('education_level');
        $staffLeave->place_of_study = $request->input('study_place');


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
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'NONE';
            $college->education_program = 'NONE';
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = 'NONE';
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->staffLeaves()->save($staffLeave);

        return redirect("/department/staff-leave");


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
