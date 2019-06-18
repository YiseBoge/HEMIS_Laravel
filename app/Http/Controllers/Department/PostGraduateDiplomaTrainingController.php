<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\PostGraduateDiplomaTraining;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostGraduateDiplomaTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        if ($request->input('type') == null) {
            $requestedType = 0;
        } else if ($request->input('type') == "Normal") {
            $requestedType = 0;
        } else {
            $requestedType = 1;
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $trainings = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->id == $user->bandName->id) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->id == $user->collegeName->id && $college->education_level == "None" && $college->education_program == $requestedProgram) {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->id == $user->departmentName->id && $department->year_level == "None") {
                                    foreach ($department->postgraduateDiplomaTrainings as $training) {
                                        if ($training->is_lead == $requestedType) {
                                            $trainings[] = $training;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $training = PostGraduateDiplomaTraining::with('department')->get();
        }

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'trainings' => $trainings,
            'programs' => PostGraduateDiplomaTraining::getEnum("Programs"),
            'types' => PostGraduateDiplomaTraining::getEnum('Types'),
            'page_name' => 'departments.postgraduate_diploma_training.index',

            'selected_type' => $requestedType,
            'selected_program' => $requestedProgram

        );
        return view("departments.postgraduate_diploma_training.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $data = array(
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => PostGraduateDiplomaTraining::getEnum("Programs"),
            'types' => PostGraduateDiplomaTraining::getEnum('Types'),
            'page_name' => 'departments.postgraduate_diploma_training.create'
        );

        return view("departments.postgraduate_diploma_training.create")->with($data);

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

        $training = new PostGraduateDiplomaTraining;
        $training->number_of_male_students = $request->input('male_number');
        $training->number_of_female_students = $request->input('female_number');
        if ($request->input('type') == "NORMAL") {
            $training->is_lead = 0;
        } else {
            $training->is_lead = 1;
        }

        $user = Auth::user();
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
            'education_level' => "None", 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = $request->input("program");
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

        $department->postgraduateDiplomaTrainings()->save($training);

        return redirect("/department/postgraduate-diploma-training");
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
