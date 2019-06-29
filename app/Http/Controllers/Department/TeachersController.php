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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TeachersController extends Controller
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $requestedCollege = $request->input('college');
        if ($requestedCollege == null) {
            $requestedCollege = null;
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }

        $requestedBand = $request->input('band');
        if ($requestedBand == null) {
            $requestedBand = null;
        }

        $teachers = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $requestedCollege && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->departments as $department) {
                                if ($department->year_level == "None") {
                                    foreach ($department->teachers as $teacher) {
                                        if ($teacher->level_of_education == $requestedLevel) {
                                            $teachers[] = $teacher;
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

            'selected_college' => $requestedCollege,
            'selected_level' => $requestedLevel,
            'selected_band' => $requestedBand,
            'page_name' => 'staff.teachers.index'
        );
        //return $filteredEnrollments;
        return view("departments.teachers.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $data = array(
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'education_levels' => Teacher::getEnum("EducationLevels"),
            'page_name' => 'staff.teachers.create'
        );
        return view('departments.teachers.create')->with($data);
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
            'female_number' => 'required',
            'citizenship' => 'required'
        ]);

        $teacher = new Teacher;
        $teacher->male_number = $request->input('male_number');
        $teacher->female_number = $request->input('female_number');
        $teacher->level_of_education = $request->input('education_level');
        $teacher->citizenship = $request->input('citizenship');


        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

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

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
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
