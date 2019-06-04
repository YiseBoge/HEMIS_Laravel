<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\AcademicStaff;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AcademicStaffController extends Controller
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

        $requestedLevel = $request->input('rank_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'GRADUATE ASSISTANT I';
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
                                foreach ($department->academicStaffs as $staff) {
                                    if (strtoupper($staff->staff_rank) == $requestedLevel) {
                                        $filteredTeachers[] = $staff;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $filteredTeachers = AcademicStaff::with('department')->get();
        }


        //$specialProgramTeachers=SpecialProgramTeacher::all();
        //$specialProgramTeachers= SpecialProgramTeacher::where(['program_type'=>$requestedType,'program_status'=>$requestedStatus])->get();
        $data = [
            'rank_level' => $requestedLevel,
            'upgrading_staff' => $filteredTeachers,
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'page_name' => 'departments.academic-staff.index',

            "selected_level" => $requestedLevel,
            "selected_band" => $requestedBand,
            "selected_college" => $requestedCollege
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.academic_staff.index')->with('data', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'rank_level' => AcademicStaff::getEnum("StaffRanks"),
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'departments.academic-staff.create'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.academic_staff.create')->with('data', $data);
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


        $academicStaff = new AcademicStaff();
        $academicStaff->male_number = $request->input('male_number');
        $academicStaff->female_number = $request->input('female_number');
        $academicStaff->staff_rank = $request->input('rank_level');


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

        $department->academicStaffs()->save($academicStaff);

        return redirect("/department/academic-staff");
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
