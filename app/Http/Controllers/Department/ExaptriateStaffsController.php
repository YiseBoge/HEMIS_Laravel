<?php


namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\AcademicStaff;
use App\Models\Department\ExpatriateStaff;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExaptriateStaffsController extends Controller
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

        $requestedLevel=$request->input('rank_level');
        if($requestedLevel==null){
            $requestedLevel='GRADUATE ASSISTANT I';
        }

        $requestedCollege=$request->input('college_names');
        if($requestedCollege==null){
            $requestedCollege=CollegeName::all()->first()->id;
        }

        $requestedBand=$request->input('band_names');
        if($requestedBand==null){
            $requestedBand=BandName::all()->first()->id;
        }

        $filteredExpatriates = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->id == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->id == $requestedCollege) {
                            foreach ($college->departments as $department) {
                                foreach ($department->academicStaffs as $staff){
                                    if(strtoupper($staff->staff_rank)==$requestedLevel){
                                        $filteredExpatriates[]=$staff;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $filteredExpatriates = AcademicStaff::with('department')->get();
        }

        $data=[
            'rank_level'=>$requestedLevel,
            'expatriate_staff'=>$filteredExpatriates,
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'page_name'=>'departments.expatriate_staff.index'
        ];

        return view('departments.expatriate_staff.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'rank_level'=>'Professor',
            'expatriate_staff' => [],
            'staff_rank'=> ExpatriateStaff::getEnum('StaffRank'),
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'page_name'=>'departments.expatriate_staff.create'
        ];

        return view('departments.expatriate_staff.create')->with('data',$data);
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
            'number_of_females' => 'required',
            'number_of_females' => 'required'
        ]);



        $academicStaff=new AcademicStaff();
        $academicStaff->male_number= $request->input('number_of_females');
        $academicStaff->female_number= $request->input('number_of_females');
        $academicStaff->staff_rank=$request->input('staff_rank');




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

        $department->academicStaffs()->save($academicStaff);

        return redirect("/department/academic-staff");
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
