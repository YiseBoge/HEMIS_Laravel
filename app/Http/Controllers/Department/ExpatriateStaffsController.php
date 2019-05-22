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
use App\Models\Department\ExpatriateStaff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class ExpatriateStaffsController extends Controller
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

        $filteredExpatriates = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->id == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->id == $requestedCollege) {
                            foreach ($college->departments as $department) {
                                foreach ($department->academicStaffs as $staff) {
                                    if (strtoupper($staff->staff_rank) == $requestedLevel) {
                                        $filteredExpatriates[] = $staff;
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

        $data = [
            'rank_level' => $requestedLevel,
            'expatriate_staff' => $filteredExpatriates,
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'page_name' => 'departments.expatriate_staff.index'
        ];

        return view('departments.expatriate_staff.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'staff_rank' => ExpatriateStaff::getEnum('StaffRank'),
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'departments.expatriate_staff.create'
        ];

        return view('departments.expatriate_staff.create')->with('data', $data);
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
            'female_number' => 'required',
        ]);

        $expat = new ExpatriateStaff();
        $expat->male_number = $request->input('male_number');
        $expat->female_number = $request->input('female_number');
        $expat->staff_rank = $request->input('staff_rank');

        // die($request->input('staff_rank'));


        $user = Auth::user();

        $institution = $user->institution();

        $bandName = BandName::where('band_name', $request->input("band"))->first();
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = CollegeName::where('college_name', $request->input("college"))->first();
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
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
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->expatriates()->save($expat);

        return redirect("/department/expatriate-staff");
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
